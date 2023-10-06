SELECT
    t.id,
    users.nom,
    users.prenom,
    montant,
    date
FROM
    transferts t
INNER JOIN
    users on t.sender_id=users.id
WHERE
    t.reciever_id=2;
