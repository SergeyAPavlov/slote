# Репозиторий билетов

Есть класс, который позволяет работать с билетами, находящимися
в БД:
```PHP
class TicketRepository
{
    public function load($ticketID)
    {
        return Ticket::find()->where(['id' => $ticketId])->one();
    }
    public function save($ticket){/*...*/}
    public function update($ticket){/*...*/}
    public function delete($ticket){/*...*/}
}
```
Стоит задача реализовать возможность работы с билетами
которые хранятся на другом сервере (по API).

Требуется описать структуру методов и классов, с помощью
которых можно будет загружать билеты как из БД, так и из
другого сервера (по API).

```
interface TicketRepositoryInterface // реализует все методы class TicketRepository
class ApiTickerRepository implements TicketRepositoryInterface
class TicketRepository implements TicketRepositoryInterface

далее зависит от конкретной постановки задачи - как именно и на каком уровне должен осуществляться выбор нужного репозитория.


```

