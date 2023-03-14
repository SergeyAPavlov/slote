# Composer: Обновление зависимости

У вас есть проект, который использует библиотеку. Вам
необходимо:

- внести изменения в библиотеку и протестировать ее
работоспособность в проекте

- после успешного прохождения тестов вам необходимо
выпустить релиз проекта с измененной библиотекой

Опишите Ваши действия в git и composer на всех этапах
(разработка, тестирование, релиз и деплой).

```
разработка:
    в библиотеке

git branch feature
git add .
git commit -m 'changes description'
git push origin

доработка и тестирование:

    в проекте
git branch feature

В composer.json проекта поменять версию пакета библиотеки. К названию ветки добавить dev-:

"owner/our_lib":"dev-feature"

Указать в composer.json проекта ссылку на репозиторий:

"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/owner/our_lib.git"
    }
]

composer update

тестируем наш проект с измененной версией библиотеки
вносим необходимые изменения, вливаем в мастер

когда все в порядке:

    в библиотеке
git checkout master
git merge feature
git tag номер релиза
git push origin

    в packegist - заходим в нашу библиотеку и жмем update

    в проекте - 

возвращаем старый composer.json, если надо, указываем номер релиза пакета
git checkout master
git merge feature
git tag номер релиза

деплой:

зависит от настроек нашего CI. в простейшем случае - 

git push origin

и на сервере продакшена делаем composer update

```


