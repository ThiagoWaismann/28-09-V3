import sys
import sqlite3

def consulta_centro(material, centro):
    # Conectar ao banco de dados
    conn = sqlite3.connect('IA08.db')
    cursor = conn.cursor()

    # Consulta para obter JJ e CONTENTOR
    cursor.execute("SELECT JJ, CONTENTOR FROM JUNJO WHERE CENTRO = ? AND MATERIAL = ?", (centro, material[-8:]))
    jj, contentor = cursor.fetchone()

    # Fechar conexão com o banco de dados
    conn.close()

    return jj, contentor

def consulta_data1(material):
    # Conectar ao banco de dados
    conn = sqlite3.connect('IA08.db')
    cursor = conn.cursor()

    # Consulta para obter LOCAL, TIPO, QUANTIDADE
    cursor.execute("SELECT LOCAL, TIPO, QUANTIDADE FROM DATA1 WHERE MATERIAL = ?", (material,))
    local, tipo, quantidade = cursor.fetchone()

    # Fechar conexão com o banco de dados
    conn.close()

    return local, tipo, quantidade

# Receber os argumentos da linha de comando
material = sys.argv[1]
centro = sys.argv[2]

# Chamar as funções de consulta
jj, contentor = consulta_centro(material, centro)
local, tipo, quantidade = consulta_data1(material)

# Imprimir os valores separados por |
print(f"{local}|{tipo}|{quantidade}|{jj}|{contentor}")

