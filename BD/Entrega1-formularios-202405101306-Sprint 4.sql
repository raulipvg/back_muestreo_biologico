PGDMP                 
        |            formularios    15.2    15.2 �    '           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            (           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            )           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            *           1262    27051    formularios    DATABASE     �   CREATE DATABASE formularios WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Latin America.1252';
    DROP DATABASE formularios;
                postgres    false                        2615    27273    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                pg_database_owner    false            +           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   pg_database_owner    false    5            ,           0    0    SCHEMA public    ACL     +   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
                   pg_database_owner    false    5            �            1259    27274    acc_formulario_grupo    TABLE     y  CREATE TABLE public.acc_formulario_grupo (
    id integer NOT NULL,
    formulario_id integer NOT NULL,
    grupo_id integer NOT NULL,
    privilegio5 boolean,
    privilegio6 boolean,
    privilegio7 boolean,
    privilegio8 boolean,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 (   DROP TABLE public.acc_formulario_grupo;
       public         heap    postgres    false    5            �            1259    27279    acc_formulario_grupo_id_seq    SEQUENCE     �   CREATE SEQUENCE public.acc_formulario_grupo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.acc_formulario_grupo_id_seq;
       public          postgres    false    5    214            -           0    0    acc_formulario_grupo_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.acc_formulario_grupo_id_seq OWNED BY public.acc_formulario_grupo.id;
          public          postgres    false    215            �            1259    27280    acc_usuario_grupos    TABLE     2  CREATE TABLE public.acc_usuario_grupos (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    grupo_id integer NOT NULL,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 &   DROP TABLE public.acc_usuario_grupos;
       public         heap    postgres    false    5            �            1259    27286    acc_usuario_grupos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.acc_usuario_grupos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.acc_usuario_grupos_id_seq;
       public          postgres    false    216    5            .           0    0    acc_usuario_grupos_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.acc_usuario_grupos_id_seq OWNED BY public.acc_usuario_grupos.id;
          public          postgres    false    217            �            1259    27287    clasificaciones    TABLE     $  CREATE TABLE public.clasificaciones (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
 #   DROP TABLE public.clasificaciones;
       public         heap    postgres    false    5            �            1259    27293    clasificaciones_id_seq    SEQUENCE     �   CREATE SEQUENCE public.clasificaciones_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.clasificaciones_id_seq;
       public          postgres    false    218    5            /           0    0    clasificaciones_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.clasificaciones_id_seq OWNED BY public.clasificaciones.id;
          public          postgres    false    219            �            1259    27294    departamentos    TABLE     "  CREATE TABLE public.departamentos (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
 !   DROP TABLE public.departamentos;
       public         heap    postgres    false    5            �            1259    27300    departamentos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.departamentos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.departamentos_id_seq;
       public          postgres    false    220    5            0           0    0    departamentos_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.departamentos_id_seq OWNED BY public.departamentos.id;
          public          postgres    false    221            �            1259    27301    formularios    TABLE     6  CREATE TABLE public.formularios (
    id integer NOT NULL,
    titulo character varying(255) NOT NULL,
    descripcion text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
    DROP TABLE public.formularios;
       public         heap    postgres    false    5            �            1259    27309    encuestas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.encuestas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.encuestas_id_seq;
       public          postgres    false    5    222            1           0    0    encuestas_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.encuestas_id_seq OWNED BY public.formularios.id;
          public          postgres    false    223            �            1259    27310    especies    TABLE       CREATE TABLE public.especies (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL,
    talla_min integer DEFAULT 1 NOT NULL,
    talla_max integer DEFAULT 2 NOT NULL,
    peso_min integer DEFAULT 1 NOT NULL,
    peso_max integer DEFAULT 2 NOT NULL,
    talla_menor_a numeric DEFAULT 1 NOT NULL,
    tipo1 integer DEFAULT 1 NOT NULL
);
    DROP TABLE public.especies;
       public         heap    postgres    false    5            �            1259    27316    especies_id_seq    SEQUENCE     �   CREATE SEQUENCE public.especies_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.especies_id_seq;
       public          postgres    false    224    5            2           0    0    especies_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.especies_id_seq OWNED BY public.especies.id;
          public          postgres    false    225            �            1259    27317    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false    5            �            1259    27323    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    5    226            3           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    227            �            1259    27324    flotas    TABLE       CREATE TABLE public.flotas (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
    DROP TABLE public.flotas;
       public         heap    postgres    false    5            �            1259    27330    flotas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.flotas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.flotas_id_seq;
       public          postgres    false    5    228            4           0    0    flotas_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.flotas_id_seq OWNED BY public.flotas.id;
          public          postgres    false    229            �            1259    27331    grupo_privilegio    TABLE     A  CREATE TABLE public.grupo_privilegio (
    id integer NOT NULL,
    grupo_id integer NOT NULL,
    privilegio_id integer NOT NULL,
    privilegio1 boolean,
    privilegio2 boolean,
    privilegio3 boolean,
    privilegio4 boolean,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);
 $   DROP TABLE public.grupo_privilegio;
       public         heap    postgres    false    5            �            1259    27334    grupo_privilegio_id_seq    SEQUENCE     �   CREATE SEQUENCE public.grupo_privilegio_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.grupo_privilegio_id_seq;
       public          postgres    false    230    5            5           0    0    grupo_privilegio_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.grupo_privilegio_id_seq OWNED BY public.grupo_privilegio.id;
          public          postgres    false    231            �            1259    27335    grupos    TABLE     C  CREATE TABLE public.grupos (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion character varying(255) NOT NULL,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.grupos;
       public         heap    postgres    false    5            �            1259    27343    grupos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.grupos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.grupos_id_seq;
       public          postgres    false    232    5            6           0    0    grupos_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.grupos_id_seq OWNED BY public.grupos.id;
          public          postgres    false    233            �            1259    27344    lugar_m    TABLE       CREATE TABLE public.lugar_m (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
    DROP TABLE public.lugar_m;
       public         heap    postgres    false    5            �            1259    27350    lugar_m_id_seq    SEQUENCE     �   CREATE SEQUENCE public.lugar_m_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.lugar_m_id_seq;
       public          postgres    false    234    5            7           0    0    lugar_m_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.lugar_m_id_seq OWNED BY public.lugar_m.id;
          public          postgres    false    235            �            1259    27351 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false    5            �            1259    27354    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    236    5            8           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    237            �            1259    27355    naves    TABLE     C  CREATE TABLE public.naves (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL,
    flota_id integer DEFAULT 1 NOT NULL
);
    DROP TABLE public.naves;
       public         heap    postgres    false    5            �            1259    27361    naves_id_seq    SEQUENCE     �   CREATE SEQUENCE public.naves_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.naves_id_seq;
       public          postgres    false    238    5            9           0    0    naves_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.naves_id_seq OWNED BY public.naves.id;
          public          postgres    false    239            �            1259    27362    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap    postgres    false    5            �            1259    27367    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false    5            �            1259    27372    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    241    5            :           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    242            �            1259    27373    personas    TABLE     s  CREATE TABLE public.personas (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL,
    apellido character varying(255) NOT NULL,
    rut character varying(13) NOT NULL
);
    DROP TABLE public.personas;
       public         heap    postgres    false    5            �            1259    27381    personas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.personas_id_seq;
       public          postgres    false    5    243            ;           0    0    personas_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.personas_id_seq OWNED BY public.personas.id;
          public          postgres    false    244            �            1259    27382    plantas    TABLE       CREATE TABLE public.plantas (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
    DROP TABLE public.plantas;
       public         heap    postgres    false    5            �            1259    27388    plantas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.plantas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.plantas_id_seq;
       public          postgres    false    245    5            <           0    0    plantas_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.plantas_id_seq OWNED BY public.plantas.id;
          public          postgres    false    246            �            1259    27389    privilegio_maestro    TABLE     O  CREATE TABLE public.privilegio_maestro (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion character varying(255) NOT NULL,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 &   DROP TABLE public.privilegio_maestro;
       public         heap    postgres    false    5            �            1259    27397    privilegio_maestro_id_seq    SEQUENCE     �   CREATE SEQUENCE public.privilegio_maestro_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.privilegio_maestro_id_seq;
       public          postgres    false    247    5            =           0    0    privilegio_maestro_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.privilegio_maestro_id_seq OWNED BY public.privilegio_maestro.id;
          public          postgres    false    248            �            1259    27398    puertos    TABLE       CREATE TABLE public.puertos (
    id integer NOT NULL,
    nombre character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    enabled boolean DEFAULT true NOT NULL
);
    DROP TABLE public.puertos;
       public         heap    postgres    false    5            �            1259    27404    puertos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.puertos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.puertos_id_seq;
       public          postgres    false    5    249            >           0    0    puertos_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.puertos_id_seq OWNED BY public.puertos.id;
          public          postgres    false    250            �            1259    27405    resp_formularios    TABLE     G  CREATE TABLE public.resp_formularios (
    id integer NOT NULL,
    formulario_id integer NOT NULL,
    json jsonb NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone,
    enabled boolean DEFAULT true NOT NULL,
    usuario_id integer DEFAULT 1 NOT NULL
);
 $   DROP TABLE public.resp_formularios;
       public         heap    postgres    false    5                       1259    27601    resp_storage    TABLE     '  CREATE TABLE public.resp_storage (
    id integer NOT NULL,
    nombre character varying NOT NULL,
    url character varying NOT NULL,
    respuesta_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone
);
     DROP TABLE public.resp_storage;
       public         heap    postgres    false    5                       1259    27600    resp_storage_id_seq    SEQUENCE     �   CREATE SEQUENCE public.resp_storage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.resp_storage_id_seq;
       public          postgres    false    5    258            ?           0    0    resp_storage_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.resp_storage_id_seq OWNED BY public.resp_storage.id;
          public          postgres    false    257            �            1259    27413    respuestas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.respuestas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.respuestas_id_seq;
       public          postgres    false    5    251            @           0    0    respuestas_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.respuestas_id_seq OWNED BY public.resp_formularios.id;
          public          postgres    false    252            �            1259    27414    users    TABLE     x  CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap    postgres    false    5            �            1259    27419    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    253    5            A           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    254            �            1259    27420    usuarios    TABLE     �  CREATE TABLE public.usuarios (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    google_id integer,
    email character varying(50) NOT NULL,
    enabled boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    persona_id integer NOT NULL
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false    5                        1259    27428    usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.usuarios_id_seq;
       public          postgres    false    255    5            B           0    0    usuarios_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;
          public          postgres    false    256            �           2604    27429    acc_formulario_grupo id    DEFAULT     �   ALTER TABLE ONLY public.acc_formulario_grupo ALTER COLUMN id SET DEFAULT nextval('public.acc_formulario_grupo_id_seq'::regclass);
 F   ALTER TABLE public.acc_formulario_grupo ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    214            �           2604    27430    acc_usuario_grupos id    DEFAULT     ~   ALTER TABLE ONLY public.acc_usuario_grupos ALTER COLUMN id SET DEFAULT nextval('public.acc_usuario_grupos_id_seq'::regclass);
 D   ALTER TABLE public.acc_usuario_grupos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    217    216            �           2604    27431    clasificaciones id    DEFAULT     x   ALTER TABLE ONLY public.clasificaciones ALTER COLUMN id SET DEFAULT nextval('public.clasificaciones_id_seq'::regclass);
 A   ALTER TABLE public.clasificaciones ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    218            �           2604    27432    departamentos id    DEFAULT     t   ALTER TABLE ONLY public.departamentos ALTER COLUMN id SET DEFAULT nextval('public.departamentos_id_seq'::regclass);
 ?   ALTER TABLE public.departamentos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    220            �           2604    27433    especies id    DEFAULT     j   ALTER TABLE ONLY public.especies ALTER COLUMN id SET DEFAULT nextval('public.especies_id_seq'::regclass);
 :   ALTER TABLE public.especies ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    224            �           2604    27434    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    226            �           2604    27435 	   flotas id    DEFAULT     f   ALTER TABLE ONLY public.flotas ALTER COLUMN id SET DEFAULT nextval('public.flotas_id_seq'::regclass);
 8   ALTER TABLE public.flotas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    229    228            �           2604    27436    formularios id    DEFAULT     n   ALTER TABLE ONLY public.formularios ALTER COLUMN id SET DEFAULT nextval('public.encuestas_id_seq'::regclass);
 =   ALTER TABLE public.formularios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222            �           2604    27437    grupo_privilegio id    DEFAULT     z   ALTER TABLE ONLY public.grupo_privilegio ALTER COLUMN id SET DEFAULT nextval('public.grupo_privilegio_id_seq'::regclass);
 B   ALTER TABLE public.grupo_privilegio ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    231    230            �           2604    27438 	   grupos id    DEFAULT     f   ALTER TABLE ONLY public.grupos ALTER COLUMN id SET DEFAULT nextval('public.grupos_id_seq'::regclass);
 8   ALTER TABLE public.grupos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    233    232            �           2604    27439 
   lugar_m id    DEFAULT     h   ALTER TABLE ONLY public.lugar_m ALTER COLUMN id SET DEFAULT nextval('public.lugar_m_id_seq'::regclass);
 9   ALTER TABLE public.lugar_m ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    235    234            �           2604    27440    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    237    236            �           2604    27441    naves id    DEFAULT     d   ALTER TABLE ONLY public.naves ALTER COLUMN id SET DEFAULT nextval('public.naves_id_seq'::regclass);
 7   ALTER TABLE public.naves ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    239    238                       2604    27442    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    242    241                       2604    27443    personas id    DEFAULT     j   ALTER TABLE ONLY public.personas ALTER COLUMN id SET DEFAULT nextval('public.personas_id_seq'::regclass);
 :   ALTER TABLE public.personas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    244    243            	           2604    27444 
   plantas id    DEFAULT     h   ALTER TABLE ONLY public.plantas ALTER COLUMN id SET DEFAULT nextval('public.plantas_id_seq'::regclass);
 9   ALTER TABLE public.plantas ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    246    245                       2604    27445    privilegio_maestro id    DEFAULT     ~   ALTER TABLE ONLY public.privilegio_maestro ALTER COLUMN id SET DEFAULT nextval('public.privilegio_maestro_id_seq'::regclass);
 D   ALTER TABLE public.privilegio_maestro ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    248    247                       2604    27446 
   puertos id    DEFAULT     h   ALTER TABLE ONLY public.puertos ALTER COLUMN id SET DEFAULT nextval('public.puertos_id_seq'::regclass);
 9   ALTER TABLE public.puertos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    250    249                       2604    27447    resp_formularios id    DEFAULT     t   ALTER TABLE ONLY public.resp_formularios ALTER COLUMN id SET DEFAULT nextval('public.respuestas_id_seq'::regclass);
 B   ALTER TABLE public.resp_formularios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    252    251                       2604    27604    resp_storage id    DEFAULT     r   ALTER TABLE ONLY public.resp_storage ALTER COLUMN id SET DEFAULT nextval('public.resp_storage_id_seq'::regclass);
 >   ALTER TABLE public.resp_storage ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    257    258    258                       2604    27448    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    254    253                       2604    27449    usuarios id    DEFAULT     j   ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);
 :   ALTER TABLE public.usuarios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    256    255            �          0    27274    acc_formulario_grupo 
   TABLE DATA           �   COPY public.acc_formulario_grupo (id, formulario_id, grupo_id, privilegio5, privilegio6, privilegio7, privilegio8, created_at, updated_at) FROM stdin;
    public          postgres    false    214   q�       �          0    27280    acc_usuario_grupos 
   TABLE DATA           g   COPY public.acc_usuario_grupos (id, usuario_id, grupo_id, enabled, created_at, updated_at) FROM stdin;
    public          postgres    false    216   ��       �          0    27287    clasificaciones 
   TABLE DATA           V   COPY public.clasificaciones (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    218   ��       �          0    27294    departamentos 
   TABLE DATA           T   COPY public.departamentos (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    220   �                 0    27310    especies 
   TABLE DATA           �   COPY public.especies (id, nombre, created_at, updated_at, enabled, talla_min, talla_max, peso_min, peso_max, talla_menor_a, tipo1) FROM stdin;
    public          postgres    false    224   b�                 0    27317    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    226   ��                 0    27324    flotas 
   TABLE DATA           M   COPY public.flotas (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    228   �                  0    27301    formularios 
   TABLE DATA           _   COPY public.formularios (id, titulo, descripcion, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    222   ��                 0    27331    grupo_privilegio 
   TABLE DATA           �   COPY public.grupo_privilegio (id, grupo_id, privilegio_id, privilegio1, privilegio2, privilegio3, privilegio4, created_at, updated_at) FROM stdin;
    public          postgres    false    230   ��       
          0    27335    grupos 
   TABLE DATA           Z   COPY public.grupos (id, nombre, descripcion, enabled, created_at, updated_at) FROM stdin;
    public          postgres    false    232   �                 0    27344    lugar_m 
   TABLE DATA           N   COPY public.lugar_m (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    234   9�                 0    27351 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    236   ��                 0    27355    naves 
   TABLE DATA           V   COPY public.naves (id, nombre, created_at, updated_at, enabled, flota_id) FROM stdin;
    public          postgres    false    238   �                 0    27362    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public          postgres    false    240   l�                 0    27367    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
    public          postgres    false    241   ��                 0    27373    personas 
   TABLE DATA           ^   COPY public.personas (id, nombre, created_at, updated_at, enabled, apellido, rut) FROM stdin;
    public          postgres    false    243   ��                 0    27382    plantas 
   TABLE DATA           N   COPY public.plantas (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    245   :�                 0    27389    privilegio_maestro 
   TABLE DATA           f   COPY public.privilegio_maestro (id, nombre, descripcion, enabled, created_at, updated_at) FROM stdin;
    public          postgres    false    247   ��                 0    27398    puertos 
   TABLE DATA           N   COPY public.puertos (id, nombre, created_at, updated_at, enabled) FROM stdin;
    public          postgres    false    249   ��                 0    27405    resp_formularios 
   TABLE DATA           p   COPY public.resp_formularios (id, formulario_id, json, created_at, updated_at, enabled, usuario_id) FROM stdin;
    public          postgres    false    251   �       $          0    27601    resp_storage 
   TABLE DATA           ]   COPY public.resp_storage (id, nombre, url, respuesta_id, created_at, updated_at) FROM stdin;
    public          postgres    false    258   #�                 0    27414    users 
   TABLE DATA           u   COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
    public          postgres    false    253   @�       !          0    27420    usuarios 
   TABLE DATA           y   COPY public.usuarios (id, username, password, google_id, email, enabled, created_at, updated_at, persona_id) FROM stdin;
    public          postgres    false    255   ]�       C           0    0    acc_formulario_grupo_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.acc_formulario_grupo_id_seq', 1, false);
          public          postgres    false    215            D           0    0    acc_usuario_grupos_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.acc_usuario_grupos_id_seq', 1, false);
          public          postgres    false    217            E           0    0    clasificaciones_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.clasificaciones_id_seq', 84, true);
          public          postgres    false    219            F           0    0    departamentos_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.departamentos_id_seq', 12, true);
          public          postgres    false    221            G           0    0    encuestas_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.encuestas_id_seq', 2, true);
          public          postgres    false    223            H           0    0    especies_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.especies_id_seq', 22, true);
          public          postgres    false    225            I           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    227            J           0    0    flotas_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.flotas_id_seq', 11, true);
          public          postgres    false    229            K           0    0    grupo_privilegio_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.grupo_privilegio_id_seq', 1, false);
          public          postgres    false    231            L           0    0    grupos_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.grupos_id_seq', 1, false);
          public          postgres    false    233            M           0    0    lugar_m_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.lugar_m_id_seq', 4, true);
          public          postgres    false    235            N           0    0    migrations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.migrations_id_seq', 4, true);
          public          postgres    false    237            O           0    0    naves_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.naves_id_seq', 6, true);
          public          postgres    false    239            P           0    0    personal_access_tokens_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 9, true);
          public          postgres    false    242            Q           0    0    personas_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.personas_id_seq', 5, true);
          public          postgres    false    244            R           0    0    plantas_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.plantas_id_seq', 12, true);
          public          postgres    false    246            S           0    0    privilegio_maestro_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.privilegio_maestro_id_seq', 1, false);
          public          postgres    false    248            T           0    0    puertos_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.puertos_id_seq', 35, true);
          public          postgres    false    250            U           0    0    resp_storage_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.resp_storage_id_seq', 12, true);
          public          postgres    false    257            V           0    0    respuestas_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.respuestas_id_seq', 47, true);
          public          postgres    false    252            W           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 1, false);
          public          postgres    false    254            X           0    0    usuarios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuarios_id_seq', 6, true);
          public          postgres    false    256            !           2606    27451 ,   acc_formulario_grupo acc_formulario_grupo_pk 
   CONSTRAINT     j   ALTER TABLE ONLY public.acc_formulario_grupo
    ADD CONSTRAINT acc_formulario_grupo_pk PRIMARY KEY (id);
 V   ALTER TABLE ONLY public.acc_formulario_grupo DROP CONSTRAINT acc_formulario_grupo_pk;
       public            postgres    false    214            #           2606    27453 (   acc_usuario_grupos acc_usuario_grupos_pk 
   CONSTRAINT     f   ALTER TABLE ONLY public.acc_usuario_grupos
    ADD CONSTRAINT acc_usuario_grupos_pk PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.acc_usuario_grupos DROP CONSTRAINT acc_usuario_grupos_pk;
       public            postgres    false    216            &           2606    27455 $   clasificaciones clasificaciones_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.clasificaciones
    ADD CONSTRAINT clasificaciones_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.clasificaciones DROP CONSTRAINT clasificaciones_pkey;
       public            postgres    false    218            )           2606    27457     departamentos departamentos_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.departamentos
    ADD CONSTRAINT departamentos_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.departamentos DROP CONSTRAINT departamentos_pkey;
       public            postgres    false    220            +           2606    27459    formularios encuestas_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.formularios
    ADD CONSTRAINT encuestas_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.formularios DROP CONSTRAINT encuestas_pkey;
       public            postgres    false    222            /           2606    27461    especies especies_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.especies
    ADD CONSTRAINT especies_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.especies DROP CONSTRAINT especies_pkey;
       public            postgres    false    224            1           2606    27463    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    226            3           2606    27465 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    226            6           2606    27467    flotas flotas_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.flotas
    ADD CONSTRAINT flotas_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.flotas DROP CONSTRAINT flotas_pkey;
       public            postgres    false    228            :           2606    27469    grupos grupo_pk 
   CONSTRAINT     M   ALTER TABLE ONLY public.grupos
    ADD CONSTRAINT grupo_pk PRIMARY KEY (id);
 9   ALTER TABLE ONLY public.grupos DROP CONSTRAINT grupo_pk;
       public            postgres    false    232            8           2606    27471 $   grupo_privilegio grupo_privilegio_pk 
   CONSTRAINT     b   ALTER TABLE ONLY public.grupo_privilegio
    ADD CONSTRAINT grupo_privilegio_pk PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.grupo_privilegio DROP CONSTRAINT grupo_privilegio_pk;
       public            postgres    false    230            =           2606    27473    lugar_m lugar_m_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.lugar_m
    ADD CONSTRAINT lugar_m_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.lugar_m DROP CONSTRAINT lugar_m_pkey;
       public            postgres    false    234            ?           2606    27475    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    236            A           2606    27477    naves naves_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.naves
    ADD CONSTRAINT naves_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.naves DROP CONSTRAINT naves_pkey;
       public            postgres    false    238            C           2606    27479 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public            postgres    false    240            E           2606    27481 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    241            G           2606    27483 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    241            J           2606    27485    personas personas_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.personas
    ADD CONSTRAINT personas_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.personas DROP CONSTRAINT personas_pkey;
       public            postgres    false    243            M           2606    27487    plantas plantas_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.plantas
    ADD CONSTRAINT plantas_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.plantas DROP CONSTRAINT plantas_pkey;
       public            postgres    false    245            O           2606    27489 (   privilegio_maestro privilegio_maestro_pk 
   CONSTRAINT     f   ALTER TABLE ONLY public.privilegio_maestro
    ADD CONSTRAINT privilegio_maestro_pk PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.privilegio_maestro DROP CONSTRAINT privilegio_maestro_pk;
       public            postgres    false    247            R           2606    27491    puertos puertos_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.puertos
    ADD CONSTRAINT puertos_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.puertos DROP CONSTRAINT puertos_pkey;
       public            postgres    false    249            ^           2606    27609    resp_storage resp_storage_pk 
   CONSTRAINT     Z   ALTER TABLE ONLY public.resp_storage
    ADD CONSTRAINT resp_storage_pk PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.resp_storage DROP CONSTRAINT resp_storage_pk;
       public            postgres    false    258            T           2606    27493     resp_formularios respuestas_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.resp_formularios
    ADD CONSTRAINT respuestas_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.resp_formularios DROP CONSTRAINT respuestas_pkey;
       public            postgres    false    251            V           2606    27495    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    253            X           2606    27497    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    253            Z           2606    27499    usuarios usuarios_pk 
   CONSTRAINT     R   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pk PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pk;
       public            postgres    false    255            \           2606    27501    usuarios usuarios_unique 
   CONSTRAINT     W   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_unique UNIQUE (username);
 B   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_unique;
       public            postgres    false    255            $           1259    27502    clasificaciones_nombre_idx    INDEX     _   CREATE UNIQUE INDEX clasificaciones_nombre_idx ON public.clasificaciones USING btree (nombre);
 .   DROP INDEX public.clasificaciones_nombre_idx;
       public            postgres    false    218            '           1259    27503    departamentos_nombre_idx    INDEX     [   CREATE UNIQUE INDEX departamentos_nombre_idx ON public.departamentos USING btree (nombre);
 ,   DROP INDEX public.departamentos_nombre_idx;
       public            postgres    false    220            -           1259    27504    especies_nombre_idx    INDEX     Q   CREATE UNIQUE INDEX especies_nombre_idx ON public.especies USING btree (nombre);
 '   DROP INDEX public.especies_nombre_idx;
       public            postgres    false    224            4           1259    27505    flotas_nombre_idx    INDEX     M   CREATE UNIQUE INDEX flotas_nombre_idx ON public.flotas USING btree (nombre);
 %   DROP INDEX public.flotas_nombre_idx;
       public            postgres    false    228            ,           1259    27506    formularios_titulo_idx    INDEX     W   CREATE UNIQUE INDEX formularios_titulo_idx ON public.formularios USING btree (titulo);
 *   DROP INDEX public.formularios_titulo_idx;
       public            postgres    false    222            ;           1259    27507    lugar_m_nombre_idx    INDEX     O   CREATE UNIQUE INDEX lugar_m_nombre_idx ON public.lugar_m USING btree (nombre);
 &   DROP INDEX public.lugar_m_nombre_idx;
       public            postgres    false    234            H           1259    27508 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    241    241            K           1259    27509    plantas_nombre_idx    INDEX     O   CREATE UNIQUE INDEX plantas_nombre_idx ON public.plantas USING btree (nombre);
 &   DROP INDEX public.plantas_nombre_idx;
       public            postgres    false    245            P           1259    27510    puertos_nombre_idx    INDEX     O   CREATE UNIQUE INDEX puertos_nombre_idx ON public.puertos USING btree (nombre);
 &   DROP INDEX public.puertos_nombre_idx;
       public            postgres    false    249            _           2606    27511 8   acc_formulario_grupo acc_formulario_grupo_formularios_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.acc_formulario_grupo
    ADD CONSTRAINT acc_formulario_grupo_formularios_fk FOREIGN KEY (formulario_id) REFERENCES public.formularios(id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.acc_formulario_grupo DROP CONSTRAINT acc_formulario_grupo_formularios_fk;
       public          postgres    false    3371    214    222            `           2606    27516 3   acc_formulario_grupo acc_formulario_grupo_grupos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.acc_formulario_grupo
    ADD CONSTRAINT acc_formulario_grupo_grupos_fk FOREIGN KEY (grupo_id) REFERENCES public.grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;
 ]   ALTER TABLE ONLY public.acc_formulario_grupo DROP CONSTRAINT acc_formulario_grupo_grupos_fk;
       public          postgres    false    232    3386    214            a           2606    27521 /   acc_usuario_grupos acc_usuario_grupos_grupos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.acc_usuario_grupos
    ADD CONSTRAINT acc_usuario_grupos_grupos_fk FOREIGN KEY (grupo_id) REFERENCES public.grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.acc_usuario_grupos DROP CONSTRAINT acc_usuario_grupos_grupos_fk;
       public          postgres    false    3386    216    232            b           2606    27526 1   acc_usuario_grupos acc_usuario_grupos_usuarios_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.acc_usuario_grupos
    ADD CONSTRAINT acc_usuario_grupos_usuarios_fk FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE;
 [   ALTER TABLE ONLY public.acc_usuario_grupos DROP CONSTRAINT acc_usuario_grupos_usuarios_fk;
       public          postgres    false    3418    216    255            c           2606    27531 +   grupo_privilegio grupo_privilegio_grupos_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.grupo_privilegio
    ADD CONSTRAINT grupo_privilegio_grupos_fk FOREIGN KEY (grupo_id) REFERENCES public.grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;
 U   ALTER TABLE ONLY public.grupo_privilegio DROP CONSTRAINT grupo_privilegio_grupos_fk;
       public          postgres    false    3386    232    230            d           2606    27536 7   grupo_privilegio grupo_privilegio_privilegio_maestro_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.grupo_privilegio
    ADD CONSTRAINT grupo_privilegio_privilegio_maestro_fk FOREIGN KEY (privilegio_id) REFERENCES public.privilegio_maestro(id) ON UPDATE CASCADE ON DELETE CASCADE;
 a   ALTER TABLE ONLY public.grupo_privilegio DROP CONSTRAINT grupo_privilegio_privilegio_maestro_fk;
       public          postgres    false    247    230    3407            e           2606    27595    naves naves_flotas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.naves
    ADD CONSTRAINT naves_flotas_fk FOREIGN KEY (flota_id) REFERENCES public.flotas(id) ON UPDATE RESTRICT ON DELETE RESTRICT;
 ?   ALTER TABLE ONLY public.naves DROP CONSTRAINT naves_flotas_fk;
       public          postgres    false    3382    228    238            f           2606    27541 0   resp_formularios resp_formularios_formularios_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.resp_formularios
    ADD CONSTRAINT resp_formularios_formularios_fk FOREIGN KEY (formulario_id) REFERENCES public.formularios(id) ON UPDATE CASCADE ON DELETE CASCADE;
 Z   ALTER TABLE ONLY public.resp_formularios DROP CONSTRAINT resp_formularios_formularios_fk;
       public          postgres    false    251    222    3371            g           2606    27546 -   resp_formularios resp_formularios_usuarios_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.resp_formularios
    ADD CONSTRAINT resp_formularios_usuarios_fk FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id);
 W   ALTER TABLE ONLY public.resp_formularios DROP CONSTRAINT resp_formularios_usuarios_fk;
       public          postgres    false    251    255    3418            i           2606    27610 -   resp_storage resp_storage_resp_formularios_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.resp_storage
    ADD CONSTRAINT resp_storage_resp_formularios_fk FOREIGN KEY (respuesta_id) REFERENCES public.resp_formularios(id) ON UPDATE RESTRICT ON DELETE RESTRICT;
 W   ALTER TABLE ONLY public.resp_storage DROP CONSTRAINT resp_storage_resp_formularios_fk;
       public          postgres    false    251    3412    258            h           2606    27551    usuarios usuarios_personas_fk    FK CONSTRAINT     �   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_personas_fk FOREIGN KEY (persona_id) REFERENCES public.personas(id) ON UPDATE CASCADE ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_personas_fk;
       public          postgres    false    255    3402    243            �      x������ � �      �      x������ � �      �   Q   x�3��p��sT�Uptv�qUpqUpvvt��4202�50�5�T04�24�20�3��4�0�K�L�����%\1z\\\ ��      �   F   x�3�tvur��t��WpqUpv��tqt�4202�50�5�T04�24�2�г0477��'U����� i�E         �  x�}�Qn� ��ǧ�b1��IP���8�v�c�"=S/V��h�Il�����O�0���}JH��	�Cۢtbp�:#�1N��> �b^I���@��ZBb*��t�,��Љ'��4|>��´l68]����]u]T�a��F�ŗc̾�W��9��qD��@GC��٤k�{�Zq�>�cLi���N��<�T��Q)�Bu^��+Ī<��C��ʚ:4F
�\ �$؏9N��=b��-�lr>#1���3V�aE�1��s��UYo�b2���x�bې}^���|BW	������ZGh���Ρ�𛇔#�	k��[��L%N%<��Ê��0��2惯Wm-�k����zK��z��(<�8<l�O�|��(%�0�6�SY��F�M�-��]�4����            x������ � �         ]   x�3���s		�t��4202�50�5�T04�24�26�311�44�K(�Z�Y��s�pq:��;��j62�2��2��e4�+F��� ��!          j   x�3�t�/�-�I,��W�-M-.)J�Wp����O�L��tN��LIL�4202�5 "SC#+S+C=3K#cSK������������!g	���hR32�L����� �h*�            x������ � �      
      x������ � �         I   x�3�����S�q�tTp
rs�4202�50�5�T04�2��2��36�4�4G�22�21�2��,����� vId         x   x�]�A
�0E��a$�л�i�54��x}�k��_����� �9�Jm��XM��A\�e���Y�JcC+7Ϋ��������	�2�x\��.����2k��D���i�{�f@�         B   x�3�tqtv�uT��4202�50�5�T04�20�25�3503�4D���24�25�,�4����� �:            x������ � �         �   x�}λN�@@���
�)h��p�@G���
�I��Х0H������p�����8�Oǳ}��v>���֏�0�II�ԑ�@�Ȭ�qr�Z���
sU��	���2<�nw/����dOzC0�%�z#m��f�C��6�n%'��dm\-z���Ւ��ߗS�n���D��Fކ�5L���3H����f	L�kF��Rm	�F � �9Z���p�$o�q����=w�         �   x�m�A
�@��u��@K��h'�XJ�S�E\{��J���z�4c:O��z`d)QJ�y%V��(��/��a���?Вc��l���_	���ɲ�< /9٦����u8�R��iG�'����}mTXVX#��j�CgSjD*y�w��sOXd;z         \   x�U�M
� @ᵞ�(���.�m�֮ct*���{|h����Ms]�!��!z��BVL�C����P�eKo[���*�m�V/�k�	�-            x������ � �         3   x�3��"WN##]]CKCc+CC+s=s#3cc|R%\1z\\\ 
��            x������ � �      $      x������ � �            x������ � �      !   �   x�3�LL��̃�1~���K���,�4202�50�52Q0��24�26�3�0631�'e�e�YZ�ZdĩbT�bh���R�S��a��WV��T��mT�\�W�_jP�cR�S�X�h�SiT��PrQjnbf��Dw������a3����� U�;     