<?php
/**
 * Get the client
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define configuration
 // */

 // /* tets */ 
// /* Username, password and endpoint used for server to server web-service calls */
// Lyra\Client::setDefaultUsername("99804535");
// Lyra\Client::setDefaultPassword("testpassword_P8ZLa4x2TaEtGMptNE1LqWX3lHF8vH1M9avnCKgQLomFi");
// Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

// /* publicKey and used by the javascript client */
// Lyra\Client::setDefaultPublicKey("99804535:testpublickey_3Jc5rdGpxyrusAfIS8PXY6PqR9XeWOMPvVTCQERwkRAyq");

// /* SHA256 key */
// Lyra\Client::setDefaultSHA256Key("z9KKrR6MqSpp724HGDXeHILRxIW9gN8S6p2gPnh4PNIzx");




/* Username, password and endpoint used for server to server web-service calls */
Lyra\Client::setDefaultUsername("99804535");
Lyra\Client::setDefaultPassword("prodpassword_r5qgq0puMyrjVFffxfScFeQDMjVqIUrp7rlyKIbQaGi8G");
Lyra\Client::setDefaultEndpoint("https://api.micuentaweb.pe");

/* publicKey and used by the javascript client */
Lyra\Client::setDefaultPublicKey("99804535:publickey_jmqFkEhcAlzDLZbFtIXicQ3b67VDTGHclVPghkRn5wNvT");

/* SHA256 key */
Lyra\Client::setDefaultSHA256Key("msPmPxOpyemmgkqNjdhXU5tqcfJT0KwS6SW6jSHLCyB9N");


