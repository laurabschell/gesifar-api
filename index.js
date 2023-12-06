const express = require('express')
const cors = require('cors')
const mysql = require('mysql')
const bodyParser = require('body-parser')
const app = express()
app.use(cors())
app.use(bodyParser.urlencoded({ extended: false }))
app.use(bodyParser.json({ limit: '10mb' }))
// const JWT = require('jsonwebtoken')
// const secretWord = 'Samus#Aran'

const credentials = {
	host: 'localhost',
	user: 'root',
	password: '',
	database: 'gesifar-api'
}

app.get('/', (req, res) => {
	res.send('hola desde tu primera ruta de la Api')
})

app.post('/api/login', (req, res) => {
	const { email, password, name, lastname } = req.body
	const values = [email, password, name, lastname ]
	var connection = mysql.createConnection(credentials)
	connection.query("SELECT * FROM usuarios WHERE email = ? AND password = ?", values, (err, result) => {
		if (err) {
			res.status(500).send(err)
		} else {
			if (result.length > 0) {
				res.status(200).send({
					"id": result[0].id,
					"email": result[0].email,
					"name": result[0].name,
					"lastname": result[0].lastname,
					"role": result[0].role,
				})
			} else {
				res.status(400).send('Usuario no existe')
			}
		}
	})
	connection.end()
})


app.listen(4000, () => console.log('hola soy el servidor en 4000:'))