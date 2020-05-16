import datetime
import logging
import uuid

from pydantic import BaseModel, constr
from sqlalchemy import (
    Column,
    DateTime,
    String,
    create_engine,
)
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import Session, sessionmaker

logger = logging.getLogger()

SQLALCHEMY_DATABASE_URL = "sqlite:///./storage.db"
engine = create_engine(
    SQLALCHEMY_DATABASE_URL, connect_args={"check_same_thread": False}
)
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)


# pydantic model
class UserIn(BaseModel):
    name: constr(strip_whitespace=True, min_length=1, max_length=10)
    email: constr(strip_whitespace=True, min_length=1, regex=r".*@.*")
    text: constr(strip_whitespace=True, min_length=1, max_length=233)


# Database model

Base = declarative_base()


class DBUser(Base):
    __tablename__ = "chatboard"
    name = Column(String)
    email = Column(String)
    text = Column(String)
    time = Column(DateTime, default=datetime.datetime.now)
    uid = Column(String, primary_key=True)
    ip = Column(String)


Base.metadata.create_all(bind=engine)


# Database functions


def get_user(db: Session, uid: String):
    row = db.query(DBUser).filter(DBUser.uid == uid).first()
    return row


def get_users(db: Session, skip: int = 0, limit: int = 100, reverse: bool = True):
    row = db.query(DBUser).offset(skip).limit(limit).all()
    if reverse:
        row.reverse()
    return row


def add_user(db: Session, user: UserIn, ip: String):
    db_user = DBUser(
        name=user.name, email=user.email, text=user.text, ip=ip, uid=str(uuid.uuid4())
    )
    db.add(db_user)
    db.commit()
    return db_user


def delete_user(db: Session, uid: String):
    db_user = db.query(DBUser).filter(DBUser.uid == uid).first()
    db.delete(db_user)
    db.commit()
    return db_user
