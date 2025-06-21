from flask import Flask, request, jsonify
from flask_cors import CORS
import sys
import os
import json

# Agregar el directorio actual al path para importar nuestro módulo
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

# Importar nuestro sistema ML
from test_vocacional_ml import TestVocacionalML

app = Flask(__name__)
CORS(app)

# Configuración de la base de datos
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',  # Cambiar por tu usuario
    'password': '',  # Cambiar por tu contraseña
    'database': 'spicegirls_cousin2'
}

# Inicializar el sistema ML
ml_system = TestVocacionalML(DB_CONFIG)

@app.route('/predecir', methods=['POST'])
def predecir():
    try:
        data = request.get_json()
        respuestas = data.get('respuestas', {})
        
        # Convertir keys a enteros si vienen como strings
        respuestas_int = {}
        for key, value in respuestas.items():
            respuestas_int[int(key)] = value
        
        resultado = ml_system.predecir(respuestas_int)
        
        return jsonify({
            'success': True,
            'curso': resultado['curso'],
            'probabilidad': round(resultado['probabilidad'], 2),
            'todas_probabilidades': {k: round(v, 2) for k, v in resultado['todas_probabilidades'].items()}
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/entrenar', methods=['POST'])
def entrenar():
    try:
        data = request.get_json()
        datos_entrenamiento = data.get('datos', [])
        
        if not datos_entrenamiento:
            # Si no hay datos específicos, usar el generador automático
            metricas = ml_system.entrenar_modelo()
        else:
            # Implementar entrenamiento con datos específicos
            # (Aquí puedes expandir la funcionalidad)
            metricas = ml_system.entrenar_modelo()
        
        return jsonify({
            'success': True,
            'metricas': {
                'accuracy': round(metricas['accuracy'] * 100, 2),
                'precision': round(metricas['precision'] * 100, 2),
                'recall': round(metricas['recall'] * 100, 2),
                'f1_score': round(metricas['f1_score'] * 100, 2)
            }
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/estado', methods=['GET'])
def estado():
    try:
        # Verificar si el modelo está cargado
        modelo_cargado = ml_system.model is not None
        
        if not modelo_cargado:
            ml_system.cargar_modelo()
            modelo_cargado = ml_system.model is not None
        
        return jsonify({
            'success': True,
            'modelo_cargado': modelo_cargado,
            'clases_disponibles': list(ml_system.label_encoder.classes_) if modelo_cargado else []
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/metricas', methods=['GET'])
def obtener_metricas():
    try:
        conn = ml_system.conectar_db()
        cursor = conn.cursor(dictionary=True)
        
        # Obtener las últimas métricas
        cursor.execute("""
            SELECT * FROM ml_metricas 
            ORDER BY fecha_entrenamiento DESC 
            LIMIT 1
        """)
        
        ultima_metrica = cursor.fetchone()
        
        # Obtener estadísticas de predicciones
        cursor.execute("""
            SELECT 
                COUNT(*) as total_predicciones,
                AVG(probabilidad) as probabilidad_promedio,
                curso_predicho,
                COUNT(*) as frecuencia
            FROM ml_predicciones 
            GROUP BY curso_predicho
            ORDER BY frecuencia DESC
        """)
        
        estadisticas_predicciones = cursor.fetchall()
        
        cursor.close()
        conn.close()
        
        return jsonify({
            'success': True,
            'ultima_metrica': ultima_metrica,
            'estadisticas_predicciones': estadisticas_predicciones
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({
        'status': 'healthy',
        'service': 'Test Vocacional ML API',
        'version': '1.0'
    })

if __name__ == '__main__':
    print("Iniciando API de Machine Learning para Test Vocacional...")
    print("Verificando conexión a base de datos...")
    
    try:
        # Verificar conexión a base de datos
        conn = ml_system.conectar_db()
        conn.close()
        print("✓ Conexión a base de datos exitosa")
        
        # Cargar o entrenar modelo
        print("Cargando modelo de Machine Learning...")
        ml_system.cargar_modelo()
        print("✓ Modelo cargado exitosamente")
        
        print("API lista en http://localhost:5000")
        app.run(host='0.0.0.0', port=5000, debug=True)
        
    except Exception as e:
        print(f"✗ Error inicializando la API: {e}")
        print("Por favor verifica la configuración de la base de datos")