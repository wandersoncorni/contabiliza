<?php

/**
 * Características do Argon2id
 *   É resistente a ataques de força bruta e de dicionário 
 *   É resistente a ataques paralelos 
 *   Tem uma configuração flexível, permitindo ajustar a quantidade de memória e o tempo de computação 
 *   Tem três parâmetros de configuração: mínimo base do tamanho mínimo de memória, número mínimo de iterações e grau de paralelismo 
 */
return [
    'driver' => 'argon2id',
];
