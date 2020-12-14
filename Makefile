

.PHONE: up
up: #build
	docker-compose start

.PHONE: build
build:
	docker-compose up --no-start

.PHONE: down
down:
	docker-compose down

.PHONE: ms
ms:
	docker exec -it db mysql -uroot -psupersecret swap-it

