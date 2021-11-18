**Sobre Agendamento de tarefas**

# Agendamento de tarefas linux com php.

### Requerimentos:
- crontab instalado
- sitema linux.

### classes
- Agendamento
- Agenda

# Métodos do Agendamento
- agendar
    - recebe um objeto Agenda
    - retorna true se agendado e false se houver erro
    - lança uma exceção se comando do objeto Agenda for vazio
- remover
    - recebe string do id
    - retorna true se conseguir remover e false caso não ache
- listar
    - retorna texto com os agendamentos do crontab
- atualizar
    - recebe objeto Agenda
    - retorna true se atualizou e retorna false caso não tenha encontrado

# Classe Agenda
- id
- minutos
    - string dois números 00 a 59
    - valor padrão *
- horas
    - string dois números 00 a 23
    - valor padrão *    
- dias
    - string dois números 00 a 31
    - valor padrão *    
- mes
    - string de 1 a 12
    - valor padrão *        
- diasSemana
    - string entre 0 e 7
    - valor padrão *    
- comando
    - Comando que será executado. Podem ser usados parâmetros normais usados na linha de comando.
    - valor padrão string vazia.    
    
- valor * é executado sempre.
    - Exemplo: minutos setados com * será executado a cada minuto.