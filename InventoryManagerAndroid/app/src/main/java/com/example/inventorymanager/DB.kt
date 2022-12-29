package com.example.inventorymanager

import android.content.Context
import android.database.sqlite.SQLiteDatabase
import android.database.sqlite.SQLiteOpenHelper

class DB(context: Context) :
    SQLiteOpenHelper(context, "users_db", null, 1) {

    override fun onCreate(db: SQLiteDatabase?) {
        val create =
            "CREATE TABLE users (_id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT NOT NULL UNIQUE, password TEXT NOT NULL)"
        db?.execSQL(create)
        val insert =
            "INSERT INTO users (email,password) VALUES ('user@gmail.com','1234'), ('teacher@gmail.com','1234')"
        db?.execSQL(insert)
    }

    override fun onUpgrade(db: SQLiteDatabase?, oldVersion: Int, newVersion: Int) {
        val delete = "DROP TABLE IF EXISTS users"
        db!!.execSQL(delete)
        onCreate(db)
    }


}