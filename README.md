## Description

Ce test a été réalisé avec Symfony 6.4.2

Afin de concevoir l'api, le framework Api Platform a été intégré à cette application Symfony, afin de pouvoir auto générer quelques endpoints et un documentation, accessible directement depuis `http(s)://<host>/api`.

Doctrine ORM a été utilisé pour ce test, lié à une base de donnée MySQL. Ce projet se compose d'une architecture simple de 2 entités : `Person` et `Job`

Pour parvenir a certain endpoint, j'ai tout simplement utilisé les Filters d'Api Platform, et une "Custom Operation".

## Liste des endpoints

> - Sauvegardent une nouvelle personne. Attention, seules les personnes de moins de 150 ans peuvent être enregistrées. Sinon, renvoyez une erreur.

**POST** `/api/people`

___

> - Permettent d'ajouter un emploi à une personne avec une date de début et de fin d'emploi. Pour le poste actuellement occupé, la date de fin n'est pas obligatoire. Une personne peut avoir plusieurs emplois aux dates qui se chevauchent.

**POST** `/api/people/<peopleId>/jobs`

`peopleId` étant l'identifiant (_integer_) de la personne

____


> - Renvoient toutes les personnes enregistrées par ordre alphabétique, et indiquent également leur âge et leur(s) emploi(s) actuel(s).

**GET** `/api/people/?order[firstName]=ASC`

Peut également être trié avec le _lastName_

___

> - Renvoient toutes les personnes ayant travaillé pour une entreprise donnée.

**GET** `/api/people/?jobs.company=<companyName>`

`companyName` étant le nom de la compagnie à rechercher, insensible à la casse

___

> - Renvoient tous les emplois d'une personne entre deux plages de dates.

**GET** `/api/jobs?person.id=<peopleId>&beginAt[after]=<beginAtDate>&endAt[before]=<endAtDate>`

`peopleId` étant l'identifiant (_integer_) de la personne.

`beginAtDate` étant la plage de date inférieure au format _YYYY-MM-DD_.
`endAtDate` étant la plage de date supérieure au format _YYYY-MM-DD_.

___


