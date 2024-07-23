# Техническое задание

Написать микросервис работы с гостями используя язык программирования на выбор PHP или Go, можно пользоваться любыми opensource пакетами, также возможно реализовать с использованием фреймворков или
без них. БД также любая на выбор, использующая SQL в качестве языка запросов.

Микросервис реализует API для CRUD операций над гостем. То есть принимает данные для создания, изменения, получения, удаления записей гостей хранящихся в выбранной базе данных.

Сущность "Гость" Имя, фамилия и телефон – обязательные поля. А поля телефон и email уникальны. В итоге у гостя должны быть следующие атрибуты: идентификатор, имя, фамилия, email, телефон, страна. Если
страна не указана то доставать страну из номера телефона +7 - Россия и т.д.

Правила валидации нужно придумать и реализовать самостоятельно. Микросервис должен запускаться в Docker.

Результат опубликовать в Git репозитории, в него же положить README файл с описанием проекта. Описание не регламентировано, исполнитель сам решает что нужно написать (техническое задание, документация
по коду, инструкция для запуска). Также должно быть описание API (как в него делать запросы, какой формат запроса и ответа), можно в любом формате, в том числе в том же README файле.

# Технологии

- PHP 8.1
- MySQL server 8.0
- Laravel 11
- Composer LTS
- Docker 24.0.5

# Реализация

Приложение предоставляет 4 маршрута (`store`, `show`, `update`, `destroy`) для работы над сущностью `Guest`, имеющей отношения М-1 с сущностью `Country`.
Сущность `Country` выполняет роль enum'a для стран и заполняется из сидеров.

В приложении отсутствует система аутентификации и ролей.

### Guest:

|              |                              |
|--------------|------------------------------|
| name         | `string`                     |
| last_name    | `string`                     |
| email        | `string` `nullable` `unique` |
| phone_number | `string` `unique`            |
| country_id   | `int` `foreign`              |

### Country:

|      |                |
|------|----------------|
| code | `int` `unique` |
| name | `string`       |

# Контракт API

## `POST` /api/guests

<details>
<summary>Параметры:</summary>

```
name            string               
Только кириллица и буквы латинского алфавита.

lastName        string
Только кириллица и буквы латинского алфавита.

phoneNumber     string
Цифры в формате +0000000000

email           string nullable
Действительный адрес электронной почты.

countryId       integer nullable
Идентификатор страны
Если параметр отсутствует в запросе, то сервер автоматически выбирает страну на основе кода из номера телефона.
```
</details>

<details>
    <summary>Ответ 201:</summary>

```
integer           
Идентификатор нового Guest
```
</details>
<details>
    <summary>Ответ 422:</summary>

```
message         string
errors          object
{
    field1      array<string>
    field2      array<string>
    ...
}
```
</details>

## `GET` /api/guests/{guest}

<details>
<summary>Параметры:</summary>

```
guest            integer               
Идентификатор сущности Guest
```
</details>

<details>
    <summary>Ответ 200:</summary>

```
id              integer
name            string
last_name       string
email           string
phone_number    string
country_id      integer
created_at      UTC timestamp
updated_at      UTC timestamp
country         object
{
    id          integer
    name        string
    code        integer
}
```
</details>

## `PUT` /api/guests/{guest}

<details>
<summary>Параметры:</summary>

```
guest           integer
Идентификатор сущности Guest


name            string               
Только кириллица и буквы латинского алфавита.

lastName        string
Только кириллица и буквы латинского алфавита.

phoneNumber     string
Цифры в формате +0000000000

email           string nullable
Действительный адрес электронной почты.

countryId       integer nullable
Идентификатор страны
Если параметр отсутствует в запросе, то сервер автоматически выбирает страну на основе кода из номера телефона.
```
</details>

<details>
    <summary>Ответ 204:</summary>

```
<no data>
```
</details>
<details>
    <summary>Ответ 422:</summary>

```
message         string
errors          object
{
    field1      array<string>
    field2      array<string>
    ...
}
```
</details>

## `DELETE` /api/guests/{guest}

<details>
    <summary>Параметры</summary>

```
guest           integer
Идентификатор сущности Guest
```
</details>

<details>
    <summary>Ответ 204</summary>

```
<no data>
```
</details>

# Деплой

- **Dockerfile** собирает образ на основе php версии 8.1, загружает библиотеки для работы composer и устанавливает зависимости фреймворка Laravel;
- **docker-composer.yml** запускает сервисы `app` и `mysql` на портах 8000 и 13306, монтирует внешний том для хранения данных MySQL и загружает переменные среды из .env в контейнеры. Сервис `app`
  запускается только после healthcheck'а сервиса `mysql`;
- **Makefile** собирает контейнеры и заполняет базу данных.

Установка репозитория:

```

git clone https://github.com/EugeneNail/bnovo-test-task.git && cd bnovo-test-task

```

Запуск приложения:

```

sudo make all

```
