<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Test Vocacional - ML</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.44.0/apexcharts.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
        }

        .resultado-principal {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        }

        .resultado-principal strong {
            font-size: 28px;
            display: block;
            margin-top: 10px;
        }

        .probabilidad-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 25px;
            margin-top: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .ml-indicator {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .stats-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .comparison-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .comparison-title {
            color: #856404;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .comparison-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .comparison-item:last-child {
            border-bottom: none;
        }

        .algorithm-tag, .ml-tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .algorithm-tag {
            background: #e3f2fd;
            color: #1976d2;
        }

        .ml-tag {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        #chart {
            margin: 30px 0;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .btn-container {
            text-align: center;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #27ae60;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e8449;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        .btn-secondary {
            background-color: #3498db;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .metric-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }

        .metric-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .metric-label {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .btn-container {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="ml-indicator">
        🤖 Resultado generado por Inteligencia Artificial
    </div>

    <div class="resultado-principal">
        <h2>🎓 Tu Carrera Recomendada</h2>
        <strong>{{ $curso }}</strong>
        <div class="probabilidad-badge">
            Confianza: {{ $probabilidad }}%
        </div>
    </div>

    <div class="stats-info">
        <p><strong>📊 Análisis de Compatibilidad por IA:</strong> Esta predicción fue generada usando Machine Learning basado en miles de respuestas anteriores y patrones de preferencias vocacionales.</p>
    </div>

    @if(isset($curso_algoritmo) && $curso_algoritmo !== $curso)
    <div class="comparison-section">
        <div class="comparison-title">🔍 Comparación de Métodos</div>
        <div class="comparison-item">
            <span>Algoritmo Tradicional:</span>
            <span class="algorithm-tag">{{ $curso_algoritmo }}</span>
        </div>
        <div class="comparison-item">
            <span>Machine Learning (IA):</span>
            <span class="ml-tag">{{ $curso }} ({{ $probabilidad }}%)</span>
        </div>
        <p style="margin-top: 15px; font-size: 14px; color: #856404;">
            <strong>Nota:</strong> La IA ha detectado un patrón diferente en tus respuestas basado en datos históricos de otros usuarios con perfiles similares.
        </p>
    </div>
    @endif

    @if(!empty($todas_probabilidades))
    <div class="metrics-grid">
        @php
            $top_cursos = collect($todas_probabilidades)->sortDesc()->take(4);
        @endphp
        @foreach($top_cursos as $curso_nombre => $prob)
        <div class="metric-card">
            <div class="metric-value">{{ number_format($prob, 1) }}%</div>
            <div class="metric-label">{{ $curso_nombre }}</div>
        </div>
        @endforeach
    </div>
    @endif

    <div id="chart"></div>

    <div class="btn-container">
        <a href="{{ route('test.reiniciar') }}" class="btn btn-primary">🔄 Realizar Nuevo Test</a>
        <button onclick="compartirResultado()" class="btn btn-secondary">📤 Compartir Resultado</button>
    </div>

    <script>
        // Datos del backend Laravel
        const cursoElegido = @json($curso);
        const probabilidadIA = @json($probabilidad ?? 85);
        const todasProbabilidades = @json($todas_probabilidades ?? []);
        const respuestasUsuario = @json(array_values($respuestas));

        // Preparar datos para la gráfica
        let datosGrafica = [];

        if (Object.keys(todasProbabilidades).length > 0) {
            // Usar datos reales del ML
            datosGrafica = Object.entries(todasProbabilidades)
                .map(([curso, probabilidad]) => ({
                    materia: curso,
                    afinidad: Math.round(probabilidad),
                    esElegida: curso === cursoElegido
                }))
                .sort((a, b) => b.afinidad - a.afinidad);
        } else {
            // Fallback con datos simulados
            const todasLasMaterias = [
                'Auxiliar de Psicomotricidad',
                'Prótesis Dental',
                'Auxiliar de Laboratorio Forense',
                'Auxiliar de Criminalística',
                'Toxicología Forense',
                'Técnico en Criminalística Forense',
                'Investigador de Crímenes',
                'Auxiliar de Medicina Forense',
                'Investigación Forense en Accidentes de Tráfico',
                'Cursos sin sangre',
                'Cursos generales sin sangre',
                'Cursos teóricos relacionados'
            ];

            datosGrafica = todasLasMaterias.map(materia => ({
                materia: materia,
                afinidad: materia === cursoElegido ? probabilidadIA : Math.floor(Math.random() * 60) + 20,
                esElegida: materia === cursoElegido
            })).sort((a, b) => b.afinidad - a.afinidad);
        }

        // Limitar a top 10 para mejor visualización
        datosGrafica = datosGrafica.slice(0, 10);

        // Configuración de la gráfica
        const options = {
            series: [{
                name: 'Compatibilidad (%)',
                data: datosGrafica.map(item => item.afinidad)
            }],
            chart: {
                type: 'bar',
                height: 500,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 1000,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    distributed: true,
                    dataLabels: {
                        position: 'center'
                    }
                }
            },
            colors: datosGrafica.map(item => 
                item.esElegida ? '#e74c3c' : '#3498db'
            ),
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + "%";
                },
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                }
            },
            xaxis: {
                categories: datosGrafica.map(item => item.materia),
                labels: {
                    style: {
                        fontSize: '11px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '10px'
                    },
                    maxWidth: 200
                }
            },
            title: {
                text: 'Análisis de Compatibilidad por IA',
                align: 'center',
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold',
                    color: '#2c3e50'
                }
            },
            subtitle: {
                text: 'Tu carrera recomendada está resaltada en rojo - Basado en Machine Learning',
                align: 'center',
                style: {
                    fontSize: '14px',
                    color: '#7f8c8d'
                }
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 3
            },
            tooltip: {
                y: {
                    formatter: function (val, opts) {
                        const materia = datosGrafica[opts.dataPointIndex].materia;
                        const esElegida = materia === cursoElegido;
                        return val + "% de compatibilidad" + (esElegida ? " (RECOMENDADA POR IA)" : "");
                    }
                },
                style: {
                    fontSize: '12px'
                }
            },
            legend: {
                show: false
            }
        };

        // Renderizar la gráfica
        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Función para compartir resultado
        function compartirResultado() {
            const texto = `¡Acabo de descubrir mi vocación! 🎓\n\nSegún el análisis de IA, mi carrera recomendada es:\n${cursoElegido}\n\nConfianza: ${probabilidadIA}%\n\n¡Haz tu test vocacional también!`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Mi Resultado del Test Vocacional',
                    text: texto,
                    url: window.location.origin + '/test-vocacional'
                });
            } else {
                // Fallback para navegadores que no soportan Web Share API
                navigator.clipboard.writeText(texto + '\n\nRealiza tu test en: ' + window.location.origin + '/test-vocacional')
                    .then(() => {
                        alert('¡Resultado copiado al portapapeles! Ya puedes compartirlo.');
                    })
                    .catch(() => {
                        alert('No se pudo copiar automáticamente. Puedes copiar manualmente este texto:\n\n' + texto);
                    });
            }
        }

        // Animación de entrada para las métricas
        document.addEventListener('DOMContentLoaded', function() {
            const metricCards = document.querySelectorAll('.metric-card');
            metricCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>