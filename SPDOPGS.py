from flask import Flask, request, jsonify
import sqlite3

app = Flask(__name__)


@app.route('/receber_valores', methods=['POST'])
def receber_valores():
    #usuario = request.form.get('usuario')
    #senha = request.form.get('senha')
    ordem = request.form.get('ordem')
    #dados_adicionais = request.form.get('dados_adicionais')



    conn = sqlite3.connect('IA08.db')
    cursor = conn.cursor()

    cursor.execute('SELECT * FROM DATAOP WHERE ORDEM = ?'+ (ordem))
    resultado = cursor.fetchall()

    conn.close()

    return jsonify({'resultado': resultado})

if __name__ == '__main__':
    app.run(debug=True)
