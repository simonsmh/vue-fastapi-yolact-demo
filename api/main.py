import logging
from io import BytesIO

import uvicorn
from fastapi import Body, Depends, FastAPI, File, Request, UploadFile

from sqlalchemy.orm import Session

from .database import SessionLocal, UserIn, add_user, delete_user, get_user, get_users
from .yolo_minimal.detect import detect_init, detect, parse_name

app = FastAPI(openapi_prefix="/api")
logger = logging.getLogger()
model = detect_init(cfg="yolov3-spp-buoy.cfg", weights="best_buoy.pt", img_size=512)


@app.get("/")
async def read_root():
    return {"return": 200}


@app.get("/ip")
async def read_ip(request: Request):
    client_host = request.client.host
    return {"return": 200, "client_host": client_host}


# Minimal PyTorch yolo detect application
@app.get("/yolo")
async def get_model_info():
    (name, labels) = parse_name(files="buoy.names")
    return {"return": 200, "name": name, "labels": labels}


@app.post("/yolo")
async def detect_image(image: UploadFile = File(...)):
    data = BytesIO(image.file.read())
    return {
        "return": 200,
        "result": detect(data.read(), model, img_size=512,),
    }


# Dependency
def get_db():
    try:
        db = SessionLocal()
        yield db
    finally:
        db.close()


# SQL Process
@app.get("/chatboard/all")
async def read_users(db: Session = Depends(get_db)):
    return {"return": 200, "user": get_users(db)}


@app.get("/chatboard/{uid}")
async def read_user(uid: str, db: Session = Depends(get_db)):
    return {"return": 200, "user": get_user(db, uid)}


@app.delete("/chatboard/{uid}")
async def remove_user(
    uid: str, request: Request, db: Session = Depends(get_db),
):
    ip = request.client.host
    if user := get_user(db, uid):
        if ip == user.ip:
            delete_user(db, uid)
            return {"return": 200, "user": get_users(db)}
    else:
        return {"return": 200, "user": get_users(db, 400)}


@app.put("/chatboard", status_code=201)
async def create_user(
    request: Request, user: UserIn = Body(...), db: Session = Depends(get_db)
):
    logger.info(f"Setting database: {user.name} {user.email}")
    ip = request.client.host
    add_user(db, user, ip)
    return {"return": 201, "user": get_users(db)}


if __name__ == "__main__":
    uvicorn.run(app, host="127.0.0.1", port=8000)
