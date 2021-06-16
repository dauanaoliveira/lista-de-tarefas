Projeto quesimula um To do list (Lista de tarefas).

Para utilizar é necessario a criação do banco e das tabelas.

O nome do banco utilizado é "to-do-list".

Segue o script de criação da tabelas a ser utilizada:

CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task` varchar(255) NOT NULL,
  `description` text,
  `status` varchar(20) NOT NULL,
  `user` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `numberOfChanges` int DEFAULT '0',
  `createAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

Para editar a conexão do banco é só modificar o arquivo config/conexao.php