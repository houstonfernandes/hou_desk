<?php
return [
    'formasPagamentos' =>[        
        0 =>'dinheiro',
        1 => 'cartão debito',
        2 => 'cartão de credito à vista',
        3 => 'cartão de credito parcelado',
        4 => 'cheque',
        5 => 'ticket'        
    ],
    'statusPedidos' => [        
            0 => 'Orçamento',
            1 => 'Venda entregue',
            2 => 'Venda para entregar',
            3 => 'Venda entrega concluida',
    ],    
    'statusCompras' => [
        0 => 'Entregue',
        1 => 'Aguarda fornecedor entregar',
    ],    
    'operacoes' =>[
        0 => 'Compra',
        1 => 'Venda', 
        2 => 'Devolução',
        3 => 'Ajuste'
    ],
    'unidades' =>[
        'un' => 'Unidade',
        'pc' => 'Peça',
        'cx' => 'Caixa',
        'dz' => 'Dúzia',
        'ct' => 'Cartela',
        'm' => "Metro",
        'm2' => "Metro²",
        'm3' => "Metro³",
        'dz' =>'Dezena',
        'pct'=> 'Pacote',
        'am' => 'Amarrado',
        'por'=> 'Porção',
    ],
    
];