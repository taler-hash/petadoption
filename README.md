# petadoption
 "PawPrints: Integrated Solution for Animal Welfare and Adoption Services" is a comprehensive platform designed to streamline and enhance the processes involved in animal care, welfare, and adoption. It aims to bridge the gap between animal shelters, welfare organizations, and potential adopters by offering integrated features such as animal tracking, adoption management, and updates. The solution prioritizes the well-being of animals while ensuring a user-friendly experience for staff and adopters alike. Through innovative technology, PawPrints fosters a community-driven approach to animal welfare, promoting responsible pet ownership and making it easier to find loving homes for animals in need.

## Tech Stacks
 - Laravel ( PHP Framework )
 - Inertia ( Javascript Framework )
 - Tailwind ( CSS Framework )
 - Mysql
 - Docker
 - Reverb (Laravel WebSocket)
 - Caddy ( WebServer )
## Pre requisites
Download the following packages
- Docker
- Git
- Node
## Deployment
To deploy this app you need to follow this steps:

1. Open Docker app
2. Create a folder in desktop name **petadoption**
3. Inside of that folder run a terminal
4. Clone the app using git
5. after cloning you should see **petadoption** folder open that folder. To build the app run this command inside of the folder youve just open just run this one time run ( run this after finishing the other one)
  - `docker compose build --no-cache app && docker compose up app -d && docker exec -d app bash -c "chmod 777 -R ./ && cp .env.example .env && composer install && php artisan config:clear && php artisan migrate:fresh --seed && npm install && npm run build && php artisan config:clear "`
  - `docker compose build --no-cache caddy && docker compose up caddy -d && docker exec -d app bash -c "chmod 777 -R ./"`
7. To start the app run this inside of the mentioned folder `docker compose up`
8. To stop the app run this inside of the mentioned folder `docker compose down`
9. After that you can access the application via `http://localhost`

### Developer
*Jurie Tylier Pedrogas ( Software Engineer )*

Development Time Range: 1month+

