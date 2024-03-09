FROM almalinux:9.2-minimal

WORKDIR /home

ENV TZ=Asia/Tokyo

RUN microdnf update -y \
    && microdnf install -y \
    httpd \
    mod_ssl \
    ftp \
    vim

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
