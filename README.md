# HackUPC-24

HackUPC2024 Project: Join&Eat

Team members:
- Fardin A. @FardinA143
- Diego Cataño @Dio-dct
- Momin Miah @s0dreams

## Have you ever went to a buffet with a group of people and ordering for everyone escalated badly? With Join&Eat everyone can add themselves to the list and order
Just type your name and hit create room. Then share the code with your friends and you'll be in a collaborative list. Each of yourselves add what you want to order and when ordering just hit Summary, and you'll get your list


Try it out [here].
> [!WARNING]
> The live version is now offline, please self host.

## How to deploy
> TODO: Finish this section

1. Create a MySQL database with four tables. These are salas, usuarios, platos & pedidos
   - salas has a single column containing room_code
   - usuarios has a key usuario_id, a username nombre, and a foreign key room_code, acquired from salas
   - platos has a key plato_id, an int field numero_plato, a string field comentario, an int cantidad_total_pedidos, and a foreign key room_code
   - pedidos has a int key pedido_id, a foreign key plato_id, a foreign key usuario_id and an int key cantidad_pedido

2. Add your DB credentials to each php file in the doc.
3. Host the files in your root www directory.



