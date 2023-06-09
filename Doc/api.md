# Модификация списка товаров

Есть платформа, предоставляющая заказчику возможности
маркетплейса для розничной реализации своих продуктов.
Платформа работает в продакшне и имеет определенное
количество активных пользователей. Пользователи взаимодействуют
с системой с помощью набора web и мобильных приложений
для разных операционных систем. Взаимодействие клиентских
приложений с бэкендом осуществляется через RESTful API.
Необходимо реализовать доработки каталога товаров для
бэкенда и API системы на основе требований заказчика.

#### Функциональные требования:

- Избранное

    – предоставить авторизованному пользователю возможность добавлять продукты в избранное
    
    – избранные продукты должны отображаться с соответствующей пометкой в общем списке всех продуктов
    
    – пользователь так же должен иметь возможность
просматривать список избранных продуктов отдельно

    – в списке избранных продуктов должны сохраниться
фильтры и сортировка как и в общем списке продуктов

    – гостю функционал избранного недоступен, но он по
прежнему должен иметь возможность просматривать
список продуктов

- Детали продукта
    
    – необходимо добавить возможность отображать для
    продукта более одного изображения
    
    – существующие изображения должны остаться в
    текущем хранилище
    
    – для новых изображений принято решение использовать
    сервис на основе AWS S3

#### Остальные требования заказчика:

• минимизировать необходимые доработки, в том числе со
стороны клиентских приложений

• сохранить обратную совместимость API, так как разные
команды клиентских решений планирует релизы обновлений
в разное время

• обеспечить стабильность и соответствие решения поставленной
задаче с учетом будущих изменений системы

## №A. Документация API

Для команд разработчиков клиентских
приложений необходимо предоставить обновленную документацию
RESTful API системы. Ниже приведены выдержка из существующей
документ``ации о работе со списками продуктов. Опишите
вариант изменения API с учетом всех требований заказчика и
best практик проектирования RESTful API. Так же необходимо
учесть и описать возможные ошибки.


```
Request example

GET /products?category=category-1&sort=name HTTP/1.1
Host: api.market.com
Authorization: Bearer 2YotnFZFEjr1zCsicMWpAA
Accept: application/json

Response example
HTTP/1.1 200 OK
Content-Type: application/json;charset=UTF-8
[
    {
        "id": 1,
        "name": "Example product 1",
        "description": "Example product 1 description",
        "image_url": "https://cdn.market.com/images/products/product_1.png",
        "category": "category-1"
    },
    {
        "id": 4,
        "name": "Example product 4",
        "description": "Example product 4 description",
        "image_url": "https://cdn.market.com/images/products/product_4.png",
        "category": "category-1"
    },
...
]
```

## Ответ на вопросы задания:

Необходимо добавить в api новые ресурсы: Избранное и Галереи

###### Изменение запросов для создания Избранного:

- новое поле ответа ('is_favourite') в список товаров и в карточку товара.

- новый парметр запроса ('is_favourite') в запрос списка товаров GET /products?category=category-1&sort=name&is_favourite=on

- новый маршрут "избранное" - https://cdn.market.com/favourites с операциями 
    - GET https://cdn.market.com/favourites/{product_id} (ответы 200 — успех, 404 — ресурс не найден, 500 — ошибка сервера) - возвращает ответ принадлежит ли товар избранному текущего пользователя

    - PUT https://cdn.market.com/favourites/{product_id} {yes/no в поле запроса) (ответы 200 — успех, 404 — ресурс не найден, 201 — создан, 401 — несанкционированный (при неудачной авторизации), 500 — ошибка сервера) - меняет статус принадлежности к избранному
		
        _- далее для краткости опускаю список кодов ответа, они должны быть предусмотрены для всех запросов аналогично_
		
###### Изменение запросов для создания Галереи:

- новое поле ответа ('images', список uri изображений галереи товара) в карточку товара.
- объекты галереи: uri изображений, идентифицирующие как само изображение, так и репозиторий его хранения
    
- новое поле запроса для операций PUT и POST товара: id галереи
- новый маршрут "галереи" - "https://cdn.market.com/galleries" с операциями
    - GET https://cdn.market.com/galleries - запрос списка галерей (возвращает список id галерей)	
    - POST https://cdn.market.com/galleries ( gallery_id в поле данных) - создание галереи
    - DELETE https://cdn.market.com/galleries/{gallery_id} - удаление галереи
    - GET https://cdn.market.com/galleries/{gallery_id} - список изображений галереи (список объектов, структуру см. выше)
    
    - PUT https://cdn.market.com/galleries/{gallery_id} - добавление изображения в галерею (параметр - uri изображения)
     - DELETE https://cdn.market.com/galleries/{gallery_id} - удаление изображения из галереи (параметр - uri изображения)
    - PUT https://cdn.market.com/galleries/{gallery_id}/top - установка титульного изображения галереи (параметр - uri изображения)
    - DELETE https://cdn.market.com/galleries/{gallery_id}/top - сброс титульного изображения галереи
    
- маршруты для загрузки изображения на сервер и удаления изображения с сервера остаются прежними. Предполагается, что при загрузке изображения возвращается uri загруженного файла. 
    
- поле ответа "image_url" сохраняется для обратной совместимости, в него включается первый объект галереи
- "за кадром" api остаются (и решаются ПО бекенда) вопросы хранения изображений, сохранение либо изменение представления хранения ранее введенных изображений и пр.

ПРИМЕЧАНИЯ:

а) в реальном проекте я бы работал с формальным описанием документации api (имел дело с OpenApi или JsonApi), но для тестового задания это, ИМХО, слишком трудоемко.
	
б) возможно, имея в виду развитие, следовало бы сразу ввести новую сущность "статусы товаров" для зависящих от пользователя статусов типа избранное, просмотренное, и так далее и делать api сразу для статусов.

# B. Реализация

Реализация размещена в текущем репозитории в папке Market

# C. Тесты 
Для поддержания тестового покрытия необходимо
дополнить набор Unit и API тестов. Опишите в свободной форме
для каких внедренных или измененных структурных единиц,
кейсов и ответов API Вы бы подготовили тесты с кратким
описанием их назначения.

## Ответ:

Я бы написал функциональные тесты для всех новых или измененных методов в классах ImageGallery, Product, для всех методов в классах реализующих FileStorageInterface, а также юнит-тесты (с моканьем ответов сервера) для всех вновь созданных запросов АПИ.


