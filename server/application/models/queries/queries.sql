#boards for user
SELECT b.id, b.guid, b.name, b.createdBy, b.dateCreated, b.updatedBy, b.dateUpdated, b.deleted
FROM board b INNER JOIN UserBoard ub on b.id = ub.boardId
AND ub.userId = 

#tasks for board
SELECT t.id, t.guid, t.name, t.createdBy, t.dateCreated, t.updatedBy, t.dateUpdated, t.deleted
FROM Task t INNER JOIN BoardTask bt on t.id = bt.taskId
AND bt.boardId =