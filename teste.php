<?php

class AvalicaoRisco
{
  public $risco = [
    1 => 'Baixo',
    2 => 'Médio',
    3 => 'Alto',
    4 => 'Crítico'
  ];

  public const BAIXO = 1;
  public const MEDIO = 2;
  public const ALTO = 3;
  public const CRITICO = 4;

  public $tipo_risco = 1;

  public $reasons = [];
  public function regra_1($cargo_type, $total_distance_km, $total_cargo_value)
  {
    if($cargo_type == 'Produtos Químicos Perigosos'){
      $this->tipo_risco = self::ALTO;
      $this->reasons[] = $cargo_type;
    }elseif($cargo_type == 'Alimentos Perecíveis' && $total_distance_km > 300){
      $this->tipo_risco++;
      $this->reasons[] = $cargo_type;
      $this->reasons[] = 'Distância maior que 300km';
    }elseif($cargo_type == 'Eletrônicos Sensíveis' && $total_cargo_value > 50000){
      $this->tipo_risco++;
      $this->reasons[] = $cargo_type;
      $this->reasons[] = 'Distância maior que 50000km';
    }
  }

  public function regra_2($route_weather_forecast)
  {
    if($route_weather_forecast == 'Chuva Forte com Ventos' || $route_weather_forecast == 'Neve/Gelo'){
      $this->tipo_risco++;
      $this->reasons[] = $route_weather_forecast;
    }  
  }

  public function regra_3($traffic_accident_year_history)
  {
    if($traffic_accident_year_history > 10){
      $this->tipo_risco += 2;
      $this->reasons[] = "Número de sinistros reportados pela tranpostadora nos ultimos 12 meses foi maior que 10 acidentes";
    }
    elseif($traffic_accident_year_history > 5){
      $this->tipo_risco++;
      $this->reasons[] = "Número de sinistros reportados pela tranpostadora nos ultimos 12 meses foi maior que 5 acidentes";
    }

  }

  public function regra_4($total_cargo_value, $has_insurance)
  {
    if($total_cargo_value > 200000 && !$has_insurance){
      $this->tipo_risco = self::CRITICO;
      $this->reasons = [
        "O valor total da carga é maior que {$total_cargo_value} BRL e a carga não possui seguro especifico para esta viagem"
      ];
    }
  }

  public function result($json){

    $array = json_decode($json, true);

    $this->regra_1($array['cargo_type'], $array['total_distance_km'], $array['total_cargo_value']);
    $this->regra_2($array['route_weather_forecast']);
    $this->regra_3($array['traffic_accident_year_history']);
    $this->regra_4($array['total_cargo_value'], $array['has_insurance']);


    return [
      'final_risk_score' => $this->risco[$this->tipo_risco],
      'reasons' => json_encode($this->reasons),
      'recommendations'
    ];
  }

}

  $teste = new AvalicaoRisco();

  $exemplos = [
    'Risco Alto por Carga Perigosa' => '{
      "operation_id": "OP_20250910_001",
      "origin": "São Paulo",
      "destiny": "Rio de Janeiro",
      "total_distance_km": 430,
      "cargo_type": "Produtos Químicos Perigosos",
      "total_cargo_value": 75000.50,
      "traffic_accident_year_history": 2,
      "route_weather_forecast": "Estável",
      "has_insurance": true
    }',
    'Risco Médio com Fatores Múltiplos' => '{
        "operation_id": "OP_20250910_002",
        "origin": "Porto Alegre",
        "destiny": "Curitiba",
        "total_distance_km": 700,
        "cargo_type": "Eletrônicos Sensíveis",
        "total_cargo_value": 65000.00,
        "traffic_accident_year_history": 7,
        "route_weather_forecast": "Chuva Forte com Ventos",
        "has_insurance": false
    }',
    'Risco Crítico por Falta de Seguro' => '{
      "operation_id": "OP_20250910_003",
      "origin": "Belo Horizonte",
      "destiny": "Salvador",
      "total_distance_km": 1500,
      "cargo_type": "Carga Geral Seca",
      "total_cargo_value": 250000.00,
      "traffic_accident_year_history": 3,
      "route_weather_forecast": "Estável",
      "has_insurance": false
    }',
    'Risco Baixo (Cenário Ideal)' => '{
      "operation_id": "OP_20250910_004",
      "origin": "Joinville",
      "destiny": "Blumenau",
      "total_distance_km": 50,
      "cargo_type": "Alimentos Perecíveis",
      "total_cargo_value": 25000.00,
      "traffic_accident_year_history": 18,
      "route_weather_forecast": "Estável",
      "has_insurance": true
    }'

  ];


  print_r($teste->result($exemplos['Risco Médio com Fatores Múltiplos']));

?>