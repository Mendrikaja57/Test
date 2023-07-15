create database alter database wner to postgres;

CREATE TABLE Employee(
    id SERIAL PRIMARY KEY,
    Nom VARCHAR(50),
    Email VARCHAR(50),
    motdepasse VARCHAR(20)
);

CREATE TABLE Artiste (
    id SERIAL PRIMARY KEY,
    Nom VARCHAR (50),
    Tarif_par_heure DECIMAL(10,2)
);

CREATE TABLE Sonorisation(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50),
    Tarif_heure DECIMAL(10,2)
);


CREATE TABLE Logistique(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50),
    Tarif_jour DECIMAL(10,2)
);

CREATE TABLE Type_lieu(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50)
);

CREATE TABLE Lieu(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50),
    id_type_lieu INTEGER NOT NULL REFERENCES Type_lieu (id),
    nbr_vip INTEGER,
    nbr_reserve INTEGER,
    nbr_normal INTEGER
);

CREATE TABLE Autre_depense(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50)
);

CREATE TABLE Type_event(
    id SERIAL PRIMARY KEY,
    Label VARCHAR(50)
);

CREATE TABLE Evenement(
    id SERIAL PRIMARY KEY,
    id_type_event INTEGER REFERENCES Type_event (id),
    Label VARCHAR (50),
    Daty Date,
    id_lieu INTEGER REFERENCES Lieu (id),
    prix_vip DECIMAL(10,2),
    prix_reserve DECIMAL(10,2),
    prix_normal DECIMAL(10,2),
    tarif_lieu DECIMAL(10,2)
);

CREATE TABLE Event_Artiste(
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES Evenement (id),
    id_artiste INTEGER NOT NULL REFERENCES Artiste (id),
    duree_artiste INTEGER --min
);

CREATE TABLE Event_Sono(
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES Evenement (id),
    id_sono INTEGER NOT NULL REFERENCES Sonorisation (id),
    duree_sono INTEGER --min
);

CREATE TABLE Event_Logis(
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES Evenement (id),
    id_logis INTEGER NOT NULL REFERENCES Logistique (id),
    duree_logis INTEGER --min
);

CREATE TABLE Event_autre_depense(
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES Evenement (id),
    id_autre_depense INTEGER NOT NULL REFERENCES Autre_depense (id),
    tarif DECIMAL(10,2)
);

insert into Employee (nom,email,motdepasse) values ('Aina','aina@gmail.com','aina1234');




CREATE VIEW EventArtisteDetails AS
SELECT
    e.id AS event_id,
    e.Label AS event_label,
    e.Daty AS event_date,
    e.tarif_lieu AS event_tarif,
    a.id AS artiste_id,
    a.Nom AS artiste_nom,
    a.Tarif_par_heure AS artiste_tarif,
    ea.duree_artiste AS artiste_duree
FROM
    Evenement e
JOIN
    Event_Artiste ea ON e.id = ea.id_event
JOIN
    Artiste a ON ea.id_artiste = a.id;

    CREATE VIEW EventSonoDetails AS
SELECT
    e.id AS event_id,
    e.Label AS event_label,
    e.Daty AS event_date,
    e.tarif_lieu AS event_tarif,
    s.id AS sono_id,
    s.Label AS sono_label,
    s.Tarif_heure AS sono_tarif,
    es.duree_sono AS sono_duree
FROM
    Evenement e
JOIN
    Event_Sono es ON e.id = es.id_event
JOIN
    Sonorisation s ON es.id_sono = s.id;

    CREATE VIEW EventLogisDetails AS
SELECT
    e.id AS event_id,
    e.Label AS event_label,
    e.Daty AS event_date,
    e.tarif_lieu AS event_tarif,
    l.id AS logis_id,
    l.Label AS logis_label,
    l.Tarif_jour AS logis_tarif,
    el.duree_logis AS logis_duree
FROM
    Evenement e
JOIN
    Event_Logis el ON e.id = el.id_event
JOIN
    Logistique l ON el.id_logis = l.id;

    CREATE VIEW EventAutreDepenseDetails AS
SELECT
    e.id AS event_id,
    e.Label AS event_label,
    e.Daty AS event_date,
    e.tarif_lieu AS event_tarif,
    ad.id AS autre_depense_id,
    ad.Label AS autre_depense_label,
    ed.tarif AS autre_depense_tarif
FROM
    Evenement e
JOIN
    Event_autre_depense ed ON e.id = ed.id_event
JOIN
    Autre_depense ad ON ed.id_autre_depense = ad.id;

    CREATE VIEW EvenementLieuDetails AS
SELECT
    e.id AS event_id,
    e.Label AS event_label,
    e.Daty AS event_date,
    l.id AS lieu_id,
    l.Label AS lieu_label,
    l.id_type_lieu,
    l.Nbr_pers,
    e.tarif_lieu AS lieu_tarif
FROM
    Evenement e
JOIN
    Lieu l ON e.id_lieu = l.id;


    CREATE VIEW EventDetails AS
SELECT
    ea.event_id,
    ea.event_label,
    ea.event_date,
    SUM(ea.event_tarif + COALESCE(ad.autre_depense_tarif, 0)) AS total_tarif,
    ea.artiste_id,
    ea.artiste_nom,
    ea.artiste_tarif,
    ea.artiste_duree,
    es.sono_id,
    es.sono_label,
    es.sono_tarif,
    es.sono_duree,
    el.logis_id,
    el.logis_label,
    el.logis_tarif,
    el.logis_duree,
    eld.lieu_id,
    eld.lieu_label,
    eld.id_type_lieu,
    eld.Nbr_pers,
    eld.lieu_tarif
FROM
    EventArtisteDetails ea
JOIN
    EventSonoDetails es ON ea.event_id = es.event_id
JOIN
    EventLogisDetails el ON ea.event_id = el.event_id
JOIN
    EvenementLieuDetails eld ON ea.event_id = eld.event_id
LEFT JOIN
    EventAutreDepenseDetails ad ON ea.event_id = ad.event_id
GROUP BY
    ea.event_id,
    ea.event_label,
    ea.event_date,
    ea.artiste_id,
    ea.artiste_nom,
    ea.artiste_tarif,
    ea.artiste_duree,
    es.sono_id,
    es.sono_label,
    es.sono_tarif,
    es.sono_duree,
    el.logis_id,
    el.logis_label,
    el.logis_tarif,
    el.logis_duree,
    eld.lieu_id,
    eld.lieu_label,
    eld.id_type_lieu,
    eld.Nbr_pers,
    eld.lieu_tarif;