CREATE TABLE IF NOT EXISTS ecommerces
(
    id         INT          NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS products
(
    id           INT          NOT NULL AUTO_INCREMENT,
    ecommerce_id INT,
    name         VARCHAR(100) NOT NULL,
    description  TEXT,
    price        DOUBLE       NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    FOREIGN KEY (ecommerce_id) REFERENCES ecommerces (id)
);