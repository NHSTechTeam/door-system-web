FROM debian:latest

RUN apt update && apt install -y chromium openbox x11-server-utils

COPY ./run.sh /run.sh
RUN chmod +x /run.sh

ENTRYPOINT ["/bin/bash", "/run.sh"]