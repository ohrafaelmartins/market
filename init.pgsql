DROP TABLE IF EXISTS sales_status CASCADE;

DROP TABLE IF EXISTS sales CASCADE;

DROP TABLE IF EXISTS products_type CASCADE;

DROP TABLE IF EXISTS products CASCADE;

DROP TABLE IF EXISTS product_sale CASCADE;

CREATE TABLE sales_status (
    id SERIAL PRIMARY KEY,
    name varchar(120) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sales (
    id SERIAL,
    total_price numeric,
    tax_amount numeric,
    PRIMARY KEY (id),
    id_status SMALLINT REFERENCES sales_status (id),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products_type (
    id SERIAL,
    name varchar(120) NOT NULL,
    taxes numeric,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE products (
    id SERIAL,
    name varchar(120) NOT NULL,
    price numeric,
    PRIMARY KEY (id),
    id_products_type SMALLINT REFERENCES products_type (id),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE product_sale (
    id SERIAL,
    name varchar(120) NOT NULL,
    taxes numeric,
    quantity numeric,
    PRIMARY KEY (id),
    id_sales int REFERENCES sales (id),
    id_products int REFERENCES products (id),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO sales_status (name)
    VALUES ('OK');


INSERT INTO products_type (
    name,
    taxes
)VALUES(
    'ALIMENTOS',
    12,
)