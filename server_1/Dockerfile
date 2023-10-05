FROM php:8.0

RUN apt-get update -y && apt-get install supervisor -y
ADD /supervisor /src/supervisor

WORKDIR /home/
COPY ./www .

EXPOSE 80 8465


CMD ["supervisord","-c","/src/supervisor/start_service.conf"]