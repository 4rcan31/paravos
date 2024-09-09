# Tareas

## Tienda

- [X] Implementar inicio de sesión de usuario.  
- [X] Implementar cierre de sesión de usuario.  
- [X] Mostrar productos con paginación.  
- [X] Mostrar información detallada de un producto.         
- [X] Crear modal para realizar pedidos.  

- [X] Implementar funcionalidad para guardar pedidos, tanto para usuarios registrados como no registrados.  
- [X] Crear página "Mi cuenta" para usuarios autenticados.  
- [X] Desarrollar el carrito de compras (también quiza solo llamarlo "Órdenes" para los pedidos registrados).  
- [X] Mostrar los últimos 6 productos en la vista principal.  
- [X] Diseñar vistas para los socios (tanto individuales como todos).  
- [X] Implementar registro de usuario.  
- [ ] Considerar la implementación de la funcionalidad "Olvidé mi contraseña" (para futuras iteraciones).  
- [X] Implementar inicio de sesión para administradores.  
- [X] Comenzar a desarrollar las vistas para el panel de administración.  


- Vista Parther
    - [ ] Hacer login de parther
        - [ ] Crear tabla en la db de parthers 
        - [ ] Agregar funcionalidad de login con la sintaxis {{correo}}:parther
    - [ ] Vistas de parthers
        - [ ] Crud de sus productos
        - [ ] Crud de ordenes
        - [ ] Crud de envios
        - [ ] Dashboard
        - [ ] Configuracion de la tienda
            - [ ] Subir logo 
            - [ ] Subir paleta de colores
        - Vista general de la web por parther
            - [ ] Cambiar colores en la web
            - [ ] setear nombre y logo {{name}} power by paravos (en chiquito)
- Vista de cliente final
    - [ ] poder setear diferentes direcciones (tener una por default)   
    - [ ] Poder hacer comentarios desde el cliente de las ordenes
    - [ ] Ver Cancelar Ordenes
    - [ ] Separar ordenes canceladas
- Vista de Admin
    - [ ] Ordenes
        - [ ] Cancelacion
            - [ ] Comentario publico
            - [ ] Comentario publico    
        - [ ] Aprovacion
            - [ ] Crear driver de envio interno
            - [ ] Crear driver de envio para boxfull (Esto no es prioridad por el momento)
        - [ ] Crear ordenes
            - [ ] Desde formulario
            - [ ] Desde texto analizado con IA para llenar el formulario automatico (no prioridad)
                Esto pudiera ser mas grande aun, hacer que la IA chatee con las personas etc
    - [ ] Envios
        - [ ] Crear en el side bar un desplegable de diferentes tipos de envios
            - [ ] Envios completados
            - [ ] Envios en congelamiento
            - [ ] Envios Cancelados
            - [ ] Envios Pendientes
        - [ ] Botones para cambiar tipos de envios
            - [ ] Envios pendientes debe de tener para enviar a 
                - [ ] Congelamiento
                - [ ] Cancelados
                - [ ] Pendientes
                - [ ] Envios Cancelados ya no podran ser activados nuevamente
                - [ ] Envios en Congelamiento Pueden volver a activarse
                - [ ] Envios Completados solamente pueden hacerles comentarios privados y publicos
        
## Sao

- [ ] Resolver el problema de autenticación (bug) tanto en el lado del cliente como en el servidor.  
- [ ] Investigar y considerar la implementación de una biblioteca para la funcionalidad "Olvidé mi contraseña". 
- [ ] Hacer que el View data sea invulnerable a inyecciones html
    - [X] En el guardado de base de datos
    - [ ] En los datos del request
    - [ ] En el renderizado de vistas
