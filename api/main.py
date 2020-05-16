import logging
import uuid

# from io import BytesIO

import uvicorn
from fastapi import Body, Depends, FastAPI, File, Request, UploadFile
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy.orm import Session

from .yolo_minimal.detect import detect, parse_name

from .database import SessionLocal, UserIn, add_user, delete_user, get_user, get_users

app = FastAPI()
logger = logging.getLogger()

origins = [
    "http://localhost",
    "https://localhost",
    "http://localhost:8080",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


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
    return {
        "return": 200,
        "result": detect(
            image.file.read(),
            cfg="yolov3-spp-buoy.cfg",
            weights="best_buoy.pt",
            img_size=512,
        ),
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
