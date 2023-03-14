# Структуры корзины заказов

У нас есть набор действий, которые мы хотим осуществлять с
заказами:
```
calculateTotalSum(){/*...*/}
getItems(){/*...*/}
getItemsCount(){/*...*/}
addItem($item){/*...*/}
deleteItem($item){/*...*/}
printOrder(){/*...*/}
showOrder(){/*...*/}
load(){/*...*/}
save(){/*...*/}
update(){/*...*/}
delete(){/*...*/}
```
Нужно создать структуру классов, чтобы можно было пользоваться
этими методами.
```

class Item
{
    public function load(){/*...*/}
    public function save(){/*...*/}
    public function update(){/*...*/}
    public function delete(){/*...*/}

    public function getSum();
}

class Order
{
    private OrderItems $orderItems;

    public function printOrder(){/*...*/}
    public function showOrder(){/*...*/}

    public function getOrderItems();
    
}

class OrderItems
{
    public function getItems(){/*...*/}
    public function getItemsCount(){/*...*/}
    public function addItem(Item $item){/*...*/}
    public function deleteItem(Item $item){/*...*/}
}

class OrderOperations
{
    public function calculateTotalSum(Order $order){/*...*/}
}

```