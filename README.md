px-technical-challenges
Teste Técnico: Motor de Avaliação de Risco para Transporte de Carga
Olá novamente!

Conforme conversamos, este é o nosso desafio técnico. Lembre-se, o objetivo principal é entendermos a sua forma de pensar e comunicar ideias.

Contexto da Empresa: Somos uma empresa de tecnologia no setor de logística. Uma das nossas soluções atua como motores de decisão e recomendação, baseadas em regras de negócio, para ajudar otimizar operações e mitigar perdas.

Objetivo Deste Teste (Relembrando):

O foco não é entregar um software completo ou código otimizado para produção dentro do tempo.
Queremos observar como você analisa um problema de negócio, modela os dados envolvidos, pensa na lógica de regras e como comunica seu processo de decisão e suas ideias.
Tempo para desenvolvimento/discussão da solução: aproximadamente 1 hora a 1 hora e 30 minutos.
O Desafio:

Imagine que precisamos desenvolver um novo módulo para o nosso sistema: um “Motor de Avaliação de Risco para Transporte de Carga”. Este módulo receberá informações sobre uma operação de transporte específica e deverá calcular um nível de risco, além de fornecer recomendações apropriadas.

1. Dados de Entrada da Operação de Transporte (Exemplos): Considere que, para cada operação de transporte, teremos as seguintes informações:

operation_id: (String) Identificador único da operação.
origin: (String) Cidade de origem da carga.
destiny: (String) Cidade de destino da carga.
total_distance_km: (Integer) Distância total da rota em quilómetros.
cargo_type: (String) Categoria da carga (ex: “Eletrônicos Sensíveis”, “Alimentos Perecíveis”, “Produtos Químicos Perigosos”, “Carga Geral Seca”, “Automotiva”).
total_cargo_value: (Float) Valor monetário da carga em BRL.
traffic_accident_year_history: (Integer) Número de sinistros reportados pela transportadora nos últimos 12 meses.
route_weather_forecast: (String) Condições climáticas previstas para a rota (ex: “Estável”, “Chuva Moderada”, “Chuva Forte com Ventos”, “Neve/Gelo”).
has_insurance: (Boolean) Indica se a carga possui seguro específico para a viagem.
2. Lógica de Avaliação de Risco (Exemplos de Regras de Negócio): O motor deve aplicar um conjunto de regras para determinar o nível de risco. Pense em como você estruturaria essas regras. Aqui estão alguns exemplos (sinta-se à vontade para adicionar ou modificar):

Regra 1 (Tipo de Carga):
Se cargo_type for “Produtos Químicos Perigosos”, o risco inicial é “Alto”.
Se cargo_type for “Alimentos Perecíveis” E total_distance_km > 300, o risco aumenta em um nível.
Se cargo_type for “Eletrônicos Sensíveis” E total_cargo_value > 50000, o risco aumenta em um nível.
Regra 2 (Condições Climáticas):
Se route_weather_forecast for “Chuva Forte com Ventos” ou “Neve/Gelo”, o risco aumenta em um nível.
Regra 3 (Histórico da Transportadora):
Se traffic_accident_year_history > 5, o risco aumenta em um nível.
Se traffic_accident_year_history > 10, o risco aumenta em dois níveis.
Regra 4 (Valor da Carga e Seguro):
Se total_cargo_value > 200000 BRL E has_insurance for false, o risco é “Crítico”, independentemente de outras condições.
3. Saída Esperada: Para cada operação de transporte avaliada, o motor deve retornar:

final_risk_score: (String) O nível de risco calculado (ex: “Baixo”, “Médio”, “Alto”, “Crítico”).
reasons: (Lista de Strings) Uma lista de fatores ou regras que mais contribuíram para o nível de risco.
recommendations: (Lista de Strings) Sugestões para mitigar o risco (ex: “Contratar escolta armada”, “Reavaliar rota devido a condições climáticas”, “Sugerir seguro adicional”, “Inspecionar veículo da transportadora”).
3. Exemplos de input JSON:

Exemplo 1: Risco Alto por Carga Perigosa

{
  "operation_id": "OP_20250910_001",
  "origin": "São Paulo",
  "destiny": "Rio de Janeiro",
  "total_distance_km": 430,
  "cargo_type": "Produtos Químicos Perigosos",
  "total_cargo_value": 75000.50,
  "traffic_accident_year_history": 2,
  "route_weather_forecast": "Estável",
  "has_insurance": true
}
Exemplo 2: Risco Médio com Fatores Múltiplos

{
  "operation_id": "OP_20250910_002",
  "origin": "Porto Alegre",
  "destiny": "Curitiba",
  "total_distance_km": 700,
  "cargo_type": "Eletrônicos Sensíveis",
  "total_cargo_value": 65000.00,
  "traffic_accident_year_history": 7,
  "route_weather_forecast": "Chuva Forte com Ventos",
  "has_insurance": false
}
Exemplo 3: Risco Crítico por Falta de Seguro

{
  "operation_id": "OP_20250910_003",
  "origin": "Belo Horizonte",
  "destiny": "Salvador",
  "total_distance_km": 1500,
  "cargo_type": "Carga Geral Seca",
  "total_cargo_value": 250000.00,
  "traffic_accident_year_history": 3,
  "route_weather_forecast": "Estável",
  "has_insurance": false
}
Exemplo 4: Risco Baixo (Cenário Ideal)

{
  "operation_id": "OP_20250910_004",
  "origin": "Joinville",
  "destiny": "Blumenau",
  "total_distance_km": 50,
  "cargo_type": "Alimentos Perecíveis",
  "total_cargo_value": 25000.00,
  "traffic_accident_year_history": 0,
  "route_weather_forecast": "Estável",
  "has_insurance": true
}
Seu Desafio é Pensar e Discutir Sobre:

Modelagem de Dados: Como você representaria os dados de entrada e saída?
Motor de Regras:
Como você estruturaria a lógica para aplicar as regras?
Como você calcularia o final_risk_score com base nas regras ativadas? (Pode ser um sistema de pontuação, prioridade de regras, etc.)
Como você tornaria fácil adicionar, modificar ou desabilitar regras no futuro?
Geração de Recomendações: Como as recomendações seriam geradas com base no nível de risco e nos dados de entrada?
Implementação (Esboço): Se o tempo permitir, esboce (em pseudocódigo ou na sua linguagem de preferência) a função principal ou o serviço que receberia os dados da operação e retornaria a avaliação. Não se preocupe com a perfeição da sintaxe.
O que Buscamos:

Clareza de Raciocínio: Como você aborda e decompõe o problema.
Habilidade de Modelagem: Como você pensa sobre as estruturas de dados.
Design da Lógica de Negócios: Sua abordagem para implementar e gerenciar as regras.
Comunicação Efetiva: Sua capacidade de explicar suas escolhas, os trade-offs que considera e as justificativas por trás das suas decisões. “Pensar alto” é fundamental!
Visão de Produto/Negócio: Como suas soluções técnicas se conectam aos objetivos de negócio (gerenciar riscos, fornecer recomendações úteis).
Dica Final: Pense Alto! Verbalize seu raciocínio, suas dúvidas e as decisões que está tomando. Estamos aqui para colaborar e entender sua linha de pensamento.

Boa sorte!
