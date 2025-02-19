include .env

init: docker-down-clear docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up 
lint: api-lint

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build:
	docker compose build

api-init: api-composer-install

api-composer-install:
	docker compose run --rm api-php-cli composer install

build: build-gateway build-frontend build-api

build-gateway:
	docker --log-level=debug build --pull --file=gateway/docker/production/nginx/Dockerfile --tag=${REGISTRY}/docker-gateway:${IMAGE_TAG} gateway/docker/production/nginx

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/docker-frontend:${IMAGE_TAG} frontend

build-api:
	docker --log-level=debug build --pull --file=api/docker/production/nginx/Dockerfile --tag=${REGISTRY}/docker-api:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/docker-api-php-fpm:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-cli/Dockerfile --tag=${REGISTRY}/docker-api-php-cli:${IMAGE_TAG} api

try-build:
	REGISTRY=ghcr.io/ga11et IMAGE_TAG=main-1 make build

api-lint:
	docker compose run --rm api-php-cli composer lint

push: push-gateway push-frontend push-api

push-gateway:
	docker push ${REGISTRY}/docker-gateway:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/docker-frontend:${IMAGE_TAG}

push-api:
	docker push ${REGISTRY}/docker-api:${IMAGE_TAG}
	docker push ${REGISTRY}/docker-api-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/docker-api-php-cli:${IMAGE_TAG}

deploy:
	ssh ${HOST} 'rm -rf docker_${BUILD_NUMBER}'
	ssh ${HOST} 'mkdir docker_${BUILD_NUMBER}'
	scp docker-compose-production.yml ${HOST}:docker_${BUILD_NUMBER}/docker-compose-production.yml
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=docker" >> .env'
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && docker compose -f docker-compose-production.yml pull'
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && docker compose -f docker-compose-production.yml up --build --remove-orphans -d'
	ssh ${HOST} 'rm -f docker'
	ssh ${HOST} 'ln -sr docker_${BUILD_NUMBER} docker'

rollback:
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && docker compose -f docker-compose-production.yml pull'
	ssh ${HOST} 'cd docker_${BUILD_NUMBER} && docker compose -f docker-compose-production.yml up --build --remove-orphans -d'
	ssh ${HOST} 'rm -f docker'
	ssh ${HOST} 'ln -sr docker_${BUILD_NUMBER} docker'


