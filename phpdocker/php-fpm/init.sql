    CREATE TABLE venda_status (
        id_status SERIAL PRIMARY KEY,
        nome varchar(120) NOT NULL
    );
INSERT INTO venda_status (nome) VALUES ('APROVADA');
INSERT INTO venda_status (nome) VALUES ('REPROVADA');
INSERT INTO venda_status (nome) VALUES ('EM ANALISE');
CREATE TABLE venda (
    id_venda SERIAL,
    valor_venda numeric,
    valor_imposto numeric,
    PRIMARY KEY (id_venda),
    id_status SMALLINT REFERENCES venda_status (id_status)
);
CREATE TABLE tipo_produto (
    id_tipo_de_produto SERIAL,
    nome varchar(120) NOT NULL,
    imposto numeric,
    PRIMARY KEY (id_tipo_de_produto)
);
CREATE TABLE produto (
    id_produto SERIAL,
    nome varchar(120) NOT NULL,
    valor numeric,
    PRIMARY KEY (id_produto),
    id_tipo_de_produto_fk SMALLINT REFERENCES tipo_produto (id_tipo_de_produto)
);
CREATE TABLE venda_produto (
    id_venda_produto SERIAL,
    nome varchar(120) NOT NULL,
    imposto numeric,
    quantidade numeric,
    PRIMARY KEY (id_venda_produto),
    id_venda int REFERENCES venda (id_venda),
    id_produto int REFERENCES produto (id_produto)
);
/* produto
 id_produto
 id_tipo_de_produto
 nome
 valor
tipo_de_produto
 id_tipo_de_produto
 nome
 imposto
venda_produto
 id_venda_produto
 id_venda
 id_produto
 quantidade
venda
 id_venda
 valor_venda
 valor_imposto
 status
 */
