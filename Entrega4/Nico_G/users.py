from flask import Flask, json
from pymongo import MongoClient

USER = 'grupo37'
PASS = 'grupo37'
DATABASE = 'grupo37'

URL = f"mongodb://{USER}:{PASS}@gray.ing.puc.cl/{DATABASE}?authSource=admin"
client = MongoClient(URL)

# Nombre BD
db = client["grupo37"]

app = Flask(__name__)

@app.route("/")
def home():
	'''
	Página de inicio
	'''
	return "<h1>Hello World!</h1>"

@app.route("/users")
def getUsers():
	users = list(db.usuarios.find({}, {"_id": 0}))
	print(users)
	return json.jsonify(users)

@app.route("/users/<int:uid>")
def getUser(uid):
	user = list(db.usuarios.find({"uid":uid}, {"_id": 0}))
	user_messages = list(db.mensajes.find({"sender":uid}, {"_id": 0}))
	response = user.copy()
	response.extend(user_messages)
	print(response)
	return json.jsonify(response)

if __name__ == "__main__":
	app.run()
	app.run(debug=True)