# Fidely NET api wrapper

Un wrapper in php per le API di FidelyNET.

## Istruzioni veloci
La libreria permette d'interagire con i servizi, `backoffice`, `customer` e `terminal`, per creare un'istanza di un servizio, è consigliabile utilizzare la classe `ServiceFactory`, passando al metodo statico `create()` un array che contiene la tipologia del servizio desiderato e i relativi parametri di autenticazione forniti da Data Loyalty.

Esempio di utilizzo della factory per creare un'istanza del servizio terminal:
```php
use Blabs\FidelyNet\ServiceFactory;

$terminal_service = ServiceFactory::create('terminal', [
    'username' => 'wsTerminal01',
    'password' => 'password',
    'terminal' => '000001'
]);

/** @var \Blabs\FidelyNet\Services\TerminalService $terminal_service */
$terminal_service->getCampaign('1001');
```
## Parametri accettati dalla `ServiceFactory`
* `username`
* `password`
* `terminal`
* `campaign_id`
* `demo_mode`
* `session_persists`
* `session_id_provider`
* `session_type`
* `http_client`

### Parametri obbligatori per ogni servizio
* `BackofficeService`
  * `username`
  * `password`
  
* `TerminalService` 
  * `username`
  * `password`
  * `terminal`
  
* `CustomerService`
  * `username`
  * `password`
  * `campaign_id`

## Persistenza Sessione
Le API di FidelyNET prevedono un meccanismo di autenticazione che richiede l'apertura di una sessione sul servizio.
 
Il meccanismo prevede che in una prima richiesta venga effettuato il login sul servizio, che ritornerà un token di sessione, tale token sarà utilizzato per autorizzare tutte le successive richieste. 
Il token ha una validità di 15 minuti dall'ultima richiesta effettuata.

La libreria implementa questo meccanismo in maniera automatica al momento della creazione di un istanza del servizio, inoltre è possibile far persistere l'id di sessione attraverso richieste multiple (anche in più istanze dello stesso servizio).
In caso di fallimento di una richiesta per sessione scaduta, il client effettua in maniera automatica una nuova richiesta di login, rinnovando il token e reiterando la richiesta fallita.

La persistenza della sessione viene attivata passando alla factory il valore `true` per il parametro `session_persists`, di default la libreria utilizza un meccanismo di persistenza della sessione nella directory di sistema dedicata ai file temporanei (tipicamente `tmp/` su un sistema *nix), è possibile tuttavia creare la propria implementazione del meccanismo di persistenza implementando l'interfaccia `\Blabs\FidelyNet\Contracts\SessionIdProviderContract`. 


## Metodi supportati dai servizi
La libreria supporta un numero di metodi ridotto rispetto a quelli disponibili sul servizio

### Terminal
####`getCampaign($campaign_id)`
Ritorna tutte le informazioni su una campagna. 

### Customer
Ancora nessun metodo supportato

### Backoffice
Ancora nessun metodo supportato

### Testing
```shell script
composer test
```