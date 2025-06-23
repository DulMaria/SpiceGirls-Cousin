import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, precision_score, recall_score, f1_score, classification_report
from sklearn.preprocessing import LabelEncoder
import joblib
import mysql.connector
import json
import warnings
warnings.filterwarnings('ignore')

class TestVocacionalML:
    def __init__(self, db_config):
        self.db_config = db_config
        self.model = None
        self.label_encoder = LabelEncoder()
        self.feature_names = [
            'sangre_crimenes', 'cuerpo_movimiento', 'rehabilitacion', 'tecnologia_lab',
            'analisis_tecnico', 'teorico_practico', 'legal_admin', 'teoria_practica',
            'sustancias_quimicas', 'toxicologia', 'evidencias', 'solo_equipo',
            'analisis_detallado', 'crimenes_accidentes', 'medicina_accidentes'
        ]
        
    def conectar_db(self):
        return mysql.connector.connect(**self.db_config)
    
    def generar_datos_entrenamiento(self, num_samples=1000):
        """Genera datos de entrenamiento simulando el algoritmo original"""
        datos = []
        
        for _ in range(num_samples):
            # Generar respuestas aleatorias
            respuestas = {}
            
            # P0: ¿Te sientes cómodo trabajando con sangre o escenas de crímenes?
            respuestas[0] = np.random.choice(['Sí', 'No'])
            
            if respuestas[0] == 'No':
                # P1: ¿Prefieres trabajos relacionados con el cuerpo y el movimiento físico?
                respuestas[1] = np.random.choice(['Sí', 'No'])
                
                if respuestas[1] == 'Sí':
                    # P2: ¿Quieres ayudar en la rehabilitación o desarrollo físico?
                    respuestas[2] = np.random.choice(['Sí', 'No'])
                    curso = 'Auxiliar de Psicomotricidad' if respuestas[2] == 'Sí' else 'Prótesis Dental'
                else:
                    # P3: ¿Te gusta trabajar con tecnología y detalles en laboratorio?
                    respuestas[3] = np.random.choice(['Sí', 'No'])
                    
                    if respuestas[3] == 'Sí':
                        # P4: ¿Quieres especializarte en análisis y pruebas técnicas?
                        respuestas[4] = np.random.choice(['Sí', 'No'])
                        curso = 'Auxiliar de Laboratorio Forense' if respuestas[4] == 'Sí' else 'Cursos sin sangre'
                    else:
                        # P5: ¿Prefieres un trabajo teórico o práctico?
                        respuestas[5] = np.random.choice(['Teórico', 'Práctico'])
                        
                        if respuestas[5] == 'Teórico':
                            # P6: ¿Quieres apoyar en la parte legal o administrativa?
                            respuestas[6] = np.random.choice(['Sí', 'No'])
                            curso = 'Auxiliar de Criminalística' if respuestas[6] == 'Sí' else 'Cursos generales sin sangre'
                        else:
                            curso = 'Cursos generales sin sangre'
            else:
                # P7: ¿Prefieres trabajar con teoría o práctica?
                respuestas[7] = np.random.choice(['Teoría', 'Práctica'])
                
                if respuestas[7] == 'Teoría':
                    # P8: ¿Quieres analizar sustancias químicas o biológicas?
                    respuestas[8] = np.random.choice(['Sí', 'No'])
                    
                    if respuestas[8] == 'Sí':
                        # P9: ¿Te interesa la toxicología y manejo de muestras biológicas?
                        respuestas[9] = np.random.choice(['Sí', 'No'])
                        curso = 'Toxicología Forense' if respuestas[9] == 'Sí' else 'Auxiliar de Criminalística'
                    else:
                        # P10: ¿Quieres enfocarte en la recolección y análisis de evidencias?
                        respuestas[10] = np.random.choice(['Sí', 'No'])
                        curso = 'Auxiliar de Criminalística' if respuestas[10] == 'Sí' else 'Cursos teóricos relacionados'
                else:
                    # P11: ¿Prefieres trabajar solo o en equipo?
                    respuestas[11] = np.random.choice(['Solo', 'Equipo'])
                    
                    if respuestas[11] == 'Solo':
                        # P12: ¿Quieres trabajar en análisis detallado y técnico?
                        respuestas[12] = np.random.choice(['Sí', 'No'])
                        curso = 'Técnico en Criminalística Forense' if respuestas[12] == 'Sí' else 'Auxiliar de Laboratorio Forense'
                    else:
                        # P13: ¿Te interesa investigar crímenes o accidentes?
                        respuestas[13] = np.random.choice(['Crímenes', 'Accidentes de Tráfico'])
                        
                        if respuestas[13] == 'Crímenes':
                            curso = 'Investigador de Crímenes'
                        else:
                            # P14: ¿Prefieres especializarte en medicina forense o investigación de accidentes?
                            respuestas[14] = np.random.choice(['Medicina Forense', 'Accidentes de Tráfico'])
                            curso = 'Auxiliar de Medicina Forense' if respuestas[14] == 'Medicina Forense' else 'Investigación Forense en Accidentes de Tráfico'
            
            datos.append({
                'respuestas': respuestas,
                'curso': curso
            })
        
        return datos
    
    def procesar_respuestas(self, respuestas_dict):
        """Convierte las respuestas en características numéricas"""
        print(f"Procesando respuestas: {respuestas_dict}")
        
        features = []
        
        # Mapeo de respuestas a valores numéricos
        mapeo = {
            'Sí': 1, 'No': 0,
            'Teórico': 0, 'Práctico': 1,
            'Teoría': 0, 'Práctica': 1,
            'Solo': 0, 'Equipo': 1,
            'Crímenes': 0, 'Accidentes de Tráfico': 1,
            'Medicina Forense': 0, 'Accidentes de Tráfico': 1
        }
        
        for i in range(15):
            if i in respuestas_dict and respuestas_dict[i] is not None:
                valor = mapeo.get(respuestas_dict[i], 0)
                features.append(valor)
                print(f"  Pregunta {i}: '{respuestas_dict[i]}' -> {valor}")
            else:
                # Para respuestas faltantes, usar un valor neutral (-1)
                # que el modelo pueda interpretar como "no respondido"
                features.append(-1)
                print(f"  Pregunta {i}: No respondido -> -1")
        
        print(f"Features finales: {features}")
        return features
    
    def entrenar_modelo(self):
        """Entrena el modelo de machine learning"""
        print("Generando datos de entrenamiento...")
        datos = self.generar_datos_entrenamiento(3000)  # Más datos para mejor entrenamiento
        
        # Preparar datos
        X = []
        y = []
        
        for dato in datos:
            features = self.procesar_respuestas(dato['respuestas'])
            X.append(features)
            y.append(dato['curso'])
        
        X = np.array(X)
        y = np.array(y)
        
        # Codificar etiquetas
        y_encoded = self.label_encoder.fit_transform(y)
        
        # Dividir datos
        X_train, X_test, y_train, y_test = train_test_split(
            X, y_encoded, test_size=0.2, random_state=42, stratify=y_encoded
        )
        
        # Entrenar modelo con mejores parámetros para manejar valores faltantes
        print("Entrenando modelo...")
        self.model = RandomForestClassifier(
            n_estimators=200,  # Más árboles
            max_depth=15,      # Más profundidad
            min_samples_split=5,
            min_samples_leaf=2,
            random_state=42,
            class_weight='balanced',
            n_jobs=-1  # Usar todos los cores disponibles
        )
        
        self.model.fit(X_train, y_train)
        
        # Evaluar modelo
        y_pred = self.model.predict(X_test)
        
        accuracy = accuracy_score(y_test, y_pred)
        precision = precision_score(y_test, y_pred, average='weighted', zero_division=0)
        recall = recall_score(y_test, y_pred, average='weighted', zero_division=0)
        f1 = f1_score(y_test, y_pred, average='weighted', zero_division=0)
        
        print(f"Accuracy: {accuracy:.4f}")
        print(f"Precision: {precision:.4f}")
        print(f"Recall: {recall:.4f}")
        print(f"F1-Score: {f1:.4f}")
        
        # Mostrar importancia de características
        importancias = self.model.feature_importances_
        print("\nImportancia de características:")
        for i, importancia in enumerate(importancias):
            if importancia > 0.05:  # Solo mostrar las más importantes
                print(f"  Pregunta {i}: {importancia:.4f}")
        
        # Guardar métricas en base de datos
        self.guardar_metricas(accuracy, precision, recall, f1)
        
        # Guardar modelo
        joblib.dump(self.model, 'test_vocacional_model.pkl')
        joblib.dump(self.label_encoder, 'label_encoder.pkl')
        
        print("Modelo entrenado y guardado exitosamente!")
        
        return {
            'accuracy': accuracy,
            'precision': precision,
            'recall': recall,
            'f1_score': f1
        }
    
    def cargar_modelo(self):
        """Carga un modelo previamente entrenado"""
        try:
            self.model = joblib.load('test_vocacional_model.pkl')
            self.label_encoder = joblib.load('label_encoder.pkl')
            print("Modelo cargado exitosamente!")
            return True
        except FileNotFoundError:
            print("No se encontró un modelo entrenado. Entrenando nuevo modelo...")
            self.entrenar_modelo()
            return True
    
    def predecir(self, respuestas_usuario):
        """Realiza una predicción basada en las respuestas del usuario"""
        if self.model is None:
            self.cargar_modelo()
        
        print(f"Realizando predicción con respuestas: {respuestas_usuario}")
        
        # Procesar respuestas
        features = self.procesar_respuestas(respuestas_usuario)
        features = np.array(features).reshape(1, -1)
        
        # Realizar predicción
        prediccion = self.model.predict(features)[0]
        probabilidades = self.model.predict_proba(features)[0]
        
        # Decodificar resultado
        curso_predicho = self.label_encoder.inverse_transform([prediccion])[0]
        probabilidad_maxima = max(probabilidades) * 100
        
        print(f"Curso predicho: {curso_predicho} con {probabilidad_maxima:.2f}% de confianza")
        
        # Crear diccionario de todas las probabilidades
        todas_probabilidades = {}
        for i, clase in enumerate(self.label_encoder.classes_):
            todas_probabilidades[clase] = probabilidades[i] * 100
        
        # Ordenar por probabilidad
        todas_probabilidades = dict(sorted(todas_probabilidades.items(), key=lambda x: x[1], reverse=True))
        
        # Guardar predicción en base de datos
        self.guardar_prediccion(respuestas_usuario, curso_predicho, probabilidad_maxima)
        
        return {
            'curso': curso_predicho,
            'probabilidad': probabilidad_maxima,
            'todas_probabilidades': todas_probabilidades
        }
    
    def guardar_prediccion(self, respuestas, curso, probabilidad):
        """Guarda la predicción en la base de datos"""
        try:
            conn = self.conectar_db()
            cursor = conn.cursor()
            
            query = """
            INSERT INTO ml_predicciones (respuestas, curso_predicho, probabilidad, modelo_version)
            VALUES (%s, %s, %s, %s)
            """
            
            cursor.execute(query, (
                json.dumps(respuestas),
                curso,
                probabilidad,
                'v1.1'  # Versión actualizada
            ))
            
            conn.commit()
            cursor.close()
            conn.close()
            print("Predicción guardada en base de datos")
        except Exception as e:
            print(f"Error guardando predicción: {e}")
    
    def guardar_metricas(self, accuracy, precision, recall, f1):
        """Guarda las métricas del modelo en la base de datos"""
        try:
            conn = self.conectar_db()
            cursor = conn.cursor()
            
            query = """
            INSERT INTO ml_metricas (modelo_version, accuracy, precision_score, recall_score, f1_score)
            VALUES (%s, %s, %s, %s, %s)
            """
            
            cursor.execute(query, (
                'v1.1',  # Versión actualizada
                accuracy * 100,
                precision * 100,
                recall * 100,
                f1 * 100
            ))
            
            conn.commit()
            cursor.close()
            conn.close()
            print("Métricas guardadas en base de datos")
        except Exception as e:
            print(f"Error guardando métricas: {e}")

# Configuración de la base de datos
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'spicegirls_cousin2'
}

# Ejemplo de uso
if __name__ == "__main__":
    # Inicializar el sistema ML
    ml_system = TestVocacionalML(DB_CONFIG)
    
    # Entrenar el modelo
    metricas = ml_system.entrenar_modelo()
    
    # Ejemplo de predicción con respuestas incompletas (rama "No")
    respuestas_ejemplo_no = {
        0: 'No',    # No cómodo con sangre
        1: 'Sí',    # No prefiere cuerpo y movimiento
        2: 'No',    # Sí gusta tecnología
    }
    
    resultado = ml_system.predecir(respuestas_ejemplo_no)
    print(f"\nPredicción (rama No): {resultado['curso']}")
    print(f"Probabilidad: {resultado['probabilidad']:.2f}%")
    
    # Ejemplo de predicción con respuestas completas (rama "Sí")
    respuestas_ejemplo_si = {
        0: 'Sí',
        7: 'Práctica',
        11: 'Equipo',
        13: 'Crímenes'
    }
    
    resultado2 = ml_system.predecir(respuestas_ejemplo_si)
    print(f"\nPredicción (rama Sí): {resultado2['curso']}")
    print(f"Probabilidad: {resultado2['probabilidad']:.2f}%")
        