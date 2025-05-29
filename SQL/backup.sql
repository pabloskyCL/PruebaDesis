CREATE TABLE public.bodega (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);

ALTER TABLE public.bodega ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public."Bodega_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.moneda (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL
);

ALTER TABLE public.moneda ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.moneda_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

CREATE TABLE public.producto (
    codigo character varying(200) NOT NULL,
    nombre character varying(50) NOT NULL,
    precio double precision NOT NULL,
    descripcion character varying(1000) NOT NULL,
    moneda_id integer,
    materiales character varying(100) NOT NULL
);

CREATE TABLE public.producto_sucursal (
    id integer NOT NULL,
    producto_id character varying NOT NULL,
    sucursal_id integer NOT NULL
);

ALTER TABLE public.producto_sucursal ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.producto_sucursal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


CREATE TABLE public.sucursal (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    bodega_id integer
);

ALTER TABLE public.sucursal ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sucursal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);

INSERT INTO public.bodega OVERRIDING SYSTEM VALUE VALUES (1, 'bodega san miguel');
INSERT INTO public.bodega OVERRIDING SYSTEM VALUE VALUES (2, 'santiago centro');
INSERT INTO public.bodega OVERRIDING SYSTEM VALUE VALUES (3, 'san ramon');


INSERT INTO public.moneda OVERRIDING SYSTEM VALUE VALUES (1, 'peso chileno');
INSERT INTO public.moneda OVERRIDING SYSTEM VALUE VALUES (2, 'dolar');
INSERT INTO public.moneda OVERRIDING SYSTEM VALUE VALUES (3, 'euro');

INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (1, 'el castillo', 1);
INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (2, 'copiapo 1325', 2);
INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (3, 'alvear 1042', 3);
INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (4, 'san francisco 599', 3);
INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (5, 'san francisco 2029', 2);
INSERT INTO public.sucursal OVERRIDING SYSTEM VALUE VALUES (6, 'totus 24', 1);

SELECT pg_catalog.setval('public."Bodega_id_seq"', 3, true);
SELECT pg_catalog.setval('public.moneda_id_seq', 3, true);
SELECT pg_catalog.setval('public.producto_sucursal_id_seq', 28, true);
SELECT pg_catalog.setval('public.sucursal_id_seq', 6, true);

ALTER TABLE ONLY public.bodega
    ADD CONSTRAINT "Bodega_pkey" PRIMARY KEY (id);

ALTER TABLE public.producto
    ADD CONSTRAINT check_largo_codigo CHECK (((char_length((codigo)::text) >= 5) AND (char_length((codigo)::text) <= 15))) NOT VALID;


--
-- TOC entry 3016 (class 2606 OID 16588)
-- Name: producto check_largo_descripcion; Type: CHECK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE public.producto
    ADD CONSTRAINT check_largo_descripcion CHECK (((char_length((descripcion)::text) >= 10) AND (char_length((descripcion)::text) <= 1000))) NOT VALID;


--
-- TOC entry 3017 (class 2606 OID 16587)
-- Name: producto check_largo_materiales; Type: CHECK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE public.producto
    ADD CONSTRAINT check_largo_materiales CHECK ((char_length((materiales)::text) >= 12)) NOT VALID;


--
-- TOC entry 3018 (class 2606 OID 16586)
-- Name: producto check_largo_nombre; Type: CHECK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE public.producto
    ADD CONSTRAINT check_largo_nombre CHECK (((char_length((nombre)::text) >= 2) AND (char_length((nombre)::text) <= 50))) NOT VALID;


--
-- TOC entry 3019 (class 2606 OID 16540)
-- Name: producto check_precio_negativo; Type: CHECK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE public.producto
    ADD CONSTRAINT check_precio_negativo CHECK ((precio >= (0)::double precision)) NOT VALID;


--
-- TOC entry 3023 (class 2606 OID 16400)
-- Name: moneda moneda_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.moneda
    ADD CONSTRAINT moneda_pkey PRIMARY KEY (id);


--
-- TOC entry 3021 (class 2606 OID 16569)
-- Name: producto producto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_pkey PRIMARY KEY (codigo);


--
-- TOC entry 3029 (class 2606 OID 16454)
-- Name: producto_sucursal producto_sucursal_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_sucursal
    ADD CONSTRAINT producto_sucursal_pkey PRIMARY KEY (id);


--
-- TOC entry 3027 (class 2606 OID 16419)
-- Name: sucursal sucursal_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sucursal
    ADD CONSTRAINT sucursal_pkey PRIMARY KEY (id);


--
-- TOC entry 3030 (class 2606 OID 16401)
-- Name: producto producto_moneda_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto
    ADD CONSTRAINT producto_moneda_id_fkey FOREIGN KEY (moneda_id) REFERENCES public.moneda(id) NOT VALID;


--
-- TOC entry 3033 (class 2606 OID 16572)
-- Name: producto_sucursal producto_sucursal_producto_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_sucursal
    ADD CONSTRAINT producto_sucursal_producto_id_fkey FOREIGN KEY (producto_id) REFERENCES public.producto(codigo);


--
-- TOC entry 3032 (class 2606 OID 16460)
-- Name: producto_sucursal producto_sucursal_sucursal_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.producto_sucursal
    ADD CONSTRAINT producto_sucursal_sucursal_id_fkey FOREIGN KEY (sucursal_id) REFERENCES public.sucursal(id);

--
-- TOC entry 3031 (class 2606 OID 16420)
-- Name: sucursal sucursal_bodega_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sucursal
    ADD CONSTRAINT sucursal_bodega_id_fkey FOREIGN KEY (bodega_id) REFERENCES public.bodega(id);