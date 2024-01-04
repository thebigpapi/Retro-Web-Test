--
-- PostgreSQL database dump
--

-- Dumped from database version 14.1 (Debian 14.1-1.pgdg110+1)
-- Dumped by pg_dump version 14.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: audio_chipset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.audio_chipset (
    id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) DEFAULT NULL::character varying,
    chip_name character varying(255) DEFAULT NULL::character varying
);



--
-- Name: audio_chipset_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.audio_chipset_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: cache_method; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_method (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: cache_method_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cache_method_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: cache_ratio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_ratio (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: cache_ratio_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cache_ratio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: cache_size; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_size (
    id integer NOT NULL,
    value integer NOT NULL
);



--
-- Name: cache_size_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cache_size_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chip; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chip (
    id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) DEFAULT NULL::character varying,
    part_number character varying(255) NOT NULL,
    dtype character varying(255) NOT NULL
);



--
-- Name: chip_alias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chip_alias (
    id integer NOT NULL,
    chip_id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) DEFAULT NULL::character varying,
    part_number character varying(255) NOT NULL
);



--
-- Name: chip_alias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chip_alias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chip_documentation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chip_documentation (
    id integer NOT NULL,
    chip_id integer,
    language_id integer NOT NULL,
    file_name character varying(255) NOT NULL,
    link_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: chip_documentation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chip_documentation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chip_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chip_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chip_image; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chip_image (
    id integer NOT NULL,
    chip_id integer NOT NULL,
    creditor_id integer,
    license_id integer NOT NULL,
    file_name character varying(255) NOT NULL,
    description character varying(255) DEFAULT NULL::character varying,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: chip_image_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chip_image_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chipset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chipset (
    id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) DEFAULT NULL::character varying,
    encyclopedia_link character varying(255) DEFAULT NULL::character varying,
    release_date character varying(255) DEFAULT NULL::character varying,
    part_no character varying(255) DEFAULT NULL::character varying,
    description character varying(4096) DEFAULT NULL::character varying
);



--
-- Name: chipset_bios_code; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chipset_bios_code (
    id integer NOT NULL,
    chipset_id integer NOT NULL,
    bios_manufacturer_id integer NOT NULL,
    code character varying(255) NOT NULL
);



--
-- Name: chipset_bios_code_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chipset_bios_code_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chipset_chipset_part; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chipset_chipset_part (
    chipset_id integer NOT NULL,
    chipset_part_id integer NOT NULL
);



--
-- Name: chipset_documentation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chipset_documentation (
    id integer NOT NULL,
    chipset_id integer,
    language_id integer NOT NULL,
    file_name character varying(255) NOT NULL,
    link_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: chipset_documentation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chipset_documentation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chipset_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.chipset_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: chipset_part; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chipset_part (
    id integer NOT NULL,
    description character varying(4096) DEFAULT NULL::character varying,
    rank integer NOT NULL
);



--
-- Name: coprocessor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coprocessor (
    id integer NOT NULL
);



--
-- Name: cpu_socket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cpu_socket (
    id integer NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    type character varying(255) NOT NULL
);



--
-- Name: cpu_socket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cpu_socket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: cpu_socket_processor_platform_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cpu_socket_processor_platform_type (
    cpu_socket_id integer NOT NULL,
    processor_platform_type_id integer NOT NULL
);



--
-- Name: cpu_speed; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cpu_speed (
    id integer NOT NULL,
    value double precision NOT NULL
);



--
-- Name: cpu_speed_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cpu_speed_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: creditor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.creditor (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    website character varying(255) DEFAULT NULL::character varying
);



--
-- Name: creditor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.creditor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);



--
-- Name: dram_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dram_type (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: dram_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dram_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: dump_quality_flag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dump_quality_flag (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    tag_name character varying(255) NOT NULL
);



--
-- Name: dump_quality_flag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dump_quality_flag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: expansion_connector; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.expansion_connector (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: expansion_connector_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.expansion_connector_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: expansion_slot; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.expansion_slot (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    hidden_search boolean NOT NULL
);



--
-- Name: expansion_slot_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.expansion_slot_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: form_factor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.form_factor (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: form_factor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.form_factor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: id_redirection; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.id_redirection (
    id integer NOT NULL,
    source integer NOT NULL,
    source_type character varying(255) NOT NULL,
    dtype character varying(255) NOT NULL
);



--
-- Name: id_redirection_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.id_redirection_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: import; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.import (
    id integer,
    file_name character varying
);



--
-- Name: instruction_set; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instruction_set (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: instruction_set_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.instruction_set_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: instruction_set_instruction_set; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instruction_set_instruction_set (
    instruction_set_source integer NOT NULL,
    instruction_set_target integer NOT NULL
);



--
-- Name: io_port; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.io_port (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: io_port_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.io_port_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: known_issue; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.known_issue (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: known_issue_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.known_issue_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: language; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.language (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    original_name character varying(255) NOT NULL,
    iso_code character varying(10) NOT NULL
);



--
-- Name: language_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.language_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: large_file; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file (
    id integer NOT NULL,
    dump_quality_flag_id integer NOT NULL,
    name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    subdirectory character varying(255) NOT NULL,
    file_version character varying(255) DEFAULT NULL::character varying,
    has_activation_key boolean NOT NULL,
    has_copy_protection boolean NOT NULL,
    note character varying(2048) DEFAULT NULL::character varying,
    release_date date,
    date_precision character varying(1) DEFAULT NULL::character varying
);



--
-- Name: large_file_chipset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file_chipset (
    id integer NOT NULL,
    large_file_id integer NOT NULL,
    chipset_id integer NOT NULL,
    is_recommended boolean NOT NULL
);



--
-- Name: large_file_chipset_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.large_file_chipset_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: large_file_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.large_file_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: large_file_language; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file_language (
    large_file_id integer NOT NULL,
    language_id integer NOT NULL
);



--
-- Name: large_file_media_type_flag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file_media_type_flag (
    id integer NOT NULL,
    large_file_id integer NOT NULL,
    media_type_flag_id integer NOT NULL,
    count integer NOT NULL
);



--
-- Name: large_file_media_type_flag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.large_file_media_type_flag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: large_file_motherboard; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file_motherboard (
    id integer NOT NULL,
    large_file_id integer NOT NULL,
    motherboard_id integer NOT NULL,
    is_recommended boolean NOT NULL
);



--
-- Name: large_file_motherboard_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.large_file_motherboard_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: large_file_os_flag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.large_file_os_flag (
    id integer NOT NULL,
    large_file_id integer NOT NULL,
    os_flag_id integer NOT NULL,
    unsure boolean NOT NULL
);



--
-- Name: large_file_os_flag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.large_file_os_flag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: license; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.license (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: license_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.license_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: manual; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.manual (
    id integer NOT NULL,
    motherboard_id integer,
    language_id integer NOT NULL,
    file_name character varying(255) NOT NULL,
    link_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: manual_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.manual_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: manufacturer; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.manufacturer (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    short_name character varying(255) DEFAULT NULL::character varying
);



--
-- Name: manufacturer_bios_manufacturer_code; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.manufacturer_bios_manufacturer_code (
    id integer NOT NULL,
    manufacturer_id integer NOT NULL,
    bios_manufacturer_id integer NOT NULL,
    code character varying(255) NOT NULL
);



--
-- Name: manufacturer_bios_manufacturer_code_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.manufacturer_bios_manufacturer_code_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: manufacturer_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.manufacturer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: max_ram; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.max_ram (
    id integer NOT NULL,
    value bigint NOT NULL
);



--
-- Name: max_ram_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.max_ram_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: media_type_flag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.media_type_flag (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    tag_name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: media_type_flag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.media_type_flag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard (
    id integer NOT NULL,
    manufacturer_id integer,
    chipset_id integer,
    form_factor_id integer,
    video_chipset_id integer,
    max_video_ram_id integer,
    audio_chipset_id integer,
    name character varying(255) DEFAULT NULL::character varying,
    dimensions character varying(255) DEFAULT NULL::character varying,
    note character varying(2048) DEFAULT NULL::character varying,
    last_edited timestamp(0) without time zone NOT NULL,
    max_cpu integer
);



--
-- Name: motherboard_alias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_alias (
    id integer NOT NULL,
    motherboard_id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) NOT NULL
);



--
-- Name: motherboard_alias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motherboard_alias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard_bios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_bios (
    id integer NOT NULL,
    motherboard_id integer NOT NULL,
    manufacturer_id integer,
    file_name character varying(255) DEFAULT NULL::character varying,
    post_string character varying(255) DEFAULT NULL::character varying,
    board_version character varying(255) DEFAULT NULL::character varying,
    updated_at timestamp(0) without time zone NOT NULL,
    core_version character varying(255) DEFAULT NULL::character varying,
    note character varying(255) DEFAULT NULL::character varying
);



--
-- Name: motherboard_bios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motherboard_bios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard_cache_size; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_cache_size (
    motherboard_id integer NOT NULL,
    cache_size_id integer NOT NULL
);



--
-- Name: motherboard_coprocessor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_coprocessor (
    motherboard_id integer NOT NULL,
    coprocessor_id integer NOT NULL
);



--
-- Name: motherboard_cpu_socket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_cpu_socket (
    motherboard_id integer NOT NULL,
    cpu_socket_id integer NOT NULL
);



--
-- Name: motherboard_cpu_speed; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_cpu_speed (
    motherboard_id integer NOT NULL,
    cpu_speed_id integer NOT NULL
);



--
-- Name: motherboard_dram_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_dram_type (
    motherboard_id integer NOT NULL,
    dram_type_id integer NOT NULL
);



--
-- Name: motherboard_expansion_slot; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_expansion_slot (
    motherboard_id integer NOT NULL,
    expansion_slot_id integer NOT NULL,
    count integer NOT NULL
);



--
-- Name: motherboard_id_redirection; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_id_redirection (
    id integer NOT NULL,
    destination_id integer NOT NULL
);



--
-- Name: motherboard_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motherboard_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard_image; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_image (
    id integer NOT NULL,
    motherboard_image_type_id integer NOT NULL,
    motherboard_id integer NOT NULL,
    creditor_id integer,
    license_id integer NOT NULL,
    file_name character varying(255) NOT NULL,
    description character varying(255) DEFAULT NULL::character varying,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: motherboard_image_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motherboard_image_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard_image_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_image_type (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: motherboard_image_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motherboard_image_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: motherboard_io_port; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_io_port (
    motherboard_id integer NOT NULL,
    io_port_id integer NOT NULL,
    count integer NOT NULL
);



--
-- Name: motherboard_known_issue; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_known_issue (
    motherboard_id integer NOT NULL,
    known_issue_id integer NOT NULL
);



--
-- Name: motherboard_max_ram; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_max_ram (
    motherboard_id integer NOT NULL,
    max_ram_id integer NOT NULL,
    note character varying(255) DEFAULT NULL::character varying
);



--
-- Name: motherboard_processor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_processor (
    motherboard_id integer NOT NULL,
    processor_id integer NOT NULL
);



--
-- Name: motherboard_processor_platform_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_processor_platform_type (
    motherboard_id integer NOT NULL,
    processor_platform_type_id integer NOT NULL
);



--
-- Name: motherboard_psuconnector; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motherboard_psuconnector (
    psuconnector_id integer NOT NULL,
    motherboard_id integer NOT NULL
);



--
-- Name: os_family; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.os_family (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    file_name character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);



--
-- Name: os_family_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.os_family_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: os_flag; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.os_flag (
    id integer NOT NULL,
    manufacturer_id integer,
    name character varying(255) NOT NULL,
    major_version character varying(255) NOT NULL,
    minor_version character varying(255) DEFAULT NULL::character varying
);



--
-- Name: os_flag_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.os_flag_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: os_flag_os_family; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.os_flag_os_family (
    os_flag_id integer NOT NULL,
    os_family_id integer NOT NULL
);



--
-- Name: processing_unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processing_unit (
    id integer NOT NULL,
    speed_id integer,
    platform_id integer,
    fsb_id integer
);



--
-- Name: processing_unit_cpu_socket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processing_unit_cpu_socket (
    processing_unit_id integer NOT NULL,
    cpu_socket_id integer NOT NULL
);



--
-- Name: processing_unit_instruction_set; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processing_unit_instruction_set (
    processing_unit_id integer NOT NULL,
    instruction_set_id integer NOT NULL
);



--
-- Name: processor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processor (
    id integer NOT NULL,
    l1_id integer,
    l2_id integer,
    l3_id integer,
    l1_cache_method_id integer,
    l2_cache_ratio_id integer,
    l3_cache_ratio_id integer,
    core character varying(255) DEFAULT NULL::character varying,
    tdp integer,
    process_node integer
);



--
-- Name: processor_platform_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processor_platform_type (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: processor_platform_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.processor_platform_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: processor_platform_type_processor_platform_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processor_platform_type_processor_platform_type (
    processor_platform_type_source integer NOT NULL,
    processor_platform_type_target integer NOT NULL
);



--
-- Name: processor_voltage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.processor_voltage (
    id integer NOT NULL,
    processor_id integer NOT NULL,
    value double precision NOT NULL
);



--
-- Name: processor_voltage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.processor_voltage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: psuconnector; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.psuconnector (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);



--
-- Name: psuconnector_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.psuconnector_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    username character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL
);



--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Name: video_chipset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.video_chipset (
    id integer NOT NULL,
    manufacturer_id integer NOT NULL,
    name character varying(255) DEFAULT NULL::character varying,
    chip_name character varying(255) DEFAULT NULL::character varying
);



--
-- Name: video_chipset_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.video_chipset_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;



--
-- Data for Name: audio_chipset; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.audio_chipset (id, manufacturer_id, name, chip_name) FROM stdin;
1	453	Solo-1	ES1938S
5	453	AudioDrive	ES1868F
11	455	AudioPCI	ES1373
12	455	AudioPCI	ES1371
13	455	AudioPCI	CT5880
22	455	AudioPCI 64V	EV1938
24	473	SoundMAX AC97	AD1881
25	473	SoundMAX AC97	AD1885
26	473	SoundMAX AC97	AD1888
27	473	SoundMAX AC97	AD1981B
28	473	SoundMAX AC97	AD1981A
29	473	SoundMAX AC97	AD1985
30	473	SoundMAX AC97	AD1986
31	473	SoundMAX AC97	AD1986A
32	454	AC97	ALC100
33	454	AC97	ALC100P
34	454	AC97	ALC101
35	454	AC97	ALC200
36	454	AC97	ALC201
37	454	AC97	ALC201A
38	454	AC97	ALC202
39	454	AC97	ALC202A
40	454	AC97	ALC203
41	454	AC97	ALC650
42	454	AC97	ALC653
43	454	AC97	ALC655
44	454	AC97	ALC658
45	454	AC97	ALC850
46	455	AudioPCI 128V	ES1373D
47	475	Vortex	AU8808
48	475	Vortex	AU8820
49	475	Vortex Advantage	AU8810
50	475	Vortex 2	AU8830
54	417	AC97	VT1612A
56	462	AC97	YMF752-S
14	462	OPL3-SA	YMF701
18	462	DS-1L	YMF740C
15	462	OPL3-SA2	YMF711
3	462	OPL3-SA3	YMF715
16	462	OPL3-SA3	YMF718
17	462	OPL3-SA3	YMF719
23	462	DS-1	YMF724
57	470	AC97	CMI9738/9739A
51	470	AC97	CMI9761/9761A
58	303	OPTi930	82C930A
60	417	AC97	VT1611A
61	74	AC’97 Audio CODEC	ALC100P
62	484	AC97 VSR	ICE1232
63	417	AC97	VT1613
64	417	AC97	VT1616
65	417	AC97	VT1616B
66	417	AC97	VT1617
67	417	AC97	VT1617A
68	417	AC97	VT1618
69	473	SoundMAX AC97	AD1881A
72	453	AudioDrive	ES1869F
73	453	AudioDrive	ES688F
74	453	Maestro-1	ES1948F
75	453	Maestro-2	ES1968S
76	473	SoundPort AC97	AD1819B
110	379	\N	960
111	453	Allegro	ESS1989
8	311	Sound Pro / HT1869V+	CMI8330 oem
78	311	PCI Sound Pro / HT 8338	CMI8338 oem
77	311	3D PCI Sound Pro / HT 8738	CMI8738 oem
79	453	AudioDrive	ES1788
80	473	SoundMAX AC97	AD1980
82	121	XpressAUDIO	\N
83	470	CMI9738	CMI9738
86	454	High Definition Audio	ALC861
87	470	High Definition Audio	CM6501
88	454	High Definition Audio	ALC888
89	74	AC97 CODEC	ALC201A
90	454	High Definition Audio	ALC660
91	454	High Definition Audio	ALC662
92	454	High Definition Audio	ALC883
52	470	CMI8738/PCI	CMI8738
93	405	4DWAVE-DX	4DWAVE-DX
94	453	AudioDrive	ES1888F
7	455	Vibra 16C	CT2505
95	455	Vibra 16CL	CT2508
20	455	Vibra 16S	CT2504
59	455	Vibra 16XV	CT2511
96	455	Vibra 16X	CT2510
97	456	CS4280	CS4280-CM
98	197	Mwave	DSP2780
99	454	AC97	ALC665
100	558	\N	FM801
101	558	\N	FM801A
102	74	AC’97 Audio CODEC	ALS-120
103	74	\N	ALS300
104	454	High Definition Audio	ALC880
105	454	High Definition Audio	ALC882
112	470	C3D	CMI8330
84	379	\N	7012
85	379	\N	7018
55	476	AC97	STAC97xx
106	454	High Definition Audio	ALC260
107	454	High Definition Audio	ALC888S
108	453	AudioDrive	ESS1898
109	74	\N	ALS4000
113	610	\N	AZT2320 (R2)
114	456	CS4277	CS4277-JQ
115	455	SB Live!	EMU10K1
116	100	Business Audio	\N
117	100	Enhanced Business Audio	\N
118	454	High Definition Audio	ALC221
119	454	High Definition Audio	ALC231
120	454	High Definition Audio	ALC233
121	454	High Definition Audio	ALC235
122	454	High Definition Audio	ALC236
123	454	High Definition Audio	ALC255
124	454	High Definition Audio	ALC256
125	454	High Definition Audio	ALC262
126	454	High Definition Audio	ALC267
127	454	High Definition Audio	ALC268
128	454	High Definition Audio	ALC269
129	454	High Definition Audio	ALC270
130	454	High Definition Audio	ALC272
131	454	High Definition Audio	ALC273
132	454	High Definition Audio	ALC275
133	454	High Definition Audio	ALC276
134	454	High Definition Audio	ALC280
135	454	High Definition Audio	ALC282
136	454	High Definition Audio	ALC283
137	454	High Definition Audio	ALC284
138	454	High Definition Audio	ALC286
139	454	High Definition Audio	ALC288
4	456	CS4232	CS4232-KQ
2	456	CS4235	CX4235-XQ3
19	456	CS4236B	CS4236B-KQ
70	456	CS4237B	CX4237B-XQ3
71	456	CS4237	CS4237
81	456	CS4238	CS4238-KQ
21	456	CS4297	4297A-JQ EP
53	456	CS4299	4299-JQ
9	456	CS4611 PCI	CS4611-CM
140	454	High Definition Audio	ALC290
141	454	High Definition Audio	ALC292
142	454	High Definition Audio	ALC293
143	454	High Definition Audio	ALC298
144	454	High Definition Audio	ALC383
145	454	High Definition Audio	ALC663
146	454	High Definition Audio	ALC665
147	454	High Definition Audio	ALC667
148	454	High Definition Audio	ALC668
149	454	High Definition Audio	ALC670
150	454	High Definition Audio	ALC671
151	454	High Definition Audio	ALC672
152	454	High Definition Audio	ALC676
153	454	High Definition Audio	ALC680
154	454	High Definition Audio	ALC861VC
155	454	High Definition Audio	ALC861VD
156	454	High Definition Audio	ALC880D
157	454	High Definition Audio	ALC882D
158	454	High Definition Audio	ALC882H
159	454	High Definition Audio	ALC882M
160	454	High Definition Audio	ALC885
161	454	High Definition Audio	ALC886
162	454	High Definition Audio	ALC887
163	454	High Definition Audio	ALC888SDD
164	454	High Definition Audio	ALC888T
165	454	High Definition Audio	ALC889
166	454	High Definition Audio	ALC889A
167	454	High Definition Audio	ALC889DD
168	454	High Definition Audio	ALC889X
169	454	High Definition Audio	ALC891
170	454	High Definition Audio	ALC892
171	454	High Definition Audio	ALC898
172	454	High Definition Audio	ALC899
173	454	High Definition Audio	ALC900
174	454	High Definition Audio	ALC1150
175	454	High Definition Audio	ALC1200
176	454	High Definition Audio	ALC3683
177	473	SoundMAX HDA	AD1882A
178	473	SoundMAX HDA	AD1988A
179	473	SoundMAX HDA	AD2000B
180	473	SoundMAX HDA	AD1884
181	473	SoundMAX HDA	AD1883
182	473	SoundMAX HDA	AD1882
183	473	SoundMAX HDA	AD1987
184	473	SoundMAX HDA	AD1986A
185	473	SoundMAX HDA	AD1984
186	473	SoundMAX HDA	AD1988
187	473	SoundMAX HDA	AD1988B
188	470	High Definition Audio	CMI9880
189	417	High Definition Audio	VT1705
190	417	High Definition Audio	VT1708S
191	417	High Definition Audio	VT1819S
192	417	High Definition Audio	VT1708
193	417	High Definition Audio	VT1702S
194	417	High Definition Audio	VT1705CE
195	417	High Definition Audio	VT1708B
196	417	High Definition Audio	VT1718S
197	417	High Definition Audio	VT1802P
198	417	High Definition Audio	VT1812S
199	417	High Definition Audio	VT1818S
200	417	High Definition Audio	VT1828S
201	417	High Definition Audio	VT2021
202	476	High Definition Audio	STAC92xx
203	417	Unidentified	\N
204	473	Unidentified	\N
205	454	Unidentified	\N
206	470	Unidentified	\N
6	456	CS9236	CS9236
10	456	CS4236	CS4236B-KQ
207	456	CS4614 PCI	CS4614-CM
208	456	CS4624 PCI	CS4624-CQ
209	456	CS4630 PCI	CS4630-CM
210	456	CS4610 PCI	CS4610-CM
211	456	CS4610C PCI	CS4610C-CQ
212	456	CS4622 PCI	CS4622-CQ
\.


--
-- Data for Name: cache_method; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_method (id, name) FROM stdin;
1	Write-Through
2	Write-Back
\.


--
-- Data for Name: cache_ratio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_ratio (id, name) FROM stdin;
1	1/1
2	1/2
3	1/3
4	2/3
5	2/5
\.


--
-- Data for Name: cache_size; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_size (id, value) FROM stdin;
1	0
2	2048
3	4096
4	8192
5	16384
6	32768
7	65536
8	131072
9	262144
10	524288
11	786432
12	1048576
13	2097152
14	4194304
15	8388608
16	16777216
17	33554432
18	1024
19	12288
20	3145728
21	6291456
22	12582912
23	24576
24	98304
25	49152
26	196608
27	393216
28	512
29	256
30	768
31	128
\.


--
-- Data for Name: chip; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chip (id, manufacturer_id, name, part_number, dtype) FROM stdin;
774	121		Cx486DX (WB)	processor
832	289	V20	D70108C-5	processor
833	289	V30	D70116C-5	processor
759	27	Am486 DX4-120	A80486DX4-120SV8B	processor
818	118	Super 386	J38600DX-25	processor
733	207	8086	D8086	processor
806	27	K6 166	AMD-K6-166ALR	processor
755	27	Am486 DX4-100	A80486DX4-100NV8T	processor
807	27	K6-2 200	AMD-K6-2/200AFR	processor
757	27	Am486 DX4-100	S80486DX4-100SV8B	processor
761	27	Am486 DX4-100	Am486DX4-100V16BGI	processor
766	27	Am5x86-P75	AMD-X5-133ADW	processor
740	27	Am486 DX2-80	A80486DX2-80V8T	processor
739	27	Am486 DX2-80	A80486DX2-80SV8B	processor
747	27	Am486 DX2-80	A80486DX2-80	processor
735	27	Am486 DX-40	A80486DX-40	processor
756	27	Am486 DX4-75	A80486DX4-75SV8B	processor
754	27	Am486 DX4-90	A80486DX4-90NV8T	processor
737	27	Am486 DX2-66	Am486DX2-66V16BGC	processor
801	197		6x86	processor
775	121	Cx486 DX2-66	Cx486DX2-66GP	processor
778	121	Cx486 S33 FasCache	Cx486S-33-GP	processor
780	121	Cx486 DX-50	Cx486DX-50GP	processor
787	121	5x86-120	5x86-120GP	processor
773	121	Cx486 DX-33	Cx486DX-33GP	processor
786	121	Cx486 DX-40	Cx486DX-40GP	processor
836	445	Z-80	Z0840004PSC	processor
712	273	68060	MC68060RC50	processor
798	197	486SLC2-50	50G6950	processor
791	121	6x86MX PR150	6x86MX-PR150	processor
710	273	68030	MC68030RC16	processor
817	273	\N	PowerPC 604	processor
815	273	\N	PowerPC 603	processor
816	273	\N	PowerPC 603e	processor
811	207	Pentium MMX 166	A80503166	processor
824	393	486SXLC-25	SXLC-25	processor
826	393	486SXLC2-50	TI486SXLC2-050	processor
825	393	486SXLC2-40	TI486SXLC2-040	processor
711	273	68040	MC68040RC40	processor
835	199	WinChip 2 200	W2-3DEE200GSA	processor
794	197	486DLC2-66	50G3589	processor
789	121	6x86 80	6x86-80GP	processor
790	121	6x86MX PR233	6x86MX-PR233	processor
772	121	486DRx²16/32	Cx486DRx²16/32GP	processor
714	207	80286	C80286-4	processor
819	393	486DLC/E-40	TX486DLC/E-40PCE	processor
719	207	80386SX-16	NG80386SX-16	processor
717	207	RapidCAD-1	RapidCAD-1	processor
823	121	486SLC-25	Cx486SLC-25MP	processor
788	121	5x86-100	5x86-100GP	processor
758	207	i486 SL 33	KU80486SL-33	processor
800	121	Cx486 DX4 100	Cx486DX4-75GP	processor
797	121	Cx486 DX2-v66 (WB)	Cx486DX2-66GP	processor
753	207	i486 SL 25	KU80486SL-25	processor
731	207	i486 SX2 50	A80486SX2-50	processor
721	207	i486 DX 25	A80486DX-25	processor
730	207	i486 SX 16	A80486SX-16	processor
828	408	U5S-SUPER33	U5S-SUPER33	processor
829	408	U5SD-SUPER33	U5SD-SUPER33	processor
831	408	U5SX 486-33	U5SX 486-33	processor
777	121	Cx486 DX4 100	Cx486DX4-100GP	processor
827	408	U5S-SUPER40	U5S-SUPER40	processor
830	408	U5S-SUPER25	U5S-SUPER25	processor
779	121	Cx486 S25 FasCache	Cx486S-25GP	processor
776	121	Cx486 DX2-66 (WB)	Cx486DX2-66	processor
785	121	Remove	Cx486SX2	processor
727	207	i486 SL 20	KU80486SL-20	processor
822	207	Pentium OverDrive 63	PODP5V63	processor
821	207	OverDrive 486SX2-40 (PGA168)	ODP486SX-20	processor
734	207	8088	D8088	processor
799	121	Cx486 DX2-v80	Cx486DX2-V80GP	processor
781	207	OverDrive 486SX2-50 (PGA169)	ODP486SX-25	processor
732	207	OverDrive 486DX2-66 (PGA168)	ODPR486DX-33	processor
725	207	OverDrive 486DX4-75 (PGA169)	DX4ODP75	processor
728	207	OverDrive 486DX4-75 (PGA168)	DX4ODPR75	processor
709	207	OverDrive 486DX2-50 (PGA168)	ODPR486DX-25	processor
796	207	OverDrive 486DX4-100 (PGA168)	DX4ODPR100	processor
938	417		C3 (Samuel 2)	processor
939	417		C3 (Erza)	processor
940	417		C3 (Nehemiah)	processor
941	417		C7 (Esther)	processor
863	207	Celeron 266	BX80523R266000	processor
877	207	Celeron 1.5	RK80531RC021128	processor
878	207	Celeron 1.6	RK80532RC025128	processor
958	207	Pentium 4 HT 2.6C	RK80532PG064512	processor
864	207	Celeron 300A	BX80524P300128	processor
934	207	Pentium III Xeon 500	80525KY500512	processor
866	207	Pentium III 500E	80526PY500256	processor
936	207	Pentium III Xeon 600 (5/12V)	80526KZ600256 5/12V	processor
867	207	Pentium III 1000	RK80530PZ001256	processor
872	207	Pentium 4 1.5	RK80531PC021G0K	processor
865	207	Celeron 533A	RB80526RX533128	processor
933	207	Pentium II Xeon 400	80523KX400512	processor
887	207	Pentium D 915	HH80553PG0724MN	processor
862	207	Pentium III 500E	RB80526PY500256	processor
871	207	Pentium 4 1.3	80528PC013G0K	processor
879	207	Celeron D 310	RK80546RE046256	processor
873	207	Pentium 4 1.7A	RK80532PC029512	processor
926	207	Core 2 Extreme X6800	HH80557PH0774M	processor
880	207	Celeron D 320J	B80547RE056256	processor
769	138	Alpha AXP 21064	21-35023-13	processor
889	207	Core 2 Duo E8200	EU80570PJ0676M	processor
888	207	Core 2 Duo E6300	HH80557PH0362M	processor
886	207	Pentium D 805	HH80551PE0672MN	processor
925	207	Pentium Extreme Edition 955	HH80553PH0994M	processor
928	207	Core 2 Extreme QX9650	EU80569XJ080NL	processor
890	207	Pentium Dual-Core E5200	EU80571PG0602M	processor
924	207	Pentium Extreme Edition 840	HH80551PG0882MM	processor
884	207	Celeron M 310	RJ80535NC009512	processor
885	207	Celeron M 350	RH80536NC0131M	processor
961	207	Pentium M 710	RH80536GC0172MT	processor
918	27	Mobile K6-2+ 450	AMD-K6-2+/450ACZ	processor
810	207	Pentium II 233 (256K)	80522PX233256	processor
946	27	Mobile Athlon 4 850	AHM0850AVS3B	processor
894	27	Athlon 500	AMD-K7500MTR51B C	processor
898	27	Athlon XP 1600+	AXDA1600DUT3C	processor
899	27	Athlon XP 2500+	AXDA2500DKV4D	processor
895	27	Athlon 650	AMD-A0650MPR24B A	processor
913	27	Duron 1400	DHD1400DLV1C	processor
943	27	Athlon MP 2000+	AMSN2000DUT3C	processor
949	27	Athlon XP-M 950	AXML0950GTS3B	processor
950	27	Athlon XP-M 2200+	AXMH2200FQQ4C	processor
948	27	Athlon XP-M 1600+	AXMH1600FHQ3C	processor
896	27	Athlon 600	A0600AMT3B	processor
900	27	Athlon 64 2800+	ADA2800AEP4AP	processor
901	27	Athlon 64 3500+	ADA3500DEP4AS	processor
902	27	Athlon 64 3000+	ADA3000IAA4CN	processor
944	27	Athlon MP 2600+	AMSN2600DUT4C	processor
942	27	Athlon MP 1000	AHX1000AMS3C	processor
945	27	Mobile Duron 600	DM600AVS1B	processor
905	27	Athlon 64 X2 3800+	ADA3800DAA5CD	processor
915	27	Sempron 3000+	SDA3000AIP2AX	processor
947	27	Mobile Duron 800	DHM0800ALS1B	processor
908	27	Opteron 140	OSA140CCO5AG	processor
912	27	Duron 900	DHD900AMT1B	processor
903	27	Athlon 64 FX-55	ADAFX55DAA5BN	processor
914	27	Sempron 2200+	SDA2200DUT3D	processor
917	27	Sempron 2800+	SDA2800IAA2CN	processor
909	27	Opteron 1210	OSA1210IAA6CS	processor
954	27	Turion 64 ML-28	TMDML28BKX4LD	processor
911	27	Duron 600	D600AUT1B	processor
919	27	K6-III+ 450	AMD-K6-III+/450APZ	processor
893	207	Core 2 Quad Q9450	EU80569PJ067N	processor
882	207	Celeron 420	HH80557RG025512	processor
883	207	Celeron Dual-Core E3200	AT80571RG0561ML	processor
923	207	Pentium 4 Extreme Edition 3.46	JM80532PH0992M	processor
921	207	Pentium 4 Extreme Edition 3.73	JM80547PH1092MM	processor
874	207	Pentium 4 2.4A	B80546PE0561M	processor
959	207	Pentium 4 HT 2.8E	RK80546PG0721M	processor
834	199	WinChip C6 180	C6-PSME180GA	processor
875	207	Pentium 4 520	JM80547PG0721M	processor
809	207	Pentium 75	A80502-75	processor
989	207	80386SX-20	NG80386SX-20	processor
876	207	Pentium 4 631 (05A)	HH80552PG0802M	processor
881	207	Celeron D 347 (06)	HH80552RE083512	processor
892	207	Core 2 Quad Q6600 (G0)	HH80562PH0568M	processor
963	504	ZFx86	ZFx86BGA388	processor
808	292	Nx586 P75	Nx586-P75	processor
929	417	Cyrix III 500	Cyrix III-500MHz	processor
930	417	C3 600A	C3-600AMHz	processor
931	417	C3 733A	C3-733AMHz	processor
932	417	C3 866A	C3-866AMHz	processor
792	121	MII 200	MII-200GP	processor
771	121	486DLC-33	Cx486DLC-33GP	processor
783	121	486SLC2-50	Cx486SLC2-50MP	processor
869	207	Pentium MMX OverDrive 150	PODPMT60X150	processor
813	207	Pentium OverDrive 125	PODP3V125	processor
861	207	Pentium Overdrive 120	PODP5V120	processor
998	207	Pentium Pro 180/256K	KB80521EX180 256K	processor
984	207	i486 DX2 66	A80486DX2-66	processor
812	207	Pentium OverDrive 83	PODP5V83	processor
962	121	Cx486 DX2-v66	Cx486DX2-V66GP	processor
916	27	Sempron 3200+ (w/ AMD64)	SDA3200DIO3BW	processor
960	207	Pentium M 1.3	RH80535GC0091M	processor
907	27	Opteron 144	OSA144DAA5BN	processor
1009	118	Super 386	J38600DX-40	processor
1301	27	Mobile K6-2 333	AMD-K6-2/333ANZ	processor
951	27	Athlon XP-M 1800+	AXMD1800GJQ4C	processor
953	27	Mobile Athlon 64 2700+	AMA2700BEY4AP	processor
1035	27	Duron 850	D850AUT1B	processor
1039	27	Duron 1000	DHD1000AMT1B	processor
1043	27	Duron 1600	DHD1600DLV1C	processor
1047	27	Mobile Duron 900	DHM0900AQS1B	processor
1051	27	Mobile Duron 1200	DHM1200AQQ1B	processor
1055	27	Athlon 650	AMD-K7650MTR51B C	processor
1059	27	Athlon 650	AMD-K7650MTR51B A	processor
1063	27	Athlon 850	AMD-K7850MPR52B A	processor
1067	27	Athlon 700	AMD-A0700MPR24B A	processor
1071	27	Athlon 900	AMD-A0900MMR24B A	processor
1075	27	Athlon 700	A0700AMT3B	processor
1079	27	Athlon 900	A0900AMT3B	processor
1083	27	Athlon 1100	A1100AMS3B	processor
1087	27	Athlon 1266	A1266AMS3C	processor
1091	27	Athlon 1400C	A1400AMS3C	processor
1095	27	Athlon XP 1900+	AX1900DMT3C	processor
1099	27	Athlon SFF 1100	AHL1100AUT3B	processor
1103	27	Athlon XP 1700+	AXDA1700DLT3C	processor
1107	27	Athlon XP 1900+	AXDA1900DUT3C	processor
1111	27	Athlon XP 2200+	AXDA2200DKV3C	processor
1115	27	Athlon XP 2600+	AXDA2600DKV3C	processor
1119	27	Athlon XP 3100+	AXDC3100DKV3E	processor
956	121	MediaGXm 200	GXm-200GP 2.9V	processor
955	121	MediaGXm 180	GXm-180GP 2.9V	processor
1123	27	Athlon XP SFF 1800+	AXLD1800DVT3C	processor
1127	27	Athlon XP 2000+	AXDC2000DUT3C	processor
1131	27	Athlon XP 2600+	AXDC2600DKV3C	processor
1135	27	Athlon XP 2500+	AXDA2500DKV4E	processor
1139	27	Athlon XP 2800+	AXDA2800DKV4D	processor
1143	27	Athlon XP 3000+	AXDA3000DKV4D	processor
2474	303	\N	82C495SLC	chipsetpart
1147	27	Low-power Athlon XP 2600+	AXDL2600DLV4D	processor
1151	27	Athlon MP 1200	AHX1200ANS3B	processor
1155	27	Athlon MP 1800+	AMP1800DMS3C	processor
1159	27	Athlon MP 1200	AHX1200DHS3C	processor
1163	27	Athlon MP 2600+	AMSN2600DKT3C	processor
1167	27	Mobile Athlon 4 1000	AHM1000AVS3B	processor
1171	27	Mobile Athlon 4 1200	AHM1200AHQ3B	processor
1175	27	Mobile Athlon XP 1400+	AXMD1400FQQ3C	processor
1179	27	Mobile Athlon XP 1600+	AXMD1600FVQ3B	processor
1183	27	Mobile Athlon XP 1800+	AXMD1800FVQ3C	processor
1187	27	Mobile Athlon XP 1500+	AXMD1500FWS3B	processor
1191	27	Mobile Athlon XP 1600+	AXMD1600FXS3C	processor
1195	27	Athlon XP-M 1700+	AXMH1700FHQ3C	processor
1199	27	Athlon XP-M 2000+	AXMH2000FLQ3C	processor
1203	27	Athlon XP-M 2200+	AXMA2200FUT3C	processor
1207	27	Athlon XP-M 1600+	AXMD1600FJQ3C	processor
1211	27	Athlon XP-M 1900+	AXMD1900FJQ3C	processor
1215	27	Athlon XP-M 1200+	AXML1200GTS3B	processor
1219	27	Athlon XP-M 1900+	AXMD1900GJQ3C	processor
1223	27	Athlon XP-M 2400+	AXMH2400FQQ4C	processor
1226	27	Athlon XP-M 2800+	AXMJ2800FHQ4C	processor
1230	27	Athlon XP-M 2800+	AXMA2800FKT4C	processor
1234	27	Athlon XP-M 2500+	AXMF2500FVQ4C	processor
1238	27	Athlon XP-M 2100+	AXMS2100GXS4B	processor
1242	27	Athlon XP-M 2200+	AXMT2200GWS4C	processor
1246	27	Geode NX 2000	ANXD2000FVC3F	processor
1250	27	Sempron 2500+	SDA2500DUT3D	processor
1254	27	Sempron 2400+	SDC2400DUT3D	processor
1305	27	Mobile K6-2 380	AMD-K6-2/380AFK	processor
1258	27	K5 PR100	AMD-K5-PR100ABQ	processor
1261	27	K5 PR133	AMD-K5-PR133ABQ	processor
1265	27	K6 200	AMD-K6-200ALR	processor
1269	27	K6 300	AMD-K6/300AFR	processor
1273	27	Mobile K6 266	AMD-K6/266ADZ	processor
1277	27	K6-2 300	AMD-K6-2/300AFR	processor
1281	27	K6-2 350	AMD-K6-2/350AFR	processor
1285	27	K6-2 400	AMD-K6-2/400AFR	processor
1289	27	K6-2 450	AMD-K6-2/450AGX	processor
1293	27	K6-2 500	AMD-K6-2/500AFX	processor
1297	27	K6-2 550	AMD-K6-2/550AGR	processor
1309	27	Mobile K6-2 400	AMD-K6-2/400ACK	processor
1313	27	Mobile K6-2 500	AMD-K6-2/500ADK	processor
1317	27	K6-2E 266	AMD-K6-2/266AMZ	processor
1321	27	K6-2E 300	AMD-K6-2/300AMZ	processor
1325	27	K6-2E 333	AMD-K6-2/333AMZ	processor
1328	27	K6-2E 400	AMD-K6-2/400AFR	processor
1333	27	Mobile K6-2+ 450	AMD-K6-2+/450ADZM	processor
1335	27	Mobile K6-2+ 500	AMD-K6-2+/500ACZ	processor
1337	27	Mobile K6-2+ 550	AMD-K6-2+/550ACZ	processor
1339	27	K6-2+ 350	AMD-K6-2+/350AUZ	processor
1341	27	K6-2+ 400	AMD-K6-2+/400ACR	processor
1343	27	K6-2+ 400	AMD-K6-2+/400ATZ	processor
1345	27	K6-2+ 450	AMD-K6-2+/450APZ	processor
1030	27	K6-III 333	AMD-K6-III/333AFR	processor
1347	27	K6-III 400	AMD-K6-III/400AHX	processor
1349	27	K6-III 400	AMD-K6-III/400AFR	processor
1351	27	K6-III 450	AMD-K6-III/450AHX	processor
1314	27	K6-2E 233	AMD-K6-2/233AFR	processor
891	207	Pentium Dual-Core E2140	HH80557PG0251M	processor
985	207	80286	C80286-6	processor
990	207	80386SX-25	NG80386SX-25	processor
1023	207	Pentium 120	A80502-120	processor
1029	207	Pentium MMX 233	BP80503233	processor
1028	207	Pentium MMX 200	A80503200	processor
726	207	i486 DX4 100	80486DX4-100	processor
1019	207	i486 DX4 75	A80486DX4-75	processor
1013	207	i486 DX2 50 (WB)	A80486DX2-50	processor
724	207	i486 DX2 66	A80486DX2-66	processor
1018	207	i486 SX 33	A80486SX-33	processor
957	27	Geode NX 1250	ANXL1250FYC3F	processor
1031	27	Duron 650	D650AUT1B	processor
1036	27	Duron 900	D900AUT1B	processor
1040	27	Duron 1100	DHD1100AMT1B	processor
1044	27	Duron 1800	DHD1800DLV1C	processor
1048	27	Mobile Duron 950	DHM0950AQS1B	processor
1052	27	Mobile Duron 1300	DHM1300ALQ1B	processor
1056	27	Athlon 700	AMD-K7700MTR51B C	processor
1060	27	Athlon 700	AMD-K7700MTR51B A	processor
1064	27	Athlon 900	AMD-K7900MNR53B A	processor
1068	27	Athlon 750	AMD-A0750MPR24B A	processor
1072	27	Athlon 950	AMD-A0950MMR24B A	processor
1076	27	Athlon 750	A0750AMT3B	processor
1080	27	Athlon 950	A0950AMT3B	processor
1084	27	Athlon 1133	A1133AMS3C	processor
1088	27	Athlon 1300	A1300AMS3B	processor
1092	27	Athlon XP 1600+	AX1600DMT3C	processor
1096	27	Athlon XP 2000+	AX2000DMT3C	processor
1100	27	Athlon SFF 1200	AHL1200AHT3B	processor
1104	27	Athlon XP 1800+	AXDA1800DLT3C	processor
1108	27	Athlon XP 2000+	AXDA2000DUT3C	processor
1112	27	Athlon XP 2200+	AXDA2200DUV3C	processor
1116	27	Athlon XP 2600+	AXDA2600DKV3D	processor
1120	27	Athlon XP SFF 1500+	AXLD1500DQT3C	processor
1124	27	Low-power Athlon XP 2200+	AXDL2200DUV3C	processor
1128	27	Athlon XP 2200+	AXDC2200DLV3C	processor
1132	27	Athlon XP 2600+	AXDC2600DKV3D	processor
1136	27	Athlon XP 2600+	AXDA2600DKV4D	processor
1140	27	Athlon XP 2800+	AXDA2800DKV4C	processor
1144	27	Athlon XP 3200+	AXDA3200DKV4E	processor
1148	27	Low-power Athlon XP 2800+	AXDL2800DKV4D	processor
1152	27	Athlon MP 1200	AHX1200AMS3C	processor
1156	27	Athlon MP 1900+	AMP1900DMS3C	processor
1160	27	Athlon MP 2000+	AMSN2000DKT3C	processor
1164	27	Athlon MP 2800+	AMSN2800DUT4C	processor
1168	27	Mobile Athlon 4 1100	AHM1100AVS3B	processor
1172	27	Mobile Athlon 4 1500+	AHM1500ALQ3B	processor
1176	27	Mobile Athlon XP 1500+	AXMD1500FQQ3B	processor
1180	27	Mobile Athlon XP 1600+	AXMD1600FQQ3C	processor
1184	27	Mobile Athlon XP 1900+	AXMD1900FVQ3B	processor
1188	27	Mobile Athlon XP 1500+	AXMD1500FWS3C	processor
1192	27	Mobile Athlon XP 1700+	AXMD1700FXS3C	processor
1196	27	Athlon XP-M 1800+	AXMH1800FHQ3C	processor
1200	27	Athlon XP-M 2000+	AXMH2000FQQ3C	processor
1204	27	Athlon XP-M 2400+	AXMA2400FKT3C	processor
1208	27	Athlon XP-M 1700+	AXMD1700FJQ3C	processor
1212	27	Athlon XP-M 2000+	AXMD2000FJQ3C	processor
1216	27	Athlon XP-M 1700+	AXMS1700GXS3C	processor
1227	27	Athlon XP-M 2400+	AXMA2400FUT4C	processor
1231	27	Athlon XP-M 3000+	AXMA3000FKT4C	processor
1235	27	Athlon XP-M 1900+	AXMS1900GXS4C	processor
1239	27	Athlon XP-M 2400+	AXMD2400GJQ4C	processor
1243	27	Athlon XP-M 2600+	AXMD2600GJQ4D	processor
1247	27	Geode NX 2001	ANXA2001FKC3D	processor
1251	27	Sempron 2600+	SDA2600DUT3D	processor
1255	27	Sempron 2800+	SDC2800DUT3D	processor
1318	27	K6-2E 300	AMD-K6-2/300AFR	processor
1259	27	K5 PR90	AMD-K5-PR90ABQ	processor
1262	27	K5 PR150	AMD-K5-PR150ABR	processor
1266	27	K6 233	AMD-K6-233ANR	processor
1270	27	Mobile K6 233	AMD-K6/233ACZ	processor
1274	27	K6-2 233	AMD-K6-2/233AFR	processor
1278	27	K6-2 300	AMD-K6-2/300AFR	processor
1282	27	K6-2 366	AMD-K6-2/366AFR	processor
1286	27	K6-2 400	AMD-K6-2/400AHX	processor
1290	27	K6-2 450	AMD-K6-2/450AHX	processor
1294	27	K6-2 500	AMD-K6-2/500AHX	processor
1298	27	Mobile K6-2 266	AMD-K6-2/266ANZ	processor
1302	27	Mobile K6-2 333	AMD-K6-2/333ANZ	processor
1306	27	Mobile K6-2 400	AMD-K6-2/400AFK	processor
1310	27	Mobile K6-2 433	AMD-K6-2/433ADK	processor
1322	27	K6-2E 333	AMD-K6-2/333AFR	processor
1326	27	K6-2E 350	AMD-K6-2/350AFR	processor
1329	27	K6-2E 400	AMD-K6-2/400AFR	processor
1334	27	Mobile K6-2+ 475	AMD-K6-2+/475ACZ	processor
1336	27	Mobile K6-2+ 533	AMD-K6-2+/533ACZ	processor
1338	27	Mobile K6-2+ 570	AMD-K6-2+/570ACZ	processor
1340	27	K6-2+ 400	AMD-K6-2+/400ACR	processor
1342	27	K6-2+ 400	AMD-K6-2+/400ATZ	processor
1344	27	K6-2+ 450	AMD-K6-2+/450ACR	processor
1346	27	K6-2+ 500	AMD-K6-2+/500ACR	processor
858	27	K6-III 333	AMD-K6-III/333AFR	processor
1348	27	K6-III 400	AMD-K6-III/400AHX	processor
1350	27	K6-III 400	AMD-K6-III/400AFR	processor
1352	27	K6-III 450	AMD-K6-III/450AFX	processor
1353	27	Mobile K6-III 333	AMD-K6-III/333AFK	processor
1354	27	Mobile K6-III 333	AMD-K6-III/333AFK	processor
860	207	Pentium 66	A80501-66	processor
976	121	FasMath	CX-83D87-16-GP	coprocessor
967	207	387	A80387-16	coprocessor
968	207	i387SX	N80387SX-16	coprocessor
965	207	i287XL	C80287XL	coprocessor
977	121	FasMath	CX-83S87-16-JP	coprocessor
979	121	Cx87SLC	Cx87SLC-V25QP	coprocessor
972	121	387DX	387DX-33	coprocessor
978	121	Cx87DLC	Cx87DLC-40QP	coprocessor
952	27	Mobile K8 Athlon XP-M 2800+	AHN2800BIX2AY	processor
1267	27	K6 233	AMD-K6/233APR	processor
904	27	Athlon 64 FX-62	ADAFX62IAA6CS	processor
1032	27	Duron 700	D700AUT1B	processor
1037	27	Duron 950	D950AUT1B	processor
1041	27	Duron 1200	DHD1200AMT1B	processor
1045	27	Mobile Duron 700	DM700AVS1B	processor
1049	27	Mobile Duron 1000	DHM1000AVS1B	processor
1053	27	Athlon 550	AMD-K7550MTR51B C	processor
1057	27	Athlon 550	AMD-K7550MTR51B A	processor
1061	27	Athlon 750	AMD-K7750MTR52B A	processor
1065	27	Athlon 950	AMD-K7950MNR53B A	processor
1069	27	Athlon 800	AMD-A0800MPR24B A	processor
1073	27	Athlon 1000	AMD-A1000MMR24B A	processor
1077	27	Athlon 800	A0800AMT3B	processor
1081	27	Athlon 1000B	A1000AMS3B	processor
1085	27	Athlon 1200B	A1200AMS3B	processor
1089	27	Athlon 1333	A1333AMS3C	processor
1093	27	Athlon XP 1700+	AX1700DMT3C	processor
1097	27	Athlon XP 2100+	AX2100DMT3C	processor
1101	27	Athlon SFF 1500+	AXL1500DLT3B	processor
1105	27	Athlon XP 1700+	AXDA1700DUT3C	processor
1109	27	Athlon XP 2000+	AXDA2000DKT3C	processor
1113	27	Athlon XP 2400+	AXDA2400DUV3C	processor
1117	27	Athlon XP 2700+	AXDA2700DKV3D	processor
1121	27	Athlon XP SFF 1600+	AXLD1600DQT3C	processor
1125	27	Low-power Athlon XP 2400+	AXDL2400DUV3C	processor
1129	27	Athlon XP 2200+	AXDC2200DUV3C	processor
1133	27	Athlon XP 3100+	AXDC3100DKV3E	processor
1137	27	Athlon XP 2600+	AXDA2600DKV4C	processor
1141	27	Athlon XP 2900+	AXDA2900DKV4E	processor
1145	27	Athlon XP 3200+	AXDA3200DKV4D	processor
1149	27	Low-power Athlon XP 2800+	AXDL2800DLV4D	processor
1153	27	Athlon MP 1500+	AMP1500DMS3C	processor
1157	27	Athlon MP 2000+	AMP2000DMS3C	processor
1161	27	Athlon MP 2200+	AMSN2200DKT3C	processor
1165	27	Mobile Athlon 4 900	AHM0900AVS3B	processor
1169	27	Mobile Athlon 4 1000	AHM1000AUQ3B	processor
1173	27	Mobile Athlon 4 1600+	AHM1600AQQ3B	processor
1177	27	Mobile Athlon XP 1500+	AXMD1500FQQ3C	processor
1181	27	Mobile Athlon XP 1700+	AXMD1700FQQ3C	processor
1185	27	Mobile Athlon XP 1900+	AXMD1900FVQ3C	processor
1189	27	Mobile Athlon XP 1600+	AXMD1600FWS3B	processor
1193	27	Mobile Athlon XP 1800+	AXMD1800FXS3B	processor
1197	27	Athlon XP-M 1800+	AXMH1800FQQ3C	processor
1201	27	Athlon XP-M 2200+	AXMH2200FQQ3C	processor
1205	27	Athlon XP-M 2600+	AXMA2600FKT3C	processor
1209	27	Athlon XP-M 1800+	AXMD1800FJQ3C	processor
1213	27	Athlon XP-M 2200+	AXMD2200FJQ3C	processor
1217	27	Athlon XP-M 1800+	AXMS1800GXS3C	processor
1224	27	Athlon XP-M 2500+	AXMH2500FQQ4C	processor
1228	27	Athlon XP-M 2500+	AXMA2500FKT4C	processor
1232	27	Athlon XP-M 2200+	AXMD2200FJQ4C	processor
1236	27	Athlon XP-M 2000+	AXMD2000GJQ4C	processor
1240	27	Athlon XP-M 2200+	AXMD2200GJQ4C	processor
1244	27	Geode NX 1500	ANXL1500FGC3F	processor
1248	27	Sempron 2300+	SDA2300DUT3D	processor
1252	27	Sempron 2800+	SDA2800DUT3D	processor
1256	27	Sempron 3000+	SDA3000DUT4D	processor
805	27	K5 PR75	AMD-K5-PR75ABR	processor
1263	27	K5 PR166	AMD-K5-PR166ABQ	processor
1271	27	Mobile K6 233	AMD-K6/233ADZ	processor
1275	27	K6-2 250	AMD-K6 3D/250AFR	processor
1279	27	K6-2 333	AMD-K6-2/333AFR	processor
1283	27	K6-2 380	AMD-K6-2/380AFR	processor
1287	27	K6-2 400	AMD-K6-2/400AHX	processor
1291	27	K6-2 475	AMD-K6-2/475AFX	processor
1295	27	K6-2 533	AMD-K6-2/533AFX	processor
1299	27	Mobile K6-2 300	AMD-K6-2/300ANZ	processor
1303	27	Mobile K6-2 350	AMD-K6-2/350AFK	processor
1307	27	Mobile K6-2 400	AMD-K6-2/400AFK	processor
1311	27	Mobile K6-2 450	AMD-K6-2/450ADK	processor
1315	27	K6-2E 233	AMD-K6-2/233AMZ	processor
1319	27	K6-2E 300	AMD-K6-2/300AFR	processor
1323	27	K6-2E 333	AMD-K6-2/333AFR	processor
1327	27	K6-2E 350	AMD-K6-2/350AMZ	processor
927	207	Core 2 Extreme QX6700	HH80562PH0678M	processor
906	27	Athlon 64 X2 3800+	ADA3800IAA5CU	processor
1033	27	Duron 750	D750AUT1B	processor
859	207	Pentium III 450	80525PY450512	processor
2456	452	\N	82C3491	chipsetpart
2483	303	\N	82C546	chipsetpart
2541	379	\N	85C405	chipsetpart
964	207	287	D80287-6	coprocessor
983	446	WTL4167	4167-025-GCD	coprocessor
982	446	WTL3167	3167-016-GCU	coprocessor
986	207	80286	C80286-8	processor
987	207	80286	R80286-10	processor
992	207	80386SX-40	KU80386SX40	processor
991	207	80386SX-33	NG80386SX-33	processor
1026	207	Pentium 166	A80502166	processor
1025	207	Pentium 150	A80502150	processor
1021	207	Pentium 90	A80502-90	processor
1020	207	Pentium 60	A80501-60	processor
920	207	Pentium MMX 266	FV80503266	processor
1000	207	Pentium Pro 200/512K	KB80521EX200 512K	processor
999	207	Pentium Pro 200/256K	KB80521EX200 256K	processor
1007	207	i486 DX4 100	A80486DX4-100	processor
1015	207	i486 DX4 75	A80486DX4-75	processor
1010	207	i486 DX 33	A80486DX-33	processor
1016	207	i486 SX 20	A80486SX-20	processor
1011	207	i486 DX 50	A80486DX-50	processor
1221	27	Mobile K8 Athlon XP-M 3000+	AHN3000BIX3AX	processor
2537	379	\N	85C330	chipsetpart
2691	422	\N	VL82C521	chipsetpart
2675	422	\N	VL82C033	chipsetpart
2732	417	\N	VT82C686A	chipsetpart
2503	303	\N	82C650	chipsetpart
2627	25	\N	M1632	chipsetpart
2376	379	\N	635	chipsetpart
2351	379	\N	10151E+11	chipsetpart
2448	118	\N	82C307	chipsetpart
2618	25	\N	M1535D+	chipsetpart
2356	379	\N	50155E+11	chipsetpart
2505	303	\N	82C652	chipsetpart
2464	303	\N	82C392	chipsetpart
2628	25	\N	M1641B	chipsetpart
2534	379	\N	85C215	chipsetpart
2423	118	\N	82A203	chipsetpart
2661	408	\N	UM82C336F/N	chipsetpart
2401	207	\N	82344	chipsetpart
2509	303	\N	82C686	chipsetpart
2484	303	\N	82C547	chipsetpart
2435	118	\N	82C242	chipsetpart
2549	379	\N	85C471	chipsetpart
2651	380	\N	ST62BC001-B	chipsetpart
2535	379	\N	85C310	chipsetpart
2482	303	\N	82C499	chipsetpart
2476	303	\N	82C495XLC	chipsetpart
2683	422	\N	VL82C322A	chipsetpart
2372	379	\N	630ET	chipsetpart
2566	170	\N	FRX46C422	chipsetpart
2446	118	\N	82C305	chipsetpart
2444	118	\N	82C303	chipsetpart
2707	417	\N	VT82C470	chipsetpart
2520	118	\N	82C811	chipsetpart
2516	303	\N	82C750	chipsetpart
2497	303	\N	82C578	chipsetpart
2373	379	\N	630ST	chipsetpart
2701	422	\N	VL82C597	chipsetpart
2511	303	\N	82C693	chipsetpart
2451	118	\N	82C316	chipsetpart
2461	303	\N	82C381	chipsetpart
2600	25	\N	M1219	chipsetpart
2544	379	\N	85C411	chipsetpart
2562	170	\N	FRX46C402	chipsetpart
2589	345	\N	KS82C289	chipsetpart
2519	303	\N	82C802G/GP	chipsetpart
2419	207	\N	82451NX	chipsetpart
2540	379	\N	85C402	chipsetpart
2656	380	\N	ST62C006	chipsetpart
2602	25	\N	M1431	chipsetpart
2736	417	\N	VT82C693	chipsetpart
2626	25	\N	M1631	chipsetpart
2438	303	\N	82C282	chipsetpart
2361	379	\N	5571	chipsetpart
2524	118	\N	82C841	chipsetpart
2622	25	\N	M1543C	chipsetpart
2741	417	PM133	VT8605	chipsetpart
2445	118	\N	82C304	chipsetpart
2629	25	\N	M1644	chipsetpart
2439	303	\N	82C283	chipsetpart
2508	303	\N	82C683	chipsetpart
2399	207	\N	82231	chipsetpart
2730	417	\N	VT82C597	chipsetpart
2371	379	\N	630E/S	chipsetpart
2449	118	\N	82C311	chipsetpart
2686	422	\N	VL82C420	chipsetpart
2685	422	\N	VL82C37A	chipsetpart
2369	379	\N	5598	chipsetpart
2693	422	\N	VL82C530	chipsetpart
2652	380	\N	ST62BC002-B	chipsetpart
2450	118	\N	82C315	chipsetpart
2358	379	\N	5120	chipsetpart
2670	408	\N	UM8886	chipsetpart
2379	379	\N	640T	chipsetpart
2532	379	\N	85C211	chipsetpart
2466	303	\N	82C461	chipsetpart
2380	118	\N	6.42008E+14	chipsetpart
2590	345	\N	KS82C37A	chipsetpart
2729	417	\N	VT82C596B	chipsetpart
2694	422	\N	VL82C541	chipsetpart
2426	118	\N	82C201	chipsetpart
2526	303	\N	82C898	chipsetpart
2494	303	\N	82C572	chipsetpart
2595	345	\N	KS82C88	chipsetpart
2393	379	\N	748	chipsetpart
2492	303	\N	82C566	chipsetpart
2637	25	\N	M1667	chipsetpart
2412	207	\N	82437	chipsetpart
2709	417	\N	VT82C480	chipsetpart
2606	25	\N	M1449	chipsetpart
2539	379	\N	85C401	chipsetpart
2525	303	\N	82C895	chipsetpart
2569	170	\N	FRX58C601B	chipsetpart
2567	170	\N	FRX46C521A	chipsetpart
2616	25	\N	M1533	chipsetpart
2522	118	\N	82C835	chipsetpart
2384	379	\N	735	chipsetpart
2404	207	\N	82355	chipsetpart
2607	25	\N	M1451	chipsetpart
2704	422	\N	VL82C84A	chipsetpart
2485	303	\N	82C556	chipsetpart
2465	303	\N	82C392SX	chipsetpart
2523	118	\N	82C836	chipsetpart
2592	345	\N	KS82C55A	chipsetpart
2513	303	\N	82C697	chipsetpart
2496	303	\N	82C577	chipsetpart
2720	417	\N	VT82C577M	chipsetpart
2665	408	\N	UM82C491	chipsetpart
2603	25	\N	M1435	chipsetpart
2359	379	\N	530	chipsetpart
2548	379	\N	85C461	chipsetpart
2692	422	\N	VL82C522	chipsetpart
2667	408	\N	UM8496	chipsetpart
2502	118	\N	82C641	chipsetpart
2430	118	\N	82C212	chipsetpart
2561	170	\N	FRX36C311	chipsetpart
2666	408	\N	UM82C493	chipsetpart
2421	207	\N	82453NX	chipsetpart
2653	380	\N	ST62BC003	chipsetpart
2400	207	\N	82343	chipsetpart
2615	25	\N	M1531	chipsetpart
2588	345	\N	KS82C288	chipsetpart
2364	379	\N	5591	chipsetpart
2498	303	\N	82C579	chipsetpart
2738	417	\N	VT82C694T	chipsetpart
2677	422	\N	VL82C146	chipsetpart
2538	379	\N	85C360	chipsetpart
2659	408	\N	UM82C210	chipsetpart
2499	303	\N	82C596	chipsetpart
2554	379	\N	85C503	chipsetpart
2510	303	\N	82C687	chipsetpart
2458	118	\N	82C351	chipsetpart
2630	25	\N	M1644M	chipsetpart
2564	170	\N	FRX46C412	chipsetpart
2706	417	\N	VT82C416	chipsetpart
2648	280	\N	MX83C306AFC	chipsetpart
2531	118	\N	8404184045	chipsetpart
2459	118	\N	82C355	chipsetpart
2366	379	\N	5595	chipsetpart
2610	25	\N	M1511	chipsetpart
2593	345	\N	KS82C59A	chipsetpart
2460	118	\N	82C356	chipsetpart
2605	25	\N	M1445	chipsetpart
2715	417	\N	VT82C496G	chipsetpart
2398	207	\N	82230	chipsetpart
2578	207	\N	82288	chipsetpart
2649	289	\N	8237AC	chipsetpart
2644	273	\N	MC146818P	chipsetpart
2581	207	\N	8254-2	chipsetpart
2657	393	\N	SN74LS612N	chipsetpart
2579	207	\N	8237A-5	chipsetpart
2583	207	\N	8259A	chipsetpart
2585	207	\N	8284A	chipsetpart
2357	379	PLDB	5512	chipsetpart
2580	207	\N	8253-5	chipsetpart
2360	379	PSIO	5513	chipsetpart
2355	379	PCMC	5511	chipsetpart
2643	25	\N	M1429	chipsetpart
2409	207	LBX	82433NX	chipsetpart
2408	207	LBX	82433LX	chipsetpart
2377	379	\N	635T	chipsetpart
2682	422	\N	VL82C3216	chipsetpart
2633	25	\N	M1649	chipsetpart
2378	27	\N	640	chipsetpart
2397	27	\N	762	chipsetpart
2395	27	\N	761	chipsetpart
2394	27	Irongate	751	chipsetpart
2641	262	\N	MIC 362	chipsetpart
2642	262	\N	MIC 363	chipsetpart
2718	417	\N	VT82C576M	chipsetpart
2428	118	\N	82C206	chipsetpart
2684	422	\N	VL82C331	chipsetpart
2634	25	\N	M1651	chipsetpart
2552	379	\N	85C501	chipsetpart
2447	118	\N	82C306	chipsetpart
2617	25	\N	M1535D	chipsetpart
2431	118	\N	82C215	chipsetpart
2750	464	\N	W83C629D	chipsetpart
2735	417	\N	VT82C692BX	chipsetpart
2385	379	\N	735S	chipsetpart
2717	417	\N	VT82C575MV	chipsetpart
2427	118	\N	82C202	chipsetpart
2745	464	\N	W83626F/D	chipsetpart
2636	25	\N	M1657/?	chipsetpart
2467	303	\N	82C462	chipsetpart
2365	379	\N	5592	chipsetpart
2723	417	\N	VT82C586	chipsetpart
2613	25	\N	M1521	chipsetpart
2403	207	\N	82346	chipsetpart
2639	379	\N	M741	chipsetpart
2571	170	\N	FRX58C613	chipsetpart
2728	417	\N	VT82C596A	chipsetpart
2727	417	\N	VT82C596	chipsetpart
2559	170	\N	FRX36C200	chipsetpart
2367	379	\N	5596	chipsetpart
2598	25	\N	M1209	chipsetpart
2386	379	\N	740	chipsetpart
2388	379	\N	741GX	chipsetpart
2734	417	\N	VT82C691	chipsetpart
2391	379	\N	746DX	chipsetpart
2374	379	\N	633	chipsetpart
2737	417	\N	VT82C693A	chipsetpart
2679	422	\N	VL82C288	chipsetpart
2437	303	\N	82C281	chipsetpart
2625	25	\N	M1621	chipsetpart
2719	417	\N	VT82C576MV	chipsetpart
2680	422	\N	VL82C315A	chipsetpart
2663	408	\N	UM82C39x	chipsetpart
2591	345	\N	KS82C54A	chipsetpart
2455	452	\N	82C3480	chipsetpart
2570	170	\N	FRX58C602B	chipsetpart
2491	303	\N	82C558N	chipsetpart
2418	207	\N	82439TX	chipsetpart
2457	452	\N	82C3493	chipsetpart
2687	422	\N	VL82C425	chipsetpart
2658	408	\N	UM82C088	chipsetpart
2672	422	\N	VL82C018	chipsetpart
2660	408	\N	UM82C230	chipsetpart
2452	118	\N	82C321	chipsetpart
2668	408	\N	UM8498	chipsetpart
2710	417	\N	VT82C482	chipsetpart
2479	303	\N	82C496B	chipsetpart
2725	417	\N	VT82C587VP	chipsetpart
2698	422	\N	VL82C593	chipsetpart
2463	303	\N	82C391	chipsetpart
2425	118	\N	82A205	chipsetpart
2368	379	\N	5597	chipsetpart
2647	280	\N	MX83C305AFC	chipsetpart
2477	303	\N	82C496	chipsetpart
2733	417	\N	VT82C686B	chipsetpart
2703	422	\N	VL82C612	chipsetpart
2700	422	\N	VL82C596	chipsetpart
2553	379	\N	85C502	chipsetpart
2596	25	\N	M????	chipsetpart
2724	417	\N	VT82C586B	chipsetpart
2402	207	\N	82345	chipsetpart
2530	118	\N	8403184035	chipsetpart
2678	422	\N	VL82C284	chipsetpart
2748	464	\N	W83C492	chipsetpart
2669	408	\N	UM8881	chipsetpart
2382	379	\N	730SE	chipsetpart
2705	422	\N	VL82C88	chipsetpart
2422	207	\N	82454NX	chipsetpart
2716	417	\N	VT82C575M	chipsetpart
2468	303	\N	82c463	chipsetpart
2631	25	\N	M1646	chipsetpart
2699	422	\N	VL82C594	chipsetpart
2624	25	\N	M1563	chipsetpart
2469	303	\N	82c465MV/A/B	chipsetpart
2470	303	\N	82C481?	chipsetpart
2434	118	\N	82C235	chipsetpart
2543	379	\N	85C407	chipsetpart
2473	303	\N	82C493	chipsetpart
2489	303	\N	82C558	chipsetpart
2688	422	\N	VL82C480	chipsetpart
2515	303	\N	82C701	chipsetpart
2529	118	\N	8402184025	chipsetpart
2565	170	\N	FRX46C421A	chipsetpart
2443	118	\N	82C302	chipsetpart
2433	118	\N	82C226	chipsetpart
2500	303	\N	82C597	chipsetpart
2472	303	\N	82C491	chipsetpart
2363	379	\N	5582	chipsetpart
2493	303	\N	82C571	chipsetpart
2546	379	\N	85C431	chipsetpart
2429	118	\N	82C211	chipsetpart
2440	303	\N	82C291	chipsetpart
2654	380	\N	ST62BC004-B1	chipsetpart
2501	118	\N	82C636	chipsetpart
2697	422	\N	VL82C591	chipsetpart
2655	380	\N	ST62C005-B	chipsetpart
2475	303	\N	82C495SX	chipsetpart
2560	170	\N	FRX36C300	chipsetpart
2722	417	\N	VT82C585VP	chipsetpart
2481	303	\N	82C498	chipsetpart
2689	422	\N	VL82C481	chipsetpart
2387	379	\N	741	chipsetpart
2714	417	\N	VT82C495	chipsetpart
2436	303	\N	82C263	chipsetpart
2381	379	\N	730S	chipsetpart
2747	464	\N	W83C491	chipsetpart
2572	170	\N	FRX58C613A	chipsetpart
2453	118	\N	82C322	chipsetpart
2696	422	\N	VL82C54A	chipsetpart
2632	25	\N	M1647	chipsetpart
2612	25	\N	M1513	chipsetpart
2662	408	\N	UM82C380	chipsetpart
2478	303	\N	82c496A	chipsetpart
2375	379	\N	633T	chipsetpart
2601	25	\N	M1419	chipsetpart
2370	379	\N	630	chipsetpart
2739	417	\N	VT82C694X	chipsetpart
2743	417	\N	VT8607	chipsetpart
2420	207	\N	82452NX	chipsetpart
2673	422	\N	VL82C031	chipsetpart
2746	464	\N	W83628F	chipsetpart
2676	422	\N	VL82C144	chipsetpart
2558	170	\N	FRX36C100	chipsetpart
2521	118	\N	82C812	chipsetpart
2614	25	\N	M1523	chipsetpart
2514	303	\N	82C700	chipsetpart
2362	379	\N	5581	chipsetpart
2432	118	\N	82C223	chipsetpart
2563	170	\N	FRX46C411	chipsetpart
2708	417	\N	VT82C475	chipsetpart
2545	379	\N	85C420	chipsetpart
2587	345	\N	KS82C284	chipsetpart
2350	303	\N		chipsetpart
2711	417	\N	VT82C483	chipsetpart
2702	422	\N	VL82C59A	chipsetpart
2620	25	\N	M1542	chipsetpart
2389	379	\N	745	chipsetpart
2681	422	\N	VL82C320A	chipsetpart
2536	379	\N	85C320	chipsetpart
2635	25	\N	M1651T	chipsetpart
2413	207	TSC	82437FX	chipsetpart
2584	207	\N	8259A-2	chipsetpart
2586	207	\N	8288	chipsetpart
2582	207	\N	8255A-5	chipsetpart
2664	408	\N	UM82C481	chipsetpart
2550	379	PCM	85C496	chipsetpart
2551	379	ATM	85C497	chipsetpart
2731	417	\N	VT82C598MVP	chipsetpart
2742	417	PN133	VT8606	chipsetpart
2621	25	\N	M1543/M1543C	chipsetpart
2486	303	Viper-M DBC	82C556M	chipsetpart
2712	417	\N	VT82C486A	chipsetpart
2414	207	TVX	82437VX	chipsetpart
2415	207	TDX	82438VX	chipsetpart
2410	207	PCMC	82434LX	chipsetpart
2608	25	IBC	M1487	chipsetpart
2506	303	\N	82C681	chipsetpart
2471	303	\N	82C482?	chipsetpart
2604	25	\N	M1439	chipsetpart
2594	345	\N	KS82C84A	chipsetpart
2695	422	\N	VL82C543	chipsetpart
2740	417	SMA	VT82C501	chipsetpart
2640	262	\N	MIC 361	chipsetpart
2599	25	\N	M1217	chipsetpart
2480	303	\N	82C497	chipsetpart
2441	303	\N	82C295	chipsetpart
2611	25	\N	M1512	chipsetpart
2547	379	\N	85C460	chipsetpart
2517	303	\N	82c801	chipsetpart
2504	303	\N	82C651	chipsetpart
2406	207	\N	82425EX	chipsetpart
2638	25	\N	M6117	chipsetpart
2542	379	\N	85C406	chipsetpart
2674	422	\N	VL82C032	chipsetpart
2507	303	\N	82C682	chipsetpart
2518	303	\N	82C802	chipsetpart
2568	170	\N	FRX58C601A	chipsetpart
2495	303	\N	82C576	chipsetpart
2383	379	\N	733	chipsetpart
2597	25	\N	M1207	chipsetpart
2392	379	\N	746FX	chipsetpart
2690	422	\N	VL82C486	chipsetpart
2623	25	\N	M1561	chipsetpart
2454	118	\N	82C325	chipsetpart
2713	417	\N	VT82C491	chipsetpart
2619	25	\N	M1541	chipsetpart
2442	118	\N	82C301	chipsetpart
2533	379	\N	85C212	chipsetpart
2390	379	\N	746	chipsetpart
2490	303	\N	82C558E	chipsetpart
2487	303	\N	82C557	chipsetpart
2744	417	\N	VT8608	chipsetpart
2749	464	\N	W83C553F	chipsetpart
2726	417	\N	VT82C595	chipsetpart
2462	303	\N	82C382	chipsetpart
2424	118	\N	82A204	chipsetpart
2407	207	\N	82426EX	chipsetpart
2751	207	PIIX3	82371SB	chipsetpart
2752	207	PIIX4	82371AB	chipsetpart
2754	207	PIIX4E	82371EB	chipsetpart
2755	207	PMC	82441FX	chipsetpart
2756	207	DBX	82442FX	chipsetpart
2753	207	PAC	82443BX	chipsetpart
2757	207	PAC	82443LX	chipsetpart
2417	207	TXC	82439HX	chipsetpart
2416	207	TDP	82438FX	chipsetpart
2758	207	PIIX	82371FB	chipsetpart
2576	207	\N	8042	chipsetpart
2577	207	\N	82284	chipsetpart
2759	422	\N	VL82C311	chipsetpart
2760	408	\N	UM82C482	chipsetpart
2761	408	\N	UM82C206	chipsetpart
2762	345	\N	KS83C206	chipsetpart
2763	381	\N	SL82C461	chipsetpart
2764	381	\N	SL82C362	chipsetpart
2765	381	\N	SL82C465	chipsetpart
2766	381	\N	SL82C491	chipsetpart
2767	381	\N	SL82C492	chipsetpart
2769	422	\N	VL82C330	chipsetpart
2770	422	\N	VL82C332	chipsetpart
2771	303	\N	82C206	chipsetpart
2772	303	\N	82C822	chipsetpart
2773	379	\N	85C206	chipsetpart
2774	207	PAC	82443ZX	chipsetpart
2775	393	\N	TACT82301	chipsetpart
2776	393	\N	TACT82302	chipsetpart
2777	393	\N	TACT82303	chipsetpart
2778	207	PAC	82443EX	chipsetpart
2779	207	MCH	82820	chipsetpart
2780	207	ICH	82801AA	chipsetpart
2784	207	MCH	82815EP	chipsetpart
2785	207	MCH	82815P	chipsetpart
2788	207	ICH2	82801BA	chipsetpart
2789	207	ICH0	82801AB	chipsetpart
2790	207	ICH3	82801CA	chipsetpart
2791	207	ICH4	82801DB	chipsetpart
2793	207	6300ESB	6300ESB	chipsetpart
2794	207	MCH	82850	chipsetpart
2781	207	GMCH	82810	chipsetpart
2786	207	GMCH	82815G	chipsetpart
2782	207	GMCH	82815	chipsetpart
2783	207	GMCH	82815E	chipsetpart
2787	207	GMCH	82815EG	chipsetpart
2795	207	MCH	82820E	chipsetpart
2796	207	MCH	82840	chipsetpart
2797	207	MCH	82845	chipsetpart
2798	207	MCH	82845E	chipsetpart
2799	207	GMCH	82845G	chipsetpart
2800	207	GMCH	82845GV	chipsetpart
2801	207	GMCH	82845GL	chipsetpart
2802	207	MCH	82845PE	chipsetpart
2803	207	MCH	82848P	chipsetpart
2804	207	GMCH	82845GE	chipsetpart
2805	207	MCH	82875P	chipsetpart
2806	207	MCH	82865PE	chipsetpart
2807	207	MCH	82865P	chipsetpart
2808	207	GMCH	82865G	chipsetpart
2809	207	GMCH	82865GV	chipsetpart
2810	207	MCH	82850E	chipsetpart
2811	207	MCH	82860	chipsetpart
2812	207	MCH	E7205	chipsetpart
2813	207	MCH	E7505	chipsetpart
2814	207	GMCH	82855GM	chipsetpart
2815	207	GMCH	82855GME	chipsetpart
2816	207	MTH	82805AA	chipsetpart
2817	207	GMCH	82810E	chipsetpart
2818	207	GMCH	82852GM	chipsetpart
2819	207	GMCH	82852GMV	chipsetpart
2820	207	GMCH	82852GME	chipsetpart
2821	207	GMCH	82854	chipsetpart
2822	207	MCH	82852PM	chipsetpart
2823	207	MCH	82845MZ	chipsetpart
2824	207	MCH	82845MP	chipsetpart
2825	207	MCH	82855PM	chipsetpart
2831	207	GMCH	82830M	chipsetpart
2832	207	MCH	82830MP	chipsetpart
2833	207	GMCH	82830MG	chipsetpart
2830	207	GMCH	82815EM	chipsetpart
2827	207	ICH3M	82801CAM	chipsetpart
2828	207	ICH4M	82801DBM	chipsetpart
2829	207	ICH5M	82801EBM	chipsetpart
2826	207	ICH2M	82801BAM	chipsetpart
2354	207	\N	82438MX	chipsetpart
2837	379	\N	5600	chipsetpart
2841	379	\N	961/961B	chipsetpart
2842	379	\N	962/962L	chipsetpart
2843	379	\N	963/963L	chipsetpart
2844	379	\N	965/965L	chipsetpart
2845	379	\N	964/964L	chipsetpart
2846	379	\N	966/966L	chipsetpart
2847	379	\N	968	chipsetpart
2848	379	\N	620	chipsetpart
2849	379	\N	600	chipsetpart
2850	379	\N	621	chipsetpart
2851	379	\N	645	chipsetpart
2852	379	\N	645DX	chipsetpart
2853	379	\N	650	chipsetpart
2854	379	\N	650GX	chipsetpart
2855	379	\N	651	chipsetpart
2856	379	\N	648	chipsetpart
2857	379	\N	648FX	chipsetpart
2858	379	\N	655	chipsetpart
2859	379	\N	655FX	chipsetpart
2860	379	\N	655TX	chipsetpart
2861	379	\N	661FX	chipsetpart
2862	379	\N	661GX	chipsetpart
2671	408	\N	UM8891BF	chipsetpart
2863	408	\N	UM8892BF	chipsetpart
2864	408	\N	UM8886BF	chipsetpart
2867	417	\N	VT8231	chipsetpart
2868	417	\N	VT8233	chipsetpart
2869	417	\N	VT8233A	chipsetpart
2870	417	\N	VT8233C	chipsetpart
2871	417	\N	VT8235	chipsetpart
2872	417	\N	VT8237/VT8237R	chipsetpart
2873	417	\N	VT8237+/VT8237R+	chipsetpart
2874	417	\N	VT8237A	chipsetpart
2875	417	\N	VT8237S	chipsetpart
2609	25	CMP	M1489	chipsetpart
2876	417	\N	VT8251	chipsetpart
2877	417	\N	VT8261	chipsetpart
2883	207	PAC	82443GX	chipsetpart
2411	207	PCMC	82434NX	chipsetpart
2884	474	\N	88C4386C	chipsetpart
2885	25	\N	M1101	chipsetpart
2886	452	\N	AT40391	chipsetpart
2887	452	\N	G392	chipsetpart
2903	417	\N	VT8364	chipsetpart
2908	417	\N	VT8364A	chipsetpart
2909	417	\N	VT8367A	chipsetpart
2914	417	\N	VT82C680	chipsetpart
2915	417	\N	VT82C685	chipsetpart
2916	417	\N	VT82C687	chipsetpart
2917	471	nForce 220	NV1A	chipsetpart
2918	471	nForce 415	NV1A	chipsetpart
2919	471	nForce 420	NV1A	chipsetpart
2922	471	nForce2 SPP	NV1F	chipsetpart
2923	471	nForce2 IGP	NV1F	chipsetpart
2924	471	nForce2 400	NV1F	chipsetpart
2925	471	nForce2 Ultra 400	NV1F	chipsetpart
2934	417	\N	VT3344	chipsetpart
2935	490	\N	UT85C501	chipsetpart
2936	490	\N	UT85C502	chipsetpart
2938	311	\N	HT82C437VX-II	chipsetpart
2937	490	\N	UT85C503	chipsetpart
2939	417	\N	VT82C481	chipsetpart
2941	417	\N	VT82C485	chipsetpart
2942	405	Blade3D AGP	9880	chipsetpart
2943	311	CHIP 2	TC6154AF	chipsetpart
2944	422	\N	VL82C100	chipsetpart
2945	207	ESC	82374EB	chipsetpart
2946	207	ESC	82374SB	chipsetpart
2947	207	PCEB	82375EB	chipsetpart
2948	207	PCEB	82375SB	chipsetpart
2949	207	SIO	82378IB	chipsetpart
2950	207	SIO	82378ZB	chipsetpart
2721	417	\N	VT82C585VPX	chipsetpart
2952	27	\N	645	chipsetpart
2953	27	\N	756	chipsetpart
2954	27	\N	766	chipsetpart
2955	27	\N	768	chipsetpart
2396	27	\N	8111	chipsetpart
2956	27	\N	8131	chipsetpart
2957	27	\N	8132	chipsetpart
2958	27	\N	8151	chipsetpart
2961	207	PAC	82443ZX66M	chipsetpart
2962	155	\N	EQ82C6628	chipsetpart
2963	155	\N	EQ82C6629	chipsetpart
2964	155	\N	EQ6617	chipsetpart
2965	155	\N	EQ6618	chipsetpart
2966	155	\N	EQ6619	chipsetpart
2968	464	\N	W83C201P	chipsetpart
2969	464	\N	W83C202AP	chipsetpart
2970	464	\N	W83C203AP	chipsetpart
2971	464	\N	W83C204P	chipsetpart
2972	464	\N	W83C205P	chipsetpart
2973	207	\N	82423TX	chipsetpart
2974	207	\N	82424TX	chipsetpart
2928	471	nForce2 MCP SATA	MCP2-S	chipsetpart
2951	207	SIO+APIC	82379AB	chipsetpart
2891	417	KT133	VT8363	chipsetpart
2931	471	nForce3 150 MCP	CK8	chipsetpart
2933	471	Crush73	C73	chipsetpart
2920	471	nForce MCP	MCP	chipsetpart
2921	471	nForce MCP SoundStorm	MCP-D	chipsetpart
2929	471	nForce2 MCP RAID	MCP2-R	chipsetpart
2893	417	KT133A	VT8363A	chipsetpart
2880	417	CLE266	VT8622	chipsetpart
2904	417	KT600	VT8377	chipsetpart
2905	417	KT400A	VT8377A	chipsetpart
2897	417	KT266	VT8366	chipsetpart
2907	417	KM400	VT8378	chipsetpart
2902	417	KT400	VT8368	chipsetpart
2901	417	KT333	VT8367	chipsetpart
2899	417	KT266A	VT8366A	chipsetpart
2895	417	KLE133	VT8361	chipsetpart
2892	417	KT133E	VT8363E	chipsetpart
2894	417	KM133	VT8365	chipsetpart
2900	417	KN133	VT8362	chipsetpart
2911	417	KN266	VT8372	chipsetpart
2898	417	KM266	VT8375	chipsetpart
2906	417	KT880	VT8379	chipsetpart
2865	417	PLE133	VT8601/A	chipsetpart
2913	417	PM266	VT8613	chipsetpart
2879	417	Pro266T	VT8653	chipsetpart
2878	417	Pro266	VT8633	chipsetpart
2882	417	P4M266	VT8751	chipsetpart
2910	417	P4X400	VT8754	chipsetpart
2866	417	PLE133T	VT8601T	chipsetpart
2912	417	PL133	VT8604/T	chipsetpart
2975	207	\N	82424ZX	chipsetpart
2976	207	\N	82451GX	chipsetpart
2977	207	\N	82452GX	chipsetpart
2978	207	\N	82453GX	chipsetpart
2979	207	\N	82454GX	chipsetpart
2980	207	\N	82443DX	chipsetpart
2981	207	\N	82451KX	chipsetpart
2982	207	\N	82452KX	chipsetpart
2983	207	\N	82453KX	chipsetpart
2984	207	\N	82454KX	chipsetpart
2985	464	\N	W83C320WF	chipsetpart
2986	417	\N	VT82C535MV	chipsetpart
2987	417	\N	VT82C531MV	chipsetpart
2988	417	\N	VT82C505	chipsetpart
2989	417	\N	VT82C406MV	chipsetpart
2960	262	\N	MIC 471	chipsetpart
2959	262	\N	MIC 472	chipsetpart
2991	25	\N	M1671	chipsetpart
2992	25	\N	M1672	chipsetpart
2993	25	\N	M1681	chipsetpart
2994	25	\N	M1683	chipsetpart
2995	25	\N	M1687	chipsetpart
2997	207	MCH	82915P	chipsetpart
2998	207	MCH	82915PL	chipsetpart
2999	207	MCH	82925X	chipsetpart
3000	207	MCH	82925XE	chipsetpart
3001	207	GMCH	82915G	chipsetpart
3002	207	GMCH	82915GV	chipsetpart
3003	207	GMCH	82915GL	chipsetpart
3004	207	GMCH	82910GL	chipsetpart
3007	207	GMCH	82915GM	chipsetpart
3008	207	MCH	82915PM	chipsetpart
3009	379	\N	755	chipsetpart
3010	379	\N	755FX	chipsetpart
3011	379	\N	756	chipsetpart
3012	379	\N	760	chipsetpart
3013	379	\N	760GX	chipsetpart
3014	379	\N	761GX	chipsetpart
3015	379	\N	771	chipsetpart
3016	379	\N	662	chipsetpart
3017	379	\N	671	chipsetpart
3018	379	\N	671FX	chipsetpart
3019	379	\N	671DX	chipsetpart
3020	379	\N	672	chipsetpart
3021	379	\N	R658	chipsetpart
3022	379	\N	656	chipsetpart
3023	379	\N	649	chipsetpart
3024	379	\N	649DX	chipsetpart
3025	379	\N	649FX	chipsetpart
3026	379	\N	656FX	chipsetpart
3027	379	\N	R658	chipsetpart
3028	379	\N	650GL	chipsetpart
3029	262	\N	MIC 461	chipsetpart
3030	262	\N	MIC 462	chipsetpart
3032	422	\N	VL82C102	chipsetpart
3033	422	\N	VL82C103	chipsetpart
3035	422	\N	VL82C101	chipsetpart
3036	422	\N	VL82C102A	chipsetpart
3037	422	\N	VL82C103	chipsetpart
3038	422	\N	VL82C105	chipsetpart
3039	155	\N	EQ82C6638	chipsetpart
3034	422	\N	VL82C104	chipsetpart
3040	155	\N	EQ82C6639	chipsetpart
3041	292	\N	NxVL	chipsetpart
3045	43	\N	Presto	chipsetpart
3046	45	Discrete	(none)	chipsetpart
3047	507	POACH 1	82C230	chipsetpart
3048	507	POACH 2	82C231	chipsetpart
3049	292	NxPCI	VL82C501	chipsetpart
3050	292	NxMC	VL82C500	chipsetpart
3051	508	\N	A27C001	chipsetpart
3052	508	\N	A27C011	chipsetpart
3053	452	\N	83C8881F	chipsetpart
3054	452	\N	83C8886F	chipsetpart
2990	555	\N	M1689	chipsetpart
3055	155	\N	ET82C491	chipsetpart
3056	155	\N	ET82C493	chipsetpart
1008	118	Super 386	J38600DX-33	processor
1268	27	K6 266	AMD-K6/266AFR	processor
897	27	Athlon XP 1500+	AX1500DMT3C	processor
910	27	Athlon 64 FX-51	ADAFX51CEP5AK	processor
1034	27	Duron 800	D800AUT1B	processor
1038	27	Duron 950	DHD950AMT1B	processor
1042	27	Duron 1300	DHD1300AMT1B	processor
1046	27	Mobile Duron 850	DHM0850AVS1B	processor
1050	27	Mobile Duron 1100	DHM1100AHQ1B	processor
1054	27	Athlon 600	AMD-K7600MTR51B C	processor
1058	27	Athlon 600	AMD-K7600MTR51B A	processor
1062	27	Athlon 800	AMD-K7800MPR52B A	processor
1066	27	Athlon 1000	AMD-K7100MNR53B A	processor
1070	27	Athlon 850	AMD-A0850MPR24B A	processor
1074	27	Athlon 650	A0650AMT3B	processor
1078	27	Athlon 850	A0850AMT3B	processor
1082	27	Athlon 1000C	A1000AMS3C	processor
1086	27	Athlon 1200C	A1200AMS3C	processor
1090	27	Athlon 1400B	A1400AMS3B	processor
1094	27	Athlon XP 1800+	AX1800DMT3C	processor
1098	27	Athlon SFF 1000	AHL1000AUT3B	processor
1102	27	Athlon SFF 1600+	AXL1600DQT3B	processor
1106	27	Athlon XP 1800+	AXDA1800DUT3C	processor
1110	27	Athlon XP 2100+	AXDA2100DUT3C	processor
1114	27	Athlon XP 2400+	AXDA2400DKV3C	processor
1118	27	Athlon XP 2800+	AXDA2800DKV3D	processor
1122	27	Athlon XP SFF 1700+	AXLD1700DQT3C	processor
1126	27	Athlon XP 2000+	AXDC2000DLT3C	processor
1130	27	Athlon XP 2400+	AXDC2400DKV3C	processor
1134	27	Athlon XP 2500+	AXDA2500DKV4C	processor
1138	27	Athlon XP 2600+	AXDA2600DKV4E	processor
1142	27	Athlon XP 3000+	AXDA3000DKV4E	processor
1146	27	Low-power Athlon XP 2500+	AXDL2500DLV4D	processor
1150	27	Low-power Athlon XP 3000+	AXDL3000DLV4E	processor
1154	27	Athlon MP 1600+	AMP1600DMS3C	processor
1158	27	Athlon MP 2100+	AMP2100DMS3C	processor
1162	27	Athlon MP 2400+	AMSN2400DKT3C	processor
1166	27	Mobile Athlon 4 950	AHM0950AVS3B	processor
1170	27	Mobile Athlon 4 1100	AHM1100AUQ3B	processor
1174	27	Mobile Athlon XP 1400+	AXMD1400FQQ3B	processor
1178	27	Mobile Athlon XP 1600+	AXMD1600FQQ3B	processor
1182	27	Mobile Athlon XP 1800+	AXMD1800FQQ3B	processor
3006	207	ICH6M	82801FBM	chipsetpart
993	207	i386 DX-20	A80386DX-20	processor
2996	417	\N	K8M800	chipsetpart
1186	27	Mobile Athlon XP 1400+	AXMD1400FWS3B	processor
1190	27	Mobile Athlon XP 1600+	AXMD1600FXS3B	processor
1194	27	Mobile Athlon XP 1800+	AXMD1800FXS3C	processor
1198	27	Athlon XP-M 1900+	AXMH1900FLQ3C	processor
1202	27	Athlon XP-M 2000+	AXMA2000FUT3C	processor
1206	27	Athlon XP-M 1500+	AXMD1500DLQ3B	processor
1210	27	Athlon XP-M 1900+	AXMD1900FJQ3B	processor
1214	27	Athlon XP-M 1000	AXML1000GTS3B	processor
1218	27	Athlon XP-M 1800+	AXMD1800GJQ3C	processor
1628	207	387	A80387-20	coprocessor
1222	27	Athlon XP-M 2000+	AXMD2000GJQ3C	processor
1225	27	Athlon XP-M 2600+	AXMG2600FQQ4C	processor
1229	27	Athlon XP-M 2600+	AXMA2600FKT4C	processor
1233	27	Athlon XP-M 2400+	AXMD2400FJQ4C	processor
1237	27	Athlon XP-M 2000+	AXMS2000GXS4C	processor
1241	27	Athlon XP-M 2100+	AXMS2100GXS4C	processor
1249	27	Sempron 2400+	SDA2400DUT3D	processor
1253	27	Sempron 2200+	SDC2200DUT3D	processor
1257	27	Sempron 3300+	SDA3300DKV4E	processor
1245	27	Geode NX 1750	ANXS1750FXC3F	processor
1260	27	K5 PR120	AMD-K5-PR120ABQ	processor
1264	27	K5 PR200	AMD-K5-PR200ABX	processor
1272	27	Mobile K6 266	AMD-K6/266ACZ	processor
1276	27	K6-2 266	AMD-K6-2/266AFR	processor
1280	27	K6-2 333	AMD-K6-2/333AFR	processor
1284	27	K6-2 400	AMD-K6-2/400AFR	processor
1288	27	K6-2 450	AMD-K6-2/450AFX	processor
1292	27	K6-2 475	AMD-K6-2/475AHX	processor
1296	27	K6-2 550	AMD-K6-2/550AFX	processor
1300	27	Mobile K6-2 300	AMD-K6-2/300ANZ	processor
1304	27	Mobile K6-2 366	AMD-K6-2/366AFK	processor
1308	27	Mobile K6-2 400	AMD-K6-2/400ACK	processor
1312	27	Mobile K6-2 475	AMD-K6-2/475ACK	processor
1316	27	K6-2E 266	AMD-K6-2/266AFR	processor
1320	27	K6-2E 300	AMD-K6-2/300AMZ	processor
1324	27	K6-2E 333	AMD-K6-2/333AMZ	processor
1355	27	Mobile K6-III 350	AMD-K6-III/350AFK	processor
1356	27	Mobile K6-III 380	AMD-K6-III/380AFK	processor
1357	27	Mobile K6-III 400	AMD-K6-III/400ACK	processor
1358	27	Mobile K6-III 400	AMD-K6-III/400ACK	processor
1359	27	Mobile K6-III 433	AMD-K6-III/433ACK	processor
1360	27	Mobile K6-III 450	AMD-K6-III/450ACK	processor
1361	27	Mobile K6-III+ 450	AMD-K6-III+/450ACZ	processor
1362	27	Mobile K6-III+ 475	AMD-K6-III+/475ACZ	processor
1363	27	Mobile K6-III+ 500	AMD-K6-III+/500ACZ	processor
1364	27	K6-III+ 400	AMD-K6-III+/400ATZ	processor
1365	27	K6-III+ 400	AMD-K6-III+/400ATZ	processor
1366	27	K6-III+ 500	AMD-K6-III+/500ANZ	processor
1367	27	K6-III+ 400	AMD-K6-III+/400ACR	processor
1368	27	K6-III+ 400	AMD-K6-III+/400ACR	processor
1369	27	K6-III+ 450	AMD-K6-III+/450ACR	processor
1772	273	68881	MC68881RC25	coprocessor
1022	207	Pentium 100	A80502-100	processor
1003	207	Pentium Pro 200/1M	GJ80521EX200 1M	processor
997	207	Pentium Pro 166/512K	KB80521EX166 512K	processor
1012	207	i486 DX2 50	A80486DX2-50	processor
1370	27	K6-III+ 500	AMD-K6-III+/500ACR	processor
1371	27	K6-III+ 550	AMD-K6-III+/550ACR	processor
1372	207	Pentium II 233	80522PX233512	processor
1373	207	Pentium II 266 (256K)	80522PX266256	processor
1374	207	Pentium II 266	80522PX266512	processor
1375	207	Pentium II 266	80523PX266512	processor
1376	207	Pentium II 300	80522PX300512	processor
1377	207	Pentium II 300	80523PX300512PE	processor
1378	207	Pentium II 333	80523PX333512PE	processor
1379	207	Pentium II 350	80523PY350512PE	processor
1380	207	Pentium II 400	80523PY400512PE	processor
1381	207	Pentium II 450	80523PY450512PE	processor
1382	207	Celeron 300	BX80523R300000	processor
1383	207	Celeron 333	BX80524P333128	processor
1384	207	Celeron 366	BX80524P400128	processor
1386	207	Celeron 400	BX80524P400128	processor
1385	207	Celeron 433	BX80524P433128	processor
1387	207	Celeron 466	BX80524P466128	processor
1388	207	Celeron 500	BX80524P500128	processor
1389	207	Celeron 533	BX80524P533128	processor
1390	207	Celeron 300A	80524RX300128	processor
1391	207	Celeron 333	80524RX333128	processor
1392	207	Celeron 366	80524RX366128	processor
1393	207	Celeron 400	80524RX400128	processor
1394	207	Celeron 433	80524RX433128	processor
1395	27	K6 233	AMD-K6/233AFR	processor
1396	27	K6 200	AMD-K6/200AFR	processor
1397	27	Mobile K6 233	AMD-K6/233BCZ	processor
1398	27	Mobile K6 300	AMD-K6/300ADZ	processor
1399	27	K6-2 400	AMD-K6-2/400AFQ	processor
1400	27	K6-2 400	AMD-K6-2/400AFQ	processor
1401	27	Mobile K6-III 366	AMD-K6-III/366AFK	processor
1402	207	Pentium III 500	80525PY500512	processor
1403	207	Pentium III 533B	80525PZ533512	processor
1815	497	2C87	2C87-20	coprocessor
1404	207	Pentium III 550	80525PY550512	processor
1405	207	Pentium III 600	80525PY600512	processor
1406	207	Pentium III 600B	80525PZ600512	processor
1407	207	Pentium II Xeon 400	80523KX4001M	processor
1408	207	Pentium II Xeon 450	80523KX450512	processor
1409	207	Pentium II Xeon 450	80523KX4501M	processor
1410	207	Pentium II Xeon 450	80523KX4502M	processor
1411	207	Pentium III Xeon 500	80525KX5001M	processor
1412	207	Pentium III Xeon 500	80525KX5002M	processor
1413	207	Pentium III Xeon 550	80525KY550512	processor
1414	207	Pentium III Xeon 550	80525KY5501M	processor
1619	207	i287XL	C80287XL	coprocessor
1415	207	Pentium III Xeon 550	80525KY5502M	processor
935	207	Pentium III Xeon 600 (2.8V)	80526KZ600256 2.8V	processor
1416	207	Pentium III Xeon 667 (2.8V)	80526KZ667256 2.8V	processor
1417	207	Pentium III Xeon 667 (5/12V)	80526KZ667256 5/12V	processor
1418	207	Pentium III Xeon 700 (2.8V)	80526KY7001M 2.8V	processor
1419	207	Pentium III Xeon 700 (2.8V)	80526KY7002M 2.8V	processor
1420	207	Pentium III Xeon 700 (5/12V)	80526KY7001M 5/12V	processor
1630	207	387	A80387-25	coprocessor
1421	207	Pentium III Xeon 700 (5/12V)	80526KY7002M 5/12V	processor
1422	207	Pentium III Xeon 733 (2.8V)	80526KZ733256 2.8V	processor
1423	207	Pentium III Xeon 733 (5/12V)	80526KZ733256 5/12V	processor
1424	207	Pentium III Xeon 800 (2.8V)	80526KZ800256 2.8V	processor
1425	207	Pentium III Xeon 800 (5/12V)	80526KZ800256 5/12V	processor
1426	207	Pentium III Xeon 866 (2.8V)	80526KZ866256 2.8V	processor
1427	207	Pentium III Xeon 866 (5/12V)	80526KZ866256 5/12V	processor
1428	207	Pentium III Xeon 900 (2.8V)	80526KY9002M 2.8V	processor
1429	207	Pentium III Xeon 900 (5/12V)	80526KY9002M 5/12V	processor
1430	207	Pentium III Xeon 933 (2.8V)	80526KZ933256 2.8V	processor
1431	207	Pentium III Xeon 933 (5/12V)	80526KZ933256 5/12V	processor
1432	207	Pentium III Xeon 1000 (2.8V)	80526KZ1000256 2.8V	processor
1433	207	Pentium III Xeon 1000 (5/12V)	80526KZ1000256 5/12V	processor
1434	207	Pentium III 533EB	80526PZ533256	processor
1435	207	Pentium III-S 1000	RK80530KZ001512	processor
1436	207	Pentium III 1133	RK80530PZ006256	processor
1437	207	Pentium III-S 1133	RK80530KZ006512	processor
1438	207	Pentium III 1200	RK80530PZ009256	processor
1439	207	Pentium III-S 1266	RK80530KZ012512	processor
1440	207	Pentium III 1333	RK80530PZ014256	processor
1441	207	Pentium III 1400	RK80530PZ017256	processor
1442	207	Pentium III-S 1400	RK80530KZ017512	processor
1443	207	Pentium III 800EB	RB80533PZ800256	processor
1444	207	Pentium III 866	RK80533PZ866256	processor
1445	207	Pentium III 933	RK80533PZ933256	processor
1446	207	Pentium III 1000EB	RK80533PZ001256	processor
1447	207	Pentium III 1133	RK80533PZ006256	processor
1448	207	Pentium 4 1.4	80528PC017G0K	processor
1449	207	Pentium III 550E	80526PY550256	processor
1450	207	Pentium III 600E	80526PY600256	processor
1451	207	Pentium III 600EB	80526PZ600256	processor
1452	207	Pentium III 650	80526PY650256	processor
1453	207	Pentium III 667	80526PZ667256	processor
1454	207	Pentium III 700	80526PY700256	processor
1455	207	Pentium III 750	80526PY750256	processor
1456	207	Pentium III 733	80526PZ733256	processor
1457	207	Pentium III 800E	80526PY800256	processor
1458	207	Pentium III 800EB	80526PZ800256	processor
1459	207	Pentium III 850	80526PY850256	processor
1460	207	Pentium III 866	80526PZ866256	processor
1461	207	Pentium III 933	80526PZ933256	processor
1462	207	Pentium III 1000E	80526PY1000256	processor
1463	207	Pentium III 1000EB	80526PZ1000256	processor
1464	207	Pentium III 533EB	RB80526PZ533256	processor
1465	207	Pentium III 550E	RB80526PY550256	processor
1466	207	Pentium III 600E	RB80526PY600256	processor
1467	207	Pentium III 600EB	RB80526PZ600256	processor
1468	207	Pentium III 650	RB80526PY650256	processor
1469	207	Pentium III 667	RB80526PZ667256	processor
1470	207	Pentium III 700	RB80526PY700256	processor
1471	207	Pentium III 733	RB80526PZ733256	processor
1472	207	Pentium III 750	RB80526PY750256	processor
1473	207	Pentium III 800E	RB80526PY800256	processor
1474	207	Pentium III 800EB	RB80526PZ800256	processor
1475	207	Pentium III 850	RB80526PY850256	processor
1476	207	Pentium III 866	RB80526PZ866256	processor
1477	207	Pentium III 866	RK80526PZ866256	processor
1478	207	Pentium III 900	RB80526PY900256	processor
1479	207	Pentium III 933	RB80526PZ933256	processor
1480	207	Pentium III 933	RK80526PZ933256	processor
1481	207	Pentium III 1000E	RB80526PY001256	processor
1482	207	Pentium III 1000EB	RB80526PZ001256	processor
1483	207	Pentium III 1000EB	RK80526PZ001256	processor
1484	207	Pentium III 1100	RB80526PY005256	processor
1485	207	Pentium III 1133	RK80526PZ006256	processor
1486	207	Celeron 566	RB80526RX566128	processor
1487	207	Celeron 600	RB80526RX600128	processor
1488	207	Celeron 633	RB80526RX633128	processor
1489	207	Celeron 667	RB80526RX667128	processor
1490	207	Celeron 700	RB80526RX700128	processor
1491	207	Celeron 733	RB80526RX733128	processor
1492	207	Celeron 766	RB80526RX766128	processor
1493	207	Celeron 800	RB80526RY800128	processor
1494	207	Celeron 850	RB80526RY850128	processor
1495	207	Celeron 900	RB80526RY900128	processor
1496	207	Celeron 950	RB80526RY950128	processor
1497	207	Celeron 1000	RB80526RY001128	processor
1498	207	Celeron 1100	RB80526RY005128	processor
1499	207	Celeron 1000A	RK80530RY001256	processor
868	207	Celeron 900A	RK80530RY900256	processor
1500	207	Celeron 1100A	RK80530RY005256	processor
1501	207	Celeron 1200	RK80530RY009256	processor
1502	207	Celeron 1300	RK80530RY013256	processor
1503	207	Celeron 1400	RK80530RY017256	processor
1504	207	Celeron 1500	RK80530RY021256	processor
1505	207	Pentium 4 1.5	80528PC021G0K	processor
1506	207	Pentium 4 1.6	RN80528PC025G0K	processor
1507	207	Pentium 4 1.7	RN80528PC029G0K	processor
1508	207	Pentium 4 1.8	RN80528PC033G0K	processor
1509	207	Pentium 4 1.9	RN80528PC037G0K	processor
1510	207	Pentium 4 2.0	RN80528PC041G0K	processor
1511	207	Pentium 4 1.4	RK80531PC017G0K	processor
1512	207	Pentium 4 1.6	RK80531PC025G0K	processor
1513	207	Pentium 4 1.7	RK80531PC029G0K	processor
1514	207	Pentium 4 1.8	RK80531PC033G0K	processor
1515	207	Pentium 4 1.9	RK80531PC037G0K	processor
1516	207	Pentium 4 2.0	RK80531PC041G0K	processor
1517	207	Celeron 1.6	RK80531RC025128	processor
1631	207	387	A80387-33	coprocessor
1518	207	Celeron 1.7	RK80531RC029128	processor
1519	207	Celeron 1.8	RK80531RC033128	processor
1520	207	Celeron 1.9	RK80531RC037128	processor
1521	207	Celeron 2.0	RK80531RC041128	processor
1522	207	Pentium 4 1.6A	RK80532PC025512	processor
1523	207	Pentium 4 1.8A	RK80532PC033512	processor
1524	207	Pentium 4 1.9A	RK80532PC037512	processor
1525	207	Pentium 4 2.0A	RK80532PC041512	processor
1526	207	Pentium 4 2.2	RK80532PC049512	processor
1527	207	Pentium 4 2.4	RK80532PC056512	processor
1528	207	Pentium 4 2.5	RK80532PC060512	processor
1529	207	Pentium 4 2.6	RK80532PC064512	processor
1530	207	Pentium 4 2.8	RK80532PC072512	processor
1531	207	Pentium 4 3.0	RK80532PC080512	processor
1532	207	Pentium 4 2.26	RK80532PE051512	processor
1533	207	Pentium 4 2.4B	RK80532PE056512	processor
1534	207	Pentium 4 2.53	RK80532PE061512	processor
1535	207	Pentium 4 2.66	RK80532PE067512	processor
1536	207	Pentium 4 2.8B	RK80532PE072512	processor
1537	207	Pentium 4 HT 3.06	RK80532PE083512	processor
1538	207	Pentium 4 HT 2.4C	RK80532PG056512	processor
1539	207	Pentium 4 HT 2.8C	RK80532PG072512	processor
1540	207	Pentium 4 HT 3.0C	RK80532PG080512	processor
1541	207	Pentium 4 HT 3.2C	RK80532PG088512	processor
1542	207	Pentium 4 HT 3.4C	RK80532PG096512	processor
1543	207	Celeron 1.8	RK80532RC025128	processor
1544	207	Celeron 2.0	RK80532RC041128	processor
1545	207	Celeron 2.1	RK80532RC045128	processor
760	27	Am486 DX4-120	A80486DX4-120NV8T	processor
743	27	Am486 DX2-66	A80486DX2-66SV8B	processor
1547	207	Celeron 2.2	RK80532RC049128	processor
1548	207	Celeron 2.3	RK80532RC052128	processor
1549	207	Celeron 2.4	RK80532RC056128	processor
1550	207	Celeron 2.5	RK80532RC060128	processor
1551	207	Celeron 2.6	RK80532RC064128	processor
1552	207	Celeron 2.7	RK80532RC068128	processor
1553	207	Celeron 2.8	RK80532RC072128	processor
922	207	Pentium 4 Extreme Edition 3.2	RK80532PG0882M	processor
1554	207	Pentium 4 Extreme Edition 3.4	RK80532PG0962M	processor
1555	207	Pentium 4 Extreme Edition 3.4	JM80532PG0962M	processor
1556	207	Pentium 4 2.26A	RK80546PE051512	processor
1557	207	Pentium 4 2.66A	RK80546PE0671M	processor
1558	207	Pentium 4 2.8A	RK80546PE0721M	processor
1559	207	Pentium 4 HT 3.0E	RK80546PG0801M	processor
1560	207	Pentium 4 HT 3.2E	RK80546PG0881M	processor
1561	207	Pentium 4 HT 3.2E (x86-64)	RK80546PG0881M	processor
1562	207	Pentium 4 HT 3.4E	RK80546PG0961M	processor
1563	207	Pentium 4 HT 3.4E (x86-64)	RK80546PG0961M	processor
1564	207	Pentium 4 505	JM80547PE0671M	processor
1565	207	Pentium 4 505J	JM80547PE0671M	processor
1566	207	Pentium 4 506	JM80547PE0671MN	processor
1574	207	Pentium 4 510	B80547PE0721M	processor
1575	207	Pentium 4 510J	JM80547PE0721M	processor
1576	207	Pentium 4 511	JM80547PE0721MN	processor
1577	207	Pentium 4 515	JM80547PE0771M	processor
1578	207	Pentium 4 515J	JM80547PE0771M	processor
1579	207	Pentium 4 516	JM80547PE0771MN	processor
1580	207	Pentium 4 517	HH80547PE0771MM	processor
1581	207	Pentium 4 519	JM80547PE0831M	processor
1582	207	Pentium 4 519J	JM80547PE0831M	processor
1583	207	Pentium 4 519K	JM80547PE0831MN	processor
1584	207	Pentium 4 524	HH80547PE0831MM	processor
1585	207	Pentium 4 520J	JM80547PG0721M	processor
1586	207	Pentium 4 521	JM80547PG0721MM	processor
1587	207	Pentium 4 530	JM80547PG0801M	processor
1588	207	Pentium 4 530J	JM80547PG0801M	processor
1589	207	Pentium 4 531	JM80547PG0801MM	processor
1591	207	Pentium 4 540J	JM80547PG0881M	processor
1592	207	Pentium 4 541	JM80547PG0881MM	processor
1593	207	Pentium 4 550 (04A)	JM80547PG0961M	processor
1594	207	Pentium 4 550 (04B)	JM80547PG0961M	processor
1595	207	Pentium 4 550J (04A)	JM80547PG0961M	processor
1596	207	Pentium 4 550J (04B)	JM80547PG0961M	processor
1597	207	Pentium 4 551 (04A)	JM80547PG0961MM	processor
1598	207	Pentium 4 551 (04B)	JM80547PG0961MM	processor
1599	207	Pentium 4 560	JM80547PG1041M	processor
1600	207	Pentium 4 560J	JM80547PG1041M	processor
1601	207	Pentium 4 561	JM80547PG1041MM	processor
1602	207	Pentium 4 570	JM80547PG1121M	processor
1603	207	Pentium 4 570J	JM80547PG1121M	processor
1604	207	Pentium 4 571	JM80547PG1121MM	processor
1605	207	Pentium 4 620	JM80547PG0722MM	processor
1606	207	Pentium 4 630	JM80547PG0802MM	processor
1607	207	Pentium 4 640	JM80547PG0882MM	processor
1608	207	Pentium 4 650	JM80547PG0962MM	processor
1609	207	Pentium 4 660	JM80547PG1042MM	processor
1610	207	Pentium 4 662 (04B)	HH80547PG1042MH	processor
1611	207	Pentium 4 662 (04A)	HH80547PG1042MP	processor
1612	207	Pentium 4 670	JM80547PG1122MM	processor
1613	207	Pentium 4 672	HH80547PG1122MH	processor
969	207	8087	C8087	coprocessor
1614	207	8087	C8087-1	coprocessor
1615	207	8087	C8087-2	coprocessor
1616	207	287	D80287-8	coprocessor
1617	207	287	D80287-10	coprocessor
1618	207	287	D80C287A-12	coprocessor
1620	207	i287XL	C80287XL	coprocessor
1621	207	i287XL	C80287XL	coprocessor
1622	207	i287XL	C80287XL	coprocessor
1623	207	i287XLT	N80287XLT	coprocessor
1624	207	i287XLT	N80287XLT	coprocessor
1625	207	i287XLT	N80287XLT	coprocessor
1626	207	i287XLT	N80287XLT	coprocessor
1627	207	i287XLT	N80287XLT	coprocessor
1632	207	i387SX	N80387SX-20	coprocessor
1633	207	i387SX	N80387SX-25	coprocessor
1634	207	i387SX	N80387SX-33	coprocessor
1635	121	FasMath	CX-83D87-20-GP	coprocessor
1636	121	FasMath	CX-83D87-25-GP	coprocessor
1637	121	FasMath	CX-83D87-33-GP	coprocessor
1638	121	FasMath	CX-83D87-40-GP	coprocessor
1639	121	FasMath	CX-83S87-20-JP	coprocessor
1640	121	FasMath	CX-83S87-25-JP	coprocessor
1641	121	FasMath	CX-83S87-33-JP	coprocessor
1642	121	FasMath	CX-83S87-40-JP	coprocessor
980	497	3C87	3C87-16	coprocessor
1643	497	3C87	3C87-20	coprocessor
1645	497	3C87	3C87-25	coprocessor
1646	497	3C87	3C87-33	coprocessor
1647	497	3C87	3C87-40	coprocessor
1648	207	Celeron D 315	RK80546RE051256	processor
1649	207	Celeron D 320	RK80546RE056256	processor
1650	207	Celeron D 325	RK80546RE061256	processor
1651	207	Celeron D 330	RK80546RE067256	processor
1652	207	Celeron D 335	RK80546RE072256	processor
1653	207	Celeron D 340	RK80546RE077256	processor
1654	207	Celeron D 345	RK80546RE083256	processor
1655	207	Celeron D 350	RK80546RE088256	processor
1656	207	Pentium 4 631 (06)	HH80552PG0802M	processor
1657	207	Pentium 4 641 (05A)	HH80552PG0882M	processor
1658	207	Pentium 4 641 (06)	HH80552PG0882M	processor
1659	207	Pentium 4 651 (05A)	HH80552PG0962M	processor
1660	207	Pentium 4 651 (06)	HH80552PG0962M	processor
1661	207	Pentium 4 661	HH80552PG1042M	processor
1662	207	Celeron D 325J	JM80547RE061256	processor
1663	207	Celeron D 326	JM80547RE061CN	processor
1664	207	Celeron D 330J	JM80547RE067256	processor
1665	207	Celeron D 331	JM80547RE067CN	processor
1666	207	Celeron D 335J	JM80547RE072256	processor
1667	207	Celeron D 336	JM80547RE072CN	processor
1668	207	Celeron D 340J	JM80547RE077256	processor
1669	207	Celeron D 341	JM80547RE077CN	processor
1670	207	Celeron D 345J	JM80547RE083256	processor
1671	207	Celeron D 346	JM80547RE083CN	processor
1567	289	uPD72191	uPD72191D	coprocessor
1570	121	486SLC-40	Cx486SLC-40MP	processor
1569	121	486SLC-33	Cx486SLC-33MP	processor
1573	393	486SXLC-40	SXLC-40	processor
1571	393	486SXLC-33	SXLC-33	processor
1672	207	Celeron D 350J	JM80547RE088256	processor
1673	207	Celeron D 351	JM80547RE088CN	processor
1674	207	Celeron D 355	HH80547RE093CN	processor
1675	207	Celeron D 347 (05A)	HH80552RE083512	processor
1676	207	Celeron D 352 (06)	HH80552RE088512	processor
1677	207	Celeron D 352 (05A)	HH80552RE088512	processor
1678	207	Celeron D 356 (06)	HH80552RE093512	processor
1679	207	Celeron D 356 (05A)	HH80552RE093512	processor
1680	207	Celeron D 360	HH80552RE099512	processor
1681	207	Celeron D 365	HH80552RE104512	processor
1682	207	Pentium D 820	HH80551PG0722MN	processor
1590	207	Pentium 4 540	JM80547PG0881M	processor
1683	207	Pentium D 830	HH80551PG0802MN	processor
1684	207	Pentium D 840	HH80551PG0882MN	processor
1685	207	Pentium Extreme Edition 965	HH80553PH1094M	processor
1686	207	Pentium D 920	HH80553PG0724M	processor
1687	207	Pentium D 925	HH80553PG0804MN	processor
1688	207	Pentium D 930	HH80553PG0804M	processor
1689	207	Pentium D 935	HH80553PG0884MN	processor
1690	207	Pentium D 940 (05A)	HH80553PG0884M	processor
1691	207	Pentium D 940 (05B)	HH80553PG0884M	processor
1692	207	Pentium D 945	HH80553PG0964MN	processor
1693	207	Pentium D 950 (05A)	HH80553PG0964M	processor
1694	207	Pentium D 950 (05B)	HH80553PG0964M	processor
1695	207	Pentium D 960 (05B)	HH80553PG1044M	processor
1696	207	Pentium D 960 (05A)	HH80553PG1044M	processor
1697	207	Core 2 Duo E6320	HH80557PH0364M	processor
1698	207	Core 2 Duo E6400	HH80557PH0462M	processor
1699	207	Core 2 Duo E6420	HH80557PH0464M	processor
1700	207	Core 2 Duo E6540	HH80557PJ0534M	processor
1701	207	Core 2 Duo E6550	HH80557PJ0534MG	processor
1702	207	Core 2 Duo E6600	HH80557PH0564M	processor
1703	207	Core 2 Duo E6700	HH80557PH0674M	processor
1704	207	Core 2 Duo E6750	HH80557PJ0674MG	processor
1705	207	Core 2 Duo E6850	HH80557PJ0804MG	processor
1706	207	Core 2 Duo E4200	HH80557PG0252M	processor
1707	207	Core 2 Duo E4300	HH80557PG0332M	processor
1708	207	Core 2 Duo E4400	HH80557PG0412M	processor
1709	207	Core 2 Duo E4500	HH80557PG0492M	processor
1710	207	Core 2 Duo E4600	HH80557PG0562M	processor
1711	207	Core 2 Duo E4700	HH80557PG0642M	processor
1712	207	Core 2 Duo E7200	EU80571PH0613M	processor
1713	207	Core 2 Duo E7200 (LP)	EU80571AH0613M	processor
1714	207	Core 2 Duo E7300	EU80571PH0673M	processor
1715	207	Core 2 Duo E7400	AT80571PH0723M	processor
1716	207	Core 2 Duo E7400 (w/ VT-x)	AT80571PH0723ML	processor
1717	207	Core 2 Duo E7400 (LP)	AT80571AH0723M	processor
1718	207	Core 2 Duo E7500	AT80571PH0773M	processor
1719	207	Core 2 Duo E7500 (w/ VT-x)	AT80571PH0773ML	processor
1720	207	Core 2 Duo E7600	AT80571PH0833ML	processor
1721	207	Core 2 Duo E8190	EU80570PJ0676MN	processor
1722	207	Core 2 Duo E8290	EU80570PJ0736MN	processor
1723	207	Core 2 Duo E8300	EU80570AJ0736M	processor
1724	207	Core 2 Duo E8400	EU80570PJ0806M	processor
1725	207	Core 2 Duo E8500	EU80570PJ0876M	processor
1726	207	Core 2 Duo E8600	AT80570PJ0936M	processor
1727	207	Core 2 Extreme QX6800	HH80562PH0778M	processor
1728	207	Core 2 Extreme QX6850	HH80562XJ0808M	processor
1729	207	Core 2 Extreme QX9770	EU80569XL088NL	processor
1730	207	Core 2 Quad Q6600 (B3)	HH80562PH0568M	processor
1731	207	Core 2 Quad Q6400	HH80562PH0468M	processor
1732	207	Core 2 Quad Q6700	HH80562PH0678MK	processor
1733	207	Core 2 Quad Q9450S	EU80569AJ067N	processor
1734	207	Core 2 Quad Q8200	EU80580PJ0534MN	processor
1735	207	Core 2 Quad Q8200S	AT80580AJ0534MN	processor
1736	207	Core 2 Quad Q8300	AT80580PJ0604MN	processor
1737	207	Core 2 Quad Q8300 (w/ VT-x)	AT80580PJ0604ML	processor
1738	207	Core 2 Quad Q8400	AT80580PJ0674ML	processor
1739	207	Core 2 Quad Q8400S	AT80580AJ0674ML	processor
1740	207	Core 2 Quad Q9300	EU80580PJ0606M	processor
1741	207	Core 2 Quad Q9400	AT80580PJ0676M	processor
1742	207	Core 2 Quad Q9400S	AT80580AJ0676M	processor
1743	207	Core 2 Quad Q9500	AT80580PJ0736ML	processor
1744	207	Core 2 Quad Q9505	AT80580PJ0736MG	processor
1746	207	Core 2 Quad Q9550	EU80569PJ073N	processor
1747	207	Core 2 Quad Q9550S	AT80569AJ073N	processor
1748	207	Core 2 Quad Q9650	AT80569PJ080N	processor
1749	207	i487SX	A80487SX	coprocessor
1750	207	i487SX	A80487SX	coprocessor
1751	207	i487SX	A80487SX	coprocessor
1752	446	WTL4167	4167-033-GCD	coprocessor
1753	446	WTL3167	3167-020-GCU	coprocessor
1754	446	WTL3167	3167-025-GCU	coprocessor
1755	446	WTL3167	3167-033-GCU	coprocessor
1756	497	3C87SX	3C87SX-16	coprocessor
1757	497	3C87SX	3C87SX-20	coprocessor
1758	497	3C87SX	3C87SX-25	coprocessor
1759	497	3C87SX	3C87SX-33	coprocessor
1760	497	3C87SX	3C87SX-40	coprocessor
1761	497	4C87DLC	4C87DLC-33	coprocessor
1762	497	4C87DLC	4C87DLC-40	coprocessor
1763	497	XC87DLC	XC87DLC-33	coprocessor
1764	497	XC87SLC	XC87SLC-33	coprocessor
1765	118	Super Math	J38700DX	coprocessor
1766	118	Super Math	J38700DX-40	coprocessor
1767	521	Green Math	4C87DX-40	coprocessor
1768	521	Green Math	4C87SLC-40	coprocessor
1769	273	68881	MC68881RC12	coprocessor
1770	273	68881	MC68881RC16	coprocessor
1771	273	68881	MC68881RC20	coprocessor
1773	273	68882	MC68882RC16	coprocessor
1774	273	68882	MC68882FN16	coprocessor
1775	273	68882	MC68882FN20	coprocessor
1776	273	68882	MC68882RC20	coprocessor
1777	273	68882	MC68882FN25	coprocessor
1778	273	68882	MC68882RC25	coprocessor
1779	273	68882	MC68882FN33	coprocessor
1780	273	68882	MC68882RC33	coprocessor
1781	273	68882	XC68882RC40A	coprocessor
1782	273	68882	XC68882RC50A	coprocessor
1783	522	83S87	83S87-SX25	coprocessor
1784	121	387DX	387DX-25	coprocessor
1785	121	387DX+	387DX-40	coprocessor
970	121	Cx487DLC	Cx487DLC-33GP	coprocessor
1786	121	Cx87DLC	Cx87DLC-33QP	coprocessor
1787	121	FasMath	CX-83S87-16-KP	coprocessor
1788	524	Math-Co DX	US83C87 25	coprocessor
1789	524	Math-Co DX	US83C87 33	coprocessor
1790	524	Math-Co DX	US83C87 40	coprocessor
1791	524	Advanced Math Coprocessor DX/DLC	US83C87 40	coprocessor
1792	524	Advanced Math Coprocessor DX/DLC	US83C87-C 40	coprocessor
1793	524	Math-Co SX	US83S87 25	coprocessor
1794	524	Math-Co SX	US83S87 33	coprocessor
1795	524	Advanced Math Coprocessor SX/SLC	US83S87 33	coprocessor
1796	121	FasMath	CX-82S87-NP-SV	coprocessor
1797	121	FasMath	CX-82S87-NP-SV	coprocessor
1798	121	287XL	287XL	coprocessor
1799	121	287XL	287XL	coprocessor
1800	121	287XL	287XL	coprocessor
1801	121	287XL	287XL	coprocessor
1802	121	287XL	287XL	coprocessor
1803	121	287XL+	287XL+	coprocessor
1804	121	287XL+	287XL+	coprocessor
1805	121	287XL+	287XL+	coprocessor
1806	121	287XL+	287XL+	coprocessor
1807	121	287XL+	287XL+	coprocessor
1808	121	FasMath	CX-82S87-NP-SV	coprocessor
1809	121	FasMath	CX-82S87-NP-SV	coprocessor
1810	121	FasMath	CX-82S87-NP-SV	coprocessor
1811	497	2C87	2C87-8	coprocessor
1812	497	2C87	2C87-10	coprocessor
1813	497	2C87	2C87-12	coprocessor
1814	497	2C87	2C87-16	coprocessor
1816	497	2C87	2C87-25	coprocessor
1817	207	80C187	D80C18712	coprocessor
1818	207	80C187	D80C18716	coprocessor
1819	207	80C187	N80C18712	coprocessor
1820	207	80C187	N80C18716	coprocessor
1821	292	Nx587	Nx586 N / P	coprocessor
1822	292	Nx587	Nx586 N / P	coprocessor
1745	207	Core 2 Quad Q9505S	AT80580AJ0736MG	processor
1823	292	Nx586 P80	Nx586-P80	processor
1824	292	Nx586 P90	Nx586-P90	processor
1825	292	Nx586 P100	Nx586-P100	processor
1826	292	Nx586 PF100	Nx586-PF100	processor
1827	292	Nx586 P110	Nx586-P110	processor
1828	292	Nx586 PF110	Nx586-PF110	processor
1829	292	Nx586 P120	Nx586-P120	processor
1830	504	ZFx86	ZFx86BGA388	processor
1831	504	ZFx86	ZFx86BGA388	processor
1833	199	WinChip C6 225	C6-PSME225GA	processor
1834	199	WinChip C6 240	C6-PSME240GA	processor
1832	199	WinChip C6 200	C6-PSME200GA	processor
1835	199	WinChip 2 225	W2-3DEE225GSA	processor
1836	199	WinChip 2 240	W2-3DEE240GSA	processor
1837	199	WinChip 2A 200	W2A-3DEE200GTA	processor
1838	199	WinChip 2A 233	W2A-3DEE233GSA	processor
1839	199	WinChip 2A 266	W2A-3DEE266GSA	processor
1840	199	WinChip 2A 300	W2-3DEE240GSA	processor
1841	199	WinChip 2B 200	W2B-3DFK200BTA	processor
937	417	Cyrix III 466	Cyrix III-466MHz	processor
1842	417	Cyrix III 533	Cyrix III-533MHz	processor
1843	417	Cyrix III 550	Cyrix III-550MHz	processor
1844	417	Cyrix III 600	Cyrix III-600MHz	processor
1845	417	Cyrix III 600	Cyrix III-600MHz	processor
1846	417	Cyrix III 650	Cyrix III-650MHz	processor
1847	417	Cyrix III 667	Cyrix III-667MHz	processor
1848	417	Cyrix III 700	Cyrix III-700MHz	processor
1849	417	Cyrix III 733	Cyrix III-733MHz	processor
1850	417	Cyrix III 750	Cyrix III-750MHz	processor
1851	417	Cyrix III 800	Cyrix III-800MHz	processor
1852	417	C3 650A	C3-650AMHz	processor
1853	417	C3 667A	C3-667AMHz	processor
1854	417	C3 700A	C3-700AMHz	processor
1855	417	C3 733A	C3-733AMHz	processor
1856	417	C3 750A	C3-750AMHz	processor
1857	417	C3 800A	C3-800AMHz	processor
1859	417	C3 800A	C3-800AMHz	processor
1860	417	C3 800A	C3-800AMHz	processor
1861	417	C3 800A	C3-800AMHz	processor
1862	417	C3 850A	C3-850AMHz	processor
1863	417	C3 866A	C3-866AMHz	processor
1864	417	C3 866A	C3-866AMHz	processor
1865	417	C3 900A	C3-900AMHz	processor
1866	417	C3 933A	C3-933AMHz	processor
1867	417	C3 933A	C3-933AMHz	processor
1868	417	C3 1000A	C3-1.0AGHz	processor
1869	417	C3 1000A	C3-1.0AGHz	processor
1870	417	C3 1000A	C3-1.0AGHz	processor
1871	417	C3 1000A	C3-1.0AGHz	processor
1872	417	C3 1133A	C3-1.1AGHz	processor
1873	417	C3 1200A	C3-1.2AGHz	processor
1874	417	C3 1333A	C3-1.3AGHz	processor
1858	417	C3 800A	C3-800AMHz	processor
1976	121	MII 300	MII-300GP	processor
1901	273	68030	MC68030RC16C	processor
1902	273	68030	MC68030RC20	processor
1903	273	68030	MC68030RC25	processor
1904	273	68030	MC68030RC25C	processor
1905	273	68030	MC68030RC33	processor
1906	273	68030	MC68030RC33C	processor
1907	273	68030	MC68030RC40	processor
1908	273	68030	MC68030RC50	processor
1909	273	68030	MC68030RC50C	processor
1910	273	68EC030	MC68EC030RP25	processor
1911	273	68EC030	MC68EC030RP25C	processor
1912	273	68EC030	MC68EC030RP40	processor
1913	273	68EC030	MC68EC030RP40C	processor
1914	273	68030	MC68030FE16	processor
1915	273	68030	MC68030FE20	processor
1916	273	68030	MC68030FE25	processor
1917	273	68030	MC68030FE33	processor
1918	273	68EC030	MC68EC030FE40	processor
1919	273	68EC030	MC68EC030FE40C	processor
1920	273	68040	MC68040RC25	processor
1921	273	68040	MC68040RC33	processor
1922	273	68LC040	MC68LC040RC20B	processor
1923	273	68LC040	MC68LC040RC25	processor
1924	273	68LC040	MC68LC040RC33	processor
1925	273	68LC040	MC68LC040RC40	processor
1926	273	68EC040	MC68EC040RC20B	processor
1927	273	68EC040	MC68EC040RC25	processor
1928	273	68EC040	MC68EC040RC33	processor
1929	273	68EC040	MC68EC040RC40	processor
1930	273	68060	MC68060RC60	processor
1931	273	68060	MC68060RC66	processor
1932	273	68EC060	MC68EC060RC50	processor
1933	273	68EC060	MC68EC060RC66	processor
1934	273	68EC060	MC68EC060RC75	processor
1935	273	68EC060	MC68EC060RC60	processor
1936	273	68LC060	MC68LC060RC50	processor
1937	273	68LC060	MC68LC060RC66	processor
1938	273	68LC060	MC68LC060RC75	processor
1939	197	486BL3 25/75	50G3588	processor
1940	197	486BL3 20/60	03H4831	processor
1941	197	486SLC2-40	32G3672	processor
1942	197	486SLC2-66	50G6663	processor
1943	121	6x86 P90+	6x86-P90+GP	processor
1944	121	6x86 P100	6x86-P100GP	processor
1945	121	6x86 100	6x86-100GP	processor
1946	121	6x86 P120+	6x86-P120+GP	processor
1947	121	6x86 P133+	6x86-P133+GP	processor
1948	121	6x86 P150+	6x86-P150+GP	processor
1949	121	6x86 P166+	6x86-P166+GP	processor
1950	121	6x86 P200+	6x86-P200+GP	processor
1951	121	6x86L P120+	6x86L-P120+GP	processor
1952	121	6x86L PR120+	6x86L-PR120+GP	processor
1953	121	6x86L P133+	6x86L-P133+GP	processor
1954	121	6x86L PR150+	6x86L-PR150+GP	processor
1955	121	6x86L PR166+	6x86L-PR166+GP	processor
1956	121	6x86LV P166+	6x86LV-P166+GP	processor
1957	121	6x86L PR200+	6x86L-PR200+GP	processor
1958	121	6x86MX PR166	6x86MX-PR166	processor
1959	121	6x86MX PR166	6x86MX-PR166	processor
1960	121	6x86MX PR200	6x86MX-PR200	processor
1961	121	6x86MX PR200	6x86MX-PR200	processor
1962	121	6x86MX PR233	6x86MX-PR233	processor
1963	121	6x86MX PR233	6x86MX-PR233	processor
1964	121	6x86MX PR266	6x86MX-PR266	processor
1965	121	6x86MX PR266	6x86MX-PR266	processor
1966	121	6x86MX PR300	6x86MX-PR300	processor
1967	121	6x86MX PR300	6x86MX-PR300	processor
1968	121	6x86MX PR333	6x86MX-PR333	processor
1969	121	6x86MX PR333	6x86MX-PR333	processor
804	121	MII 233	MII-233GP	processor
1970	121	MII 233	MII-233GP	processor
1971	121	MII 266	MII-266GP	processor
1972	121	MII 266	MII-266GP	processor
1973	121	MIIv 233	MII-233GP	processor
1974	121	MIIv 266	MII-266GP	processor
1975	121	MII 300	MII-300GP	processor
1977	121	MIIv 300	MII-300GP	processor
1978	121	MII 333	MII-333GP	processor
1979	121	MII 333	MII-333GP	processor
1980	121	MIIv 333	MII-333GP	processor
1981	121	MIIv 333	MII-333GP	processor
1982	121	MIIv 333	MII-333GP	processor
1983	121	MIIv 333 Mobile	MII-333GP	processor
1984	121	MII 350	MII-350GP	processor
1985	121	MII 366	MII-366GP	processor
1986	121	MIIv 366 Mobile	MII-366GP	processor
1987	121	MII 400	MII-400GP	processor
1988	121	MIIv 400	MII-400GP	processor
1989	121	MII 433	MII-433GP	processor
1990	121	MIIv 433	MII-433GP	processor
1991	121	MediaGX 120	GX-120BP	processor
1992	121	MediaGX 133	GX-133BP	processor
1993	121	MediaGX 150	GX-150BP	processor
1994	121	MediaGX 166	GX-166BP	processor
1995	121	MediaGXi 166	GXI-166BP	processor
1996	121	MediaGXi 180	GXI-180BP	processor
1997	121	MediaGXi 200	GXI-200BP	processor
988	207	80286	R80286-12	processor
1998	27	Am286	80286-16	processor
2001	121	486DRx²20/40	Cx486DRx²20/40GP	processor
2002	121	486DRx²25/50	Cx486DRx²25/50GP	processor
2003	121	486DRx²33/66	Cx486DRx²33/66GP	processor
2004	121	486DLC-25	Cx486DLC-25GP	processor
2005	121	486DLC-40	Cx486DLC-40GP	processor
2006	121	486DRu²16/32	Cx486DRu²16/32GP	processor
2007	121	486DRu²20/40	Cx486DRu²20/40GP	processor
2008	121	486DRu²25/50	Cx486DRu²25/50GP	processor
2009	121	486SRx²16/32	Cx486SRx²16/32GP	processor
2010	121	486SRx²20/40	Cx486SRx²20/40GP	processor
2011	121	486SRx²25/50	Cx486SRx²25/50GP	processor
782	121	486SLC-20	Cx486SLC-20MP	processor
1027	207	Pentium 200	A80502200	processor
1024	207	Pentium 133	A80502133	processor
1006	207	Pentium Overdrive 133	PODP5V133	processor
2015	207	Pentium OverDrive 150	PODP3V150	processor
2016	207	Pentium OverDrive 166	PODP3V166	processor
2017	207	Pentium MMX OverDrive 166	PODPMT66X166	processor
2018	207	Pentium MMX OverDrive 180	PODPMT60X180	processor
2019	207	Pentium MMX OverDrive 200	PODPMT66X200	processor
2020	522	MP6 PR166	MP6441RPFE4-Q	processor
2021	522	MP6 PR266	MP6441DPFH4-Q	processor
2022	522	MP6 PR266	MP65RPAPH4-Q	processor
2023	522	MP6 PR366	MP65RPAPH5-DS	processor
814	207	Pentium Pro 150/256K	KB80521EX150 256K	processor
1004	207	Pentium II OverDrive 333/512K	PODP66X333	processor
1005	207	Pentium II OverDrive 300/512K	PODP66X333	processor
2024	121	5x86-80	5x86-80GP	processor
2025	121	5x86-133	5x86-133GP	processor
2026	197	5x86C-75	5x86-3V375GF	processor
1017	207	i486 SX 25	A80486SX-25	processor
2027	408	U5SD-SUPER25	U5SD-SUPER25	processor
2028	408	U5SD 486-40	U5SD 486-40	processor
2029	408	U5SX 486-40	U5SX 486-40	processor
1330	121	MediaGXm 200	GXm-200GP 2.2V	processor
2030	121	Cx486 DX2-50	Cx486DX2-50GP	processor
2033	121	Cx486 DX2-80	Cx486DX2-80GP	processor
2032	121	Cx486 S40 FasCache	Cx486S-40GP	processor
2031	121	Cx486 DX2-50 (WB)	Cx486DX2-50	processor
2034	121	Cx486 DX2-v50	Cx486DX2-V50GP	processor
2035	465	ST486DX4-V120	ST486DX4V12HS	processor
2036	121	Cx486 DX-v33	Cx486DX-V33QP	processor
1014	207	i486 DX2 66 (WB)	A80486DX2-66	processor
720	207	OverDrive 486DX2-50 (PGA169)	DX2ODP50	processor
729	207	OverDrive 486DX2-66 (PGA169)	ODP486DX-33	processor
795	207	OverDrive 486DX4-100 (PGA169)	DX4ODP100	processor
784	207	OverDrive 486SX2-66 (PGA169)	ODP486SX-33	processor
2037	207	80186-8	N80C186-8	processor
2038	207	80186-10	N80186-10	processor
2039	207	80186-12	N80C186-12	processor
2040	207	80186-16	N80C186-16	processor
2041	207	80186XL-10	N80C186XL10	processor
2042	207	80186XL-12	N80C186XL12	processor
2043	207	80186XL-16	N80C186XL16	processor
2044	207	80186XL-20	N80C186XL20	processor
2045	207	80186XL-25	N80C186XL25	processor
2046	207	80188-10	N80188-10	processor
2047	207	80188-12	N80C188-12	processor
2048	207	80188-16	N80C188-16	processor
2049	207	80188XL-10	N80C188XL10	processor
2050	207	80188XL-12	N80C188XL12	processor
2051	207	80188XL-16	N80C188XL-16	processor
2052	207	80188XL-20	N80C188XL20	processor
2053	207	80188XL-25	N80C188XL25	processor
2054	207	Celeron 430	HH80557RG033512	processor
2055	207	Celeron 440	HH80557RG041512	processor
2056	207	Celeron 450	HH80557RG049512	processor
2057	207	Celeron Dual-Core E1200	HH80557PG025D	processor
2058	207	Celeron Dual-Core E1400	HH80557PG041D	processor
2059	207	Celeron Dual-Core E1500	HH80557PG049D	processor
2060	207	Celeron Dual-Core E1600	HH80557PG056D	processor
2000	552	286	CS80C286-25	processor
2061	207	Celeron Dual-Core E3300	AT80571RG0601ML	processor
2062	207	Celeron Dual-Core E3400	AT80571RG0641ML	processor
2063	207	Celeron Dual-Core E3500	AT80571RG0681ML	processor
2064	207	Pentium Dual-Core E2160	HH80557PG0331M	processor
2065	207	Pentium Dual-Core E2180	HH80557PG0411M	processor
2066	207	Pentium Dual-Core E2200	HH80557PG0491M	processor
2067	207	Pentium Dual-Core E2220	HH80557PG0561M	processor
2068	207	Pentium Dual-Core E2210	EU80571RG0491M	processor
2069	207	Pentium Dual-Core E5300	AT80571PG0642M	processor
3096	161	\N	82EC100G	chipsetpart
2070	207	Pentium Dual-Core E5300 (w/ VT-x)	AT80571PG0642ML	processor
2072	207	Pentium Dual-Core E5400	AT80571PG0682M	processor
2073	207	Pentium Dual-Core E5400 (w/ VT-x)	AT80571PG0682ML	processor
2074	207	Pentium Dual-Core E5500	AT80571PG0722ML	processor
2076	207	Pentium Dual-Core E5700	AT80571PG0802ML	processor
2077	207	Pentium Dual-Core E5800	AT80571PG0882ML	processor
2078	207	Pentium Dual-Core E6300	AT80571PH0722ML	processor
2079	207	Pentium Dual-Core E6500	AT80571PH0772ML	processor
2080	207	Pentium Dual-Core E6500K	AT80571XH0772ML	processor
2081	207	Pentium Dual-Core E6600	AT80571PH0832ML	processor
2082	207	Pentium Dual-Core E6700	AT80571PH0882ML	processor
2083	207	Pentium Dual-Core E6800	AT80571PH0932ML	processor
2084	27	Athlon 64 3000+	ADA3000AEP4AP	processor
2085	27	Athlon 64 3200+	ADA3200AEP5AP	processor
2086	27	Athlon 64 3200+	ADA3200AEP4AP	processor
2087	27	Athlon 64 3400+	ADA3400AEP4AP	processor
2088	27	Athlon 64 3400+	ADA3400AEP5AP	processor
2089	27	Athlon 64 3600+	ADA3600AEP5AR	processor
2090	27	Athlon 64 3700+	ADA3700AEP5AP	processor
2091	27	Athlon 64 3800+	ADA3800DEP4AS	processor
2092	27	Athlon 64 4000+	ADA4000DEP5AS	processor
2093	27	Athlon 64 FX-53	ADAFX53CEP5AT	processor
2094	27	Athlon 64 2800+	ADA2800AEP4AX	processor
2095	27	Athlon 64 3000+	ADA3000AEP4AX	processor
2096	27	Athlon 64 3000+	ADA3000DEP4AW	processor
2097	27	Athlon 64 3200+	ADA3200AEP4AX	processor
2098	27	Athlon 64 3200+	ADA3200DEP4AW	processor
2099	27	Athlon 64 3300+	ADA3300AEP3AX	processor
2100	27	Athlon 64 3400+	ADA3400AEP4AX	processor
2101	27	Athlon 64 3400+	ADA3400DEP4AZ	processor
2102	27	Athlon 64 3500+	ADA3500DEP4AW	processor
2103	27	Athlon 64 3800+	ADA3800DEP4AW	processor
2104	27	Athlon 64 3000+	ADA3000DIK4BI	processor
2105	27	Athlon 64 3200+	ADA3200DIK4BI	processor
2106	27	Athlon 64 3500+	ADA3500DIK4BI	processor
2107	27	Athlon 64 1500+	ADC1500B2X4BX	processor
2108	27	Athlon 64 3000+	ADA3000AKK4BX	processor
2109	27	Athlon 64 3000+	ADA3000AIK4BX	processor
2110	27	Athlon 64 3200+	ADA3200AIO4BX	processor
2111	27	Athlon 64 3400+	ADA3400AIK4BO	processor
2112	27	Sempron 3100+	SDA3100AIP3AX	processor
2115	27	Sempron 2800+ (w/ SSE3)	SDA2800AIO3BO	processor
2114	27	Sempron 2800+	SDA2800AIO3BA	processor
2117	27	Sempron 2600+	SDA2600AIO2BA	processor
2118	27	Sempron 2600+ (w/ SSE3)	SDA2600AIO2BO	processor
2116	27	Sempron 2800+ (w/ SSE3 & AMD64)	SDA2800AIO3BX	processor
2119	27	Sempron 2600+ (w/ SSE3 & AMD64)	SDA2600AIO2BX	processor
2120	27	Sempron 3000+	SDA3000AIO2BA	processor
2121	27	Sempron 3000+ (w/ SSE3)	SDA3000AIO2BO	processor
2122	27	Sempron 3000+ (w/ SSE3 & AMD64)	SDA3000AIO2BX	processor
2123	27	Sempron 3100+	SDA3100AIO3BA	processor
2124	27	Sempron 3100+ (w/ SSE3)	SDA3100AIO3BO	processor
2125	27	Sempron 3100+ (w/ SSE3 & AMD64)	SDA3100AIO3BX	processor
2126	27	Sempron 3300+	SDA3300AIO2BA	processor
2127	27	Sempron 3300+ (w/ SSE3)	SDA3300AIO2BO	processor
3173	107	\N	82C596A	chipsetpart
2128	27	Sempron 3300+ (w/ SSE3 & AMD64)	SDA3300AIO2BX	processor
2129	27	Sempron 3400+ (w/ SSE3 & AMD64)	SDA3400AIO3BX	processor
2113	27	Sempron 2500+ (w/ SSE3 & AMD64)	SDA2500AIO3BX	processor
2130	27	Sempron 3000+	SDA3000DIO2BP	processor
2131	27	Sempron 3000+ (w/ AMD64)	SDA3000DIO2BW	processor
2132	27	Sempron 3200+	SDA3200DIO3BP	processor
2133	27	Sempron 3400+ (w/ AMD64)	SDA3400DIO2BW	processor
2134	27	Sempron 3500+ (w/ AMD64)	SDA3500DIO3BW	processor
2135	27	Athlon 64 3000+	ADA3000DAA4BP	processor
2136	27	Athlon 64 3200+	ADA3200DAA4BP	processor
2137	27	Athlon 64 3400+	ADA3400DAA4BY	processor
2138	27	Athlon 64 3500+	ADA3500DAA4BP	processor
2139	27	Athlon 64 3800+	ADA3800DAA4BP	processor
2140	27	Athlon 64 3200+	ADA3200DKA4CG	processor
2141	27	Athlon 64 3500+	ADA3500DKA4CG	processor
2142	27	Athlon 64 3500+	ADA3500DAA4BN	processor
2143	27	Athlon 64 3700+	ADA3700DAA5BN	processor
2144	27	Athlon 64 4000+	ADA4000DAA5BN	processor
2145	27	Athlon 64 3700+	ADA3700DKA5CF	processor
2146	27	Athlon 64 4000+	ADA4000DKA5CF	processor
2147	27	Athlon 64 FX-57	ADAFX57DAA5BN	processor
2148	27	Athlon 64 FX-53	ADAFX53DEP5AS	processor
2149	27	Athlon 64 FX-55	ADAFX55DEI5AS	processor
2150	27	Athlon 64 X2 3600+	ADA3600DAA4BV	processor
2151	27	Athlon 64 X2 3800+	ADA3800DAA5BV	processor
2152	27	Athlon 64 X2 4200+	ADA4200DAA5BV	processor
2153	27	Athlon 64 X2 4600+	ADA4600DAA5BV	processor
2154	27	Athlon 64 X2 4200+	ADA4200DAA5CD	processor
2155	27	Athlon 64 X2 4400+ (110W)	ADA4400DAA6CD	processor
2157	27	Athlon 64 X2 4400+ (89W)	ADV4400DAA6CD	processor
2158	27	Athlon 64 X2 4600+	ADA4600DAA5CD	processor
2159	27	Athlon 64 X2 4800+	ADA4800DAA6CD	processor
2160	27	Athlon 64 FX-60	ADAFX60DAA6CD	processor
2161	27	Opteron 146	OSA146DAA5BN	processor
2163	27	Opteron 148	OSA148DAA5BN	processor
2164	27	Opteron 150	OSA150DAA5BN	processor
2165	27	Opteron 152	OSA152DAA5BN	processor
2166	27	Opteron 154	OSA154DAA5BN	processor
2167	27	Opteron 156	OSA156DAA5BN	processor
2168	27	Opteron 165	OSA165DAA6CD	processor
2169	27	Opteron 170	OSA170DAA6CD	processor
2170	27	Opteron 175	OSA175DAA6CD	processor
2171	27	Opteron 180	OSA180DAA6CD	processor
2172	27	Opteron 185	OSA185DAA6CD	processor
2174	27	Opteron 190	OSA190DAA6CD	processor
2175	27	Athlon 64 3200+	ADA3200IAA4CN	processor
2176	27	Athlon 64 3500+	ADA3500IAA4CN	processor
2177	27	Athlon 64 3800+	ADA3800IAA4CN	processor
2178	27	Athlon 64 4000+	ADA4000IAA4DH	processor
2179	27	Athlon 64 LE-1600	ADH1600IAA5DH	processor
2180	27	Athlon 64 LE-1620	ADH1620IAA5DH	processor
2181	27	Athlon 64 LE-1640	ADH1640IAA5DH	processor
2182	27	Athlon 64 3500+ (SFF)	ADD3500IAA4CN	processor
2183	27	Athlon 64 2650e	ADG2650IAV4DP	processor
2184	27	Athlon 64 2850e	ADJ2850IAA4DP	processor
2185	27	Athlon 64 3500+	ADH3500IAA4DE	processor
2186	27	Athlon 64 3800+	ADH3800IAA4DE	processor
2187	27	Athlon LE-1640B	ADH164BIAA4DP	processor
2188	27	Athlon LE-1640	ADH1640IAA4DP	processor
2189	27	Athlon LE-1660	ADH1660IAA4DP	processor
2191	27	Athlon 64 2000+	ADF2000IAV4DRE	processor
2192	27	Athlon 64 2600+	ADG2600IAV4DRE	processor
2193	27	Athlon 64 3100+	ADS3100IAR4DRE	processor
2194	27	Sempron 3000+	SDA3000IAA3CN	processor
2195	27	Sempron 3200+	SDA3200IAA2CN	processor
2196	27	Sempron 3400+	SDA3400IAA3CN	processor
2197	27	Sempron 3500+	SDA3500IAA2CN	processor
2198	27	Sempron 3600+	SDA3600IAA3CN	processor
2199	27	Sempron 3800+	SDA3800IAA3CN	processor
2200	27	Sempron 3000+ (SFF)	SDD3000IAA3CN	processor
2201	27	Sempron 3200+ (SFF)	SDD3200IAA2CN	processor
2202	27	Sempron 3400+ (SFF)	SDD3400IAA3CN	processor
2203	27	Sempron 3500+ (SFF)	SDD3500IAA2CN	processor
2204	27	Sempron LE-1100	SDH1100IAA3DE	processor
2205	27	Sempron LE-1150	SDH1150IAA3DE	processor
2206	27	Sempron LE-1200	SDH1200IAA4DE	processor
2207	27	Sempron LE-1250	SDH1250IAA4DP	processor
2208	27	Sempron LE-1300	SDH1300IAA4DP	processor
2209	27	Sempron X2 2100	SDO2100IAA4DD	processor
2210	27	Sempron X2 2200	SDO2200IAA4DO	processor
2211	27	Sempron X2 2300	SDO2300IAA4DO	processor
2212	27	Sempron 130	SDX130HBK12GQ	processor
2213	27	Sempron 140	SDX140HBK13GQ	processor
2215	27	Sempron 145	SDX145HBK13GM	processor
2216	27	Sempron 150	SDX150HBK13GM	processor
2217	27	Sempron 180	SDX180HDK22GM	processor
2218	27	Sempron 190	SDX190HDK22GM	processor
2219	27	Mobile Sempron 2600+	SMN2600BIX2AY	processor
2220	27	Mobile Sempron 2800+	SMN2800BIX3AY	processor
2221	27	Mobile Sempron 3000+	SMN3000BIX2AY	processor
1220	27	Mobile K8 Athlon XP-M 3100+	AHN3100BIX3X	processor
2222	27	Mobile Sempron 2600+ (LP)	SMS2600BOX2LA	processor
2223	27	Mobile Sempron 2800+ (LP)	SMS2800BOX3LA	processor
2224	27	Mobile Sempron 2600+	SMN2600BIX2BA	processor
2225	27	Mobile Sempron 2800+	SMN2800BIX3BA	processor
2226	27	Mobile Sempron 3000+	SMN3000BIX2BA	processor
2227	27	Mobile Sempron 3100+	SMN3100BIX3BA	processor
2228	27	Mobile Sempron 3300+	SMN3300BIX2BA	processor
3057	403	\N	TH4100	chipsetpart
2229	27	Mobile Sempron 2600+ (LP)	SMS2600BOX2LB	processor
2230	27	Mobile Sempron 2800+ (LP)	SMS2800BOX3LB	processor
2232	27	Mobile Sempron 3100+ (LP)	SMS3100BOX3LB	processor
2233	27	Mobile Sempron 3000+	SMN3000BIX2BX	processor
2231	27	Mobile Sempron 3000+ (LP)	SMS3000BOX2LB	processor
2234	27	Mobile Sempron 3100+	SMN3100BIX3BX	processor
2235	27	Mobile Sempron 3300+	SMN3300BIX2BX	processor
2236	27	Mobile Sempron 3400+	SMN3400BIX3BX	processor
2237	27	Mobile Sempron 3600+	SMN3600BIX2BX	processor
2238	27	Mobile Sempron 2800+ (LP)	SMS2800BQX3LF	processor
2239	27	Mobile Sempron 3000+ (LP)	SMS3000BQX2LE	processor
2240	27	Mobile Sempron 3100+ (LP)	SMS3100BQX3LE	processor
2241	27	Mobile Sempron 3300+ (LP)	SMS3300BQX2LE	processor
2242	27	Mobile Sempron 3400+ (LP)	SMS3400BQX3LE	processor
2243	27	Turion 64 ML-30	TMDML30BKX5LD	processor
2244	27	Turion 64 ML-32	TMDML32BKX4LD	processor
2245	27	Turion 64 ML-34	TMDML34BKX5LD	processor
2246	27	Turion 64 ML-37	TMDML37BKX5LD	processor
2247	27	Turion 64 ML-40	TMDML40BKX5LD	processor
2248	27	Turion 64 ML-42	TMDML42BKX4LD	processor
2250	27	Turion 64 ML-44	TMDML44BKX5LD	processor
2251	27	Turion 64 MT-28	TMSMT28BQX4LD	processor
2252	27	Turion 64 MT-30	TMSMT30BQX5LD	processor
2253	27	Turion 64 MT-32	TMSMT32BQX4LD	processor
2254	27	Turion 64 MT-34	TMSMT34BQX5LD	processor
2255	27	Turion 64 MT-37	TMSMT37BQX5LD	processor
2256	27	Turion 64 MT-40	TMSMT40BQX5LD	processor
2257	27	Mobile Athlon 64 2800+	AMA2800BEX5AP	processor
2258	27	Mobile Athlon 64 3000+	AMA3000BEX5AP	processor
2259	27	Mobile Athlon 64 3200+	AMA3200BEX5AP	processor
2260	27	Mobile Athlon 64 3400+	AMA3400BEX5AP	processor
2261	27	Mobile Athlon 64 3700+	AMA3700BEX5AP	processor
2262	27	Mobile Athlon 64 2800+	AMN2800BIX5AP	processor
2263	27	Mobile Athlon 64 3000+	AMN3000BIX5AP	processor
2264	27	Mobile Athlon 64 3200+	AMN3200BIX5AP	processor
2265	27	Mobile Athlon 64 3400+	AMN3400BIX5AR	processor
2266	27	Mobile Athlon 64 2700+ (LP)	AMD2700BQX4AR	processor
2267	27	Mobile Athlon 64 2800+	AMA2800BEX4AX	processor
2268	27	Mobile Athlon 64 2700+ (LP)	AMD2700BQX4AX	processor
2269	27	Mobile Athlon 64 2800+ (LP)	AMD2800BQX4AX	processor
2270	27	Mobile Athlon 64 3000+ (LP)	AMD3000BQX4AX	processor
2271	27	Mobile Athlon 64 2700+ (LP)	AMD2700BKX4LB	processor
2272	27	Mobile Athlon 64 2800+ (LP)	AMD2800BKX4LB	processor
2273	27	Mobile Athlon 64 3000+ (LP)	AMD3000BKX4LB	processor
2274	27	Mobile Athlon 64 3000+	AMN3000BKX5BU	processor
3098	161	\N	82EC810	chipsetpart
2275	27	Mobile Athlon 64 3200+	AMN3200BKX5BU	processor
2276	27	Mobile Athlon 64 3400+	AMN3400BKX5BU	processor
2277	27	Mobile Athlon 64 3700+	AMN3700BKX5BU	processor
2278	27	Mobile Athlon 64 4000+	AMN4000BKX5BU	processor
2279	27	Athlon 64 X2 4000+	ADA4000IAA6CS	processor
2280	27	Athlon 64 X2 4200+	ADA4200IAA5CU	processor
2281	27	Athlon 64 X2 4400+	ADA4400IAA6CS	processor
2282	27	Athlon 64 X2 4600+	ADA4600IAA5CU	processor
2283	27	Athlon 64 X2 4800+	ADA4800IAA6CS	processor
2284	27	Athlon 64 X2 5000+	ADA5000IAA5CS	processor
2285	27	Athlon 64 X2 5200+	ADA5200IAA6CS	processor
2286	27	Athlon 64 X2 5400+	ADA5400IAA5CZ	processor
2287	27	Athlon 64 X2 5600+	ADA5600IAA6CZ	processor
2288	27	Athlon 64 X2 6000+ (125W)	ADX6000IAA6CZ	processor
2289	27	Athlon 64 X2 6000+ (89W)	ADA6000IAA6CZ	processor
2290	27	Athlon 64 X2 6400+ Black Edition	ADX6400IAA6CZ	processor
2291	27	Athlon 64 X2 3600+ (EE)	ADO3600IAA4CU	processor
2292	27	Athlon 64 X2 3800+ (EE)	ADO3800IAA5CS	processor
2293	27	Athlon 64 X2 4000+ (EE)	ADO4000IAA6CS	processor
2294	27	Athlon 64 X2 4200+ (EE)	ADO4200IAA5CU	processor
2295	27	Athlon 64 X2 4400+ (EE)	ADO4400IAA6CS	processor
2296	27	Athlon 64 X2 4600+ (EE)	ADO4600IAA5CS	processor
2297	27	Athlon 64 X2 4800+ (EE)	ADO4800IAA6CS	processor
2298	27	Athlon 64 X2 5000+ (EE)	ADO5000IAA5CZ	processor
2299	27	Athlon 64 X2 5200+ (EE)	ADO5200IAA6CZ	processor
2300	27	Athlon 64 X2 3800+ (SFF)	ADD3800IAA5CU	processor
2301	27	Athlon 64 X2 3600+	ADO3600IAA5DD	processor
2302	27	Athlon 64 X2 4000+	ADO4000IAA5DD	processor
2303	27	Athlon 64 X2 4200+	ADO4200IAA5DD	processor
2304	27	Athlon 64 X2 4400+	ADO4400IAA5DD	processor
2305	27	Athlon 64 X2 4600+	ADO4600IAA5DO	processor
2306	27	Athlon 64 X2 4800+	ADO4800IAA5DD	processor
2307	27	Athlon 64 X2 5000+	ADO5000IAA5DD	processor
2308	27	Athlon 64 X2 5000+ Black Edition	ADO5000IAA5DS	processor
2309	27	Athlon 64 X2 5200+	ADO5200IAA5DD	processor
2310	27	Athlon 64 X2 5400+	ADO5400IAA5DO	processor
2311	27	Athlon 64 X2 5400+ Black Edition	ADO5400IAA5DS	processor
2312	27	Athlon 64 X2 5600+	ADO5600IAA5DO	processor
2313	27	Athlon 64 X2 5800+	ADA5800IAA5DO	processor
2315	27	Athlon 64 X2 6000+	ADV6000IAA5DO	processor
2317	27	Athlon X2 BE-2300	ADH2300IAA5DO	processor
2318	27	Athlon X2 BE-2350	ADH2350IAA5DO	processor
2319	27	Athlon X2 BE-2400	ADH2400IAA5DO	processor
2320	27	Athlon X2 BE-2450	ADH2450IAA5DO	processor
2321	27	Athlon X2 3250e	ADJ3250IAV5DO	processor
2322	27	Athlon X2 4050e	ADH4050IAA5DO	processor
2323	27	Athlon X2 4450e	ADH4450IAA5DO	processor
2324	27	Athlon X2 4850e	ADH4850IAA5DO	processor
2325	27	Athlon X2 5050e	ADH5050IAA5DO	processor
2326	27	Athlon X2 4450B	ADH445BIAA5DO	processor
2327	27	Athlon X2 4850B	ADH485BIAA5DO	processor
2328	27	Athlon X2 5000B	ADO500BIAA5DO	processor
2329	27	Athlon X2 5200B	ADO520BIAA5DO	processor
2330	27	Athlon X2 5400B	ADO540BIAA5DO	processor
2331	27	Athlon X2 5600B	ADO560BIAA5DO	processor
2332	207	Pentium M 1.4	RH80535GC0171M	processor
2333	207	Pentium M 1.5	RH80535GC0211M	processor
2334	207	Pentium M 1.6	RH80535GC0251M	processor
2335	207	Pentium M 1.7	RH80535GC0291M	processor
2336	207	Pentium M 1.8	RH80535GC0331M	processor
2337	207	Pentium M 705	RH80535GC0211M	processor
2338	207	Pentium M 715	RH80536GC0212M	processor
2339	207	Pentium M 715A	RH80536GC0212MT	processor
2340	207	Pentium M 725	RH80536GC0252M	processor
2341	207	Pentium M 725A	RH80536GC0252MT	processor
2342	207	8088	D8088-2	processor
2343	27	8088	P8088-1	processor
2344	289	V20	D70108C-8	processor
2345	289	V20	D70108C-10	processor
2346	207	8086	D8086-2	processor
2347	207	8086	D8086-1	processor
2348	289	V30	D70116C-8	processor
2349	289	V30	D70116C-10	processor
3058	239	\N	27-2025-00	chipsetpart
3059	239	\N	27-2024-00	chipsetpart
3060	525	\N	D0A	chipsetpart
3061	272	\N	91A310	chipsetpart
3062	272	\N	91A311	chipsetpart
3063	155	\N	ET82C4901	chipsetpart
3064	155	\N	ET82C4903	chipsetpart
3065	201	\N	IMS8848	chipsetpart
3066	201	\N	IMS8849	chipsetpart
3069	528	\N	TD3300A	chipsetpart
3070	529	\N	GC100A	chipsetpart
3071	531	\N	40040	chipsetpart
3072	531	\N	40039	chipsetpart
3073	531	\N	40041-A	chipsetpart
3074	239	\N	67-2012-00-20	chipsetpart
3075	239	\N	67-20??-??-??	chipsetpart
3076	423	\N	67-2009-00-20	chipsetpart
3077	423	\N	67-2010-00-20	chipsetpart
3078	423	ATU2	67-2016-00-20	chipsetpart
3079	423	MC2	67-2017-00-20	chipsetpart
3080	452	\N	RC2016	chipsetpart
3081	464	NB	83C311F	chipsetpart
3082	464	SB	83C312F	chipsetpart
3083	534	\N	e88C311	chipsetpart
3084	534	\N	e88C312	chipsetpart
3085	535	\N	D20	chipsetpart
3086	535	\N	D30	chipsetpart
3087	525	\N	C1	chipsetpart
3067	426	\N	FE2010	chipsetpart
3068	426	\N	FE2010A	chipsetpart
3088	426	\N	FE3001	chipsetpart
3091	426	\N	FE3010	chipsetpart
3089	426	\N	FE3021	chipsetpart
3090	426	\N	FE3031	chipsetpart
3092	422	\N	VL82C483F	chipsetpart
3095	207	\N	A82385	chipsetpart
3094	541	\N	Discrete Logic	chipsetpart
3097	161	\N	82EC802G(L)	chipsetpart
3100	161	\N	82EC798	chipsetpart
3101	272	\N	91A320	chipsetpart
3102	272	\N	91A321	chipsetpart
3103	272	\N	92A206	chipsetpart
3104	348	\N	RC4018A4 (CHIP 11)	chipsetpart
3105	348	\N	RC4019A4 (CHIP 13)	chipsetpart
3106	535	\N	D90	chipsetpart
3107	535	\N	D100	chipsetpart
3108	535	\N	D110	chipsetpart
3110	59	\N	IXP150	chipsetpart
3111	59	\N	IXP210	chipsetpart
3113	59	\N	IXP300/SB300	chipsetpart
3120	59	\N	RC350	chipsetpart
3121	59	\N	RX330	chipsetpart
3109	59	\N	IXP200/SB200	chipsetpart
3112	59	\N	IXP250/SB250	chipsetpart
3127	465	\N	STPC Atlas	chipsetpart
3031	422	\N	VL82C101	chipsetpart
3130	557	\N	ADC004	chipsetpart
3131	194	\N	CS8001	chipsetpart
3132	194	\N	CS8002	chipsetpart
3135	59	\N	RC300L	chipsetpart
3136	155	\N	ET486SLC2	chipsetpart
3137	525	\N	215	chipsetpart
3138	422	\N	VL82C201	chipsetpart
3139	422	\N	VL82C202	chipsetpart
3140	422	\N	VL82C203	chipsetpart
3141	422	\N	VL82C204	chipsetpart
3142	193	\N	HT321	chipsetpart
3143	193	\N	HT342	chipsetpart
3144	535	\N	D70	chipsetpart
3145	579	\N	93C305	chipsetpart
3146	579	\N	93C001	chipsetpart
3147	579	\N	93C413	chipsetpart
3148	579	\N	93C308	chipsetpart
3150	579	\N	93C428	chipsetpart
3149	579	\N	93C439	chipsetpart
3151	579	\N	93C488	chipsetpart
3152	452	\N	82C4800	chipsetpart
3153	107	\N	82C597	chipsetpart
3155	417	\N	SL9011	chipsetpart
3156	417	\N	SL9020	chipsetpart
3157	417	\N	SL9025	chipsetpart
3161	417	\N	SL9010	chipsetpart
3162	268	\N	DC462352A	chipsetpart
3163	268	\N	DC462353A	chipsetpart
3164	268	\N	DC462396A	chipsetpart
3165	268	\N	DC462048A	chipsetpart
3166	268	\N	DC462103A	chipsetpart
3167	268	\N	DC462442A	chipsetpart
3168	268	\N	DC462443A	chipsetpart
3169	268	\N	DC462444A	chipsetpart
3170	508	\N	A27C000	chipsetpart
3171	25	\N	M1409A	chipsetpart
3172	107	\N	82C596	chipsetpart
3174	107	\N	82C591	chipsetpart
3175	107	\N	82C592	chipsetpart
3176	107	\N	82C593	chipsetpart
3177	207	\N	82356	chipsetpart
3178	207	\N	82353	chipsetpart
3179	207	\N	82351	chipsetpart
3182	207	MCH	E7500	chipsetpart
3183	207	ICH3-S	82801CA	chipsetpart
3184	207	P64H2	82870P2	chipsetpart
3185	207	MRH-S	82804	chipsetpart
3186	207	MRH-R	82803	chipsetpart
3187	207	P64H	82806	chipsetpart
3188	615	Victory66	SLC90E66	chipsetpart
1	207	443BX + PIIX4E	82443MX	chipsetpart
1875	138	Alpha AXP 21064	21-35023-14	processor
1876	138	Alpha AXP 21064	21-35023-21	processor
1877	138	Alpha AXP 21064	21-35023-19	processor
1878	138	Alpha AXP 21064A	21-40532-02	processor
1879	138	Alpha AXP 21064A	21-40532-03	processor
1880	138	Alpha AXP 21064A	21-40532-04	processor
1882	138	Alpha AXP 21064A	21-40532-06	processor
1883	138	Alpha AXP 21064	21-35023-12	processor
1884	138	Alpha AXP 21164	21-40658-15	processor
1886	138	Alpha AXP 21164	21-40658-17	processor
1887	138	Alpha AXP 21164 for Windows NT	21164-P8	processor
1888	138	Alpha AXP 21164	21-40658-18	processor
1885	138	Alpha AXP 21164 for Windows NT	21164-P1	processor
1881	138	Alpha AXP 21064A for Windows NT	21-40532-08	processor
1889	138	Alpha AXP 21164A	21-43918-01	processor
1890	138	Alpha AXP 21164A	21-43918-02	processor
1891	138	Alpha AXP 21164A	21-43918-03	processor
1892	138	Alpha AXP 21164A	21-43918-07	processor
1893	138	Alpha AXP 21164A	21-43918-10	processor
1894	138	Alpha AXP 21164A	21-43918-23	processor
1895	138	Alpha AXP 21164A	21-43918-35	processor
1896	138	Alpha AXP 21164A for Windows NT	21-43918-45	processor
1897	138	Alpha AXP 21164A	21-43918-37	processor
228	207	MCH	82945PL	chipsetpart
3123	59	Radeon IGP 320	A3	chipsetpart
3115	59	Radeon IGP 330	RS200L	chipsetpart
3114	59	Radeon IGP 340	RS200	chipsetpart
3125	59	Radeon IGP 350M	RS200M (Rev B)	chipsetpart
3117	59	Radeon IGP 345M	RS200M+	chipsetpart
3119	59	Radeon 9100 PRO IGP	RS350	chipsetpart
3134	59	Radeon 9000 PRO IGP	RS300	chipsetpart
3126	59	Mobility Radeon 9000 IGP	RS350M	chipsetpart
3129	471	Crush72	C72	chipsetpart
3133	417	KM400A	VT8378A	chipsetpart
3159	417	PMMC-SX	SL9250	chipsetpart
3160	417	PMMC-DX	SL9350	chipsetpart
3158	417	IPC	SL9030	chipsetpart
3154	417	Clock Chip	SL9090/A	chipsetpart
1898	138	Alpha AXP 21164PC	211PC-01	processor
1899	138	Alpha AXP 21164PC	211PC-02	processor
1900	138	Alpha AXP 21164PC	211PC-03	processor
2	207	MPIIX	82371MX	chipsetpart
2405	207	PIIX4E	82371EBE	chipsetpart
3	207	PIIX4M	82371MB	chipsetpart
4	207	80001ESB	80001ESB	chipsetpart
5	207	MCH	E7210	chipsetpart
6	207	MCH	E7220	chipsetpart
7	207	MCH	E7221	chipsetpart
8	207	MCH	E7230	chipsetpart
9	207	MCH	E7320	chipsetpart
10	207	MCH	E7501	chipsetpart
11	207	MCH	E7520	chipsetpart
12	207	MCH	E7525	chipsetpart
3180	612	CNB30-LE	NB6635	chipsetpart
56	5	\N	ACC 1000	chipsetpart
13	612	CSB6	SB7445	chipsetpart
14	612	CSB5	SB7440	chipsetpart
15	612	MADP	NB6525	chipsetpart
16	612	MADP	NB6535	chipsetpart
17	612	CNB30-HE	NB6536	chipsetpart
18	612	CIOB20	NB6555	chipsetpart
19	612	CNB20-HE	NB6576	chipsetpart
20	612	CNB20-HE-SL	NB6576	chipsetpart
21	612	CMIC-HE	NB7410	chipsetpart
22	612	CMIC-LE	NB7460	chipsetpart
23	612	CMIC-LE5	NB7465	chipsetpart
24	612	CMIC-SL	NB7480	chipsetpart
25	612	CMIC-SL5	NB7485	chipsetpart
26	612	CIOB-X	IB7420	chipsetpart
27	612	CIOB-X2	IB7425	chipsetpart
28	612	CIOB-E	IB7428	chipsetpart
29	612	CSB5??	SB7440-LP1	chipsetpart
31	612	OSB3/ROSB3	IB6565?	chipsetpart
3181	612	OSB4/ROSB4	IB6566	chipsetpart
32	612	CMIC-WS	SB74??	chipsetpart
33	612	REMC	???	chipsetpart
34	612	CIOB-G	IB74??	chipsetpart
35	612	CNB20-LE	NB6566?	chipsetpart
36	207	\N	82424ZX-50	chipsetpart
37	417	\N	VT3118	chipsetpart
38	417	\N	VT3157	chipsetpart
39	417	\N	VT3225	chipsetpart
40	417	\N	VT3371	chipsetpart
42	5	Multifunctional Peripheral Controller	ACC 2000	chipsetpart
43	5	System Bus Controller	ACC 2100	chipsetpart
44	5	Data or Address Buffer	ACC 2220	chipsetpart
45	5	System Bus Controller and Memory Controller	ACC 2120	chipsetpart
46	5	System Bus Controller and Memory Controller	ACC 2121	chipsetpart
47	5	Page/Page Interleaved Memory Controller	ACC 2300	chipsetpart
48	5	System Controller	ACC 2500	chipsetpart
49	5	\N	ACC 82C101	chipsetpart
51	5	System Controller	ACC 3100	chipsetpart
50	5	I/O controller	ACC 3000	chipsetpart
52	5	DMA and Micro Channel Controller	ACC 5000	chipsetpart
53	5	Peripheral Interface Controller	ACC 5100	chipsetpart
54	5	Data Buffer Logic	ACC 5200	chipsetpart
55	5	Memory Controller and Buffers	ACC 5300	chipsetpart
57	5	\N	ACC 2036	chipsetpart
58	5	\N	ACC 2046	chipsetpart
59	207	Pentium M 735	RJ80536GC0292M	processor
60	207	Pentium M 735A	RJ80536GC0292MT	processor
61	207	Pentium M 745	RJ80536GC0332M	processor
62	523	STPC ATLAS	STPCI2HDYC	processor
63	523	STPC ATLAS	STPCI2HDYC	processor
64	523	STPC ATLAS	STPCI2HEYC	processor
65	523	STPC ATLAS	STPCI2HEYC	processor
66	523	STPC ATLAS	STPCI2GDYI	processor
67	523	STPC ATLAS	STPCI2GDYI	processor
68	523	STPC ATLAS	STPCI2HEYI	processor
69	523	STPC ATLAS	STPCI2HEYI	processor
70	523	\N	CS5530A	chipsetpart
71	523	Geode GX1 200	GX1-200B-85-1.6	processor
72	523	Geode GX1 200	GX1-200P-85-1.6	processor
73	523	Geode GX1 233	GX1-233B-85-1.8	processor
74	523	Geode GX1 233	GX1-233P-85-1.8	processor
75	523	Geode GX1 266	GX1-266B-85-1.8	processor
76	523	Geode GX1 266	GX1-266P-85-1.8	processor
77	523	Geode GX1 300	GX1-300B-85-2.0	processor
78	523	Geode GX1 300	GX1-300P-85-2.0	processor
79	523	Geode GX1 333	GX1-333B-85-2.2	processor
80	523	Geode GX1 333	GX1-333P-85-2.2	processor
81	523	Geode GXLV 266 (70C)	GXLV-266P 2.9V 70C	processor
82	523	Geode GXLV 266 (85C)	GXLV-266P 2.9V 85C	processor
83	523	Geode GXLV 266 (70C)	GXLV-266B 2.9V 70C	processor
84	523	Geode GXLV 266 (85C)	GXLV-266B 2.9V 85C	processor
85	523	Geode GXLV 233 (85C)	GXLV-233P 2.5V 85C	processor
86	523	Geode GXLV 233 (85C)	GXLV-233B 2.5V 85C	processor
87	523	Geode GXLV 200 (85C)	GXLV-200P 2.2V 85C	processor
88	523	Geode GXLV 200 (85C)	GXLV-200B 2.2V 85C	processor
89	523	Geode GXLV 180 (85C)	GXLV-180P 2.2V 85C	processor
90	523	Geode GXLV 180 (85C)	GXLV-180B 2.2V 85C	processor
91	523	Geode GXLV 166 (85C)	GXLV-166P 2.2V 85C	processor
92	523	Geode GXLV 166 (85C)	GXLV-166B 2.2V 85C	processor
93	268	Cache and Memory controller	M65363	chipsetpart
94	535	\N	D60	chipsetpart
95	121	MediaGXm 180 (70C)	GXm-180BP 2.9V 70C	processor
96	121	MediaGXm 180 (85C)	GXm-180BP 2.9V 85C	processor
97	121	MediaGXm 180 (70C)	GXm-180GP 2.9V 70C	processor
98	121	MediaGXm 180 (85C)	GXm-180GP 2.9V 85C	processor
99	121	MediaGXm 200 (70C)	GXm-200BP 2.9V 70C	processor
100	121	MediaGXm 200 (85C)	GXm-200BP 2.9V 85C	processor
101	121	MediaGXm 200 (70C)	GXm-200GP 2.9V 70C	processor
102	121	MediaGXm 200 (85C)	GXm-200GP 2.9V 85C	processor
103	121	MediaGXm 200 (85C)	GXm-200GP 2.2V 85C	processor
104	121	MediaGXm 200 (60C)	GXm-200GP 2.9V 60C	processor
105	121	MediaGXm 233 (85C)	GXm-233BP 2.9V 85C	processor
229	207	MCH	82945P	chipsetpart
106	121	MediaGXm 233 (70C)	GXm-233BP 2.9V 70C	processor
107	121	MediaGXm 233 (85C)	GXm-233GP 2.9V 85C	processor
108	121	MediaGXm 233 (70C)	GXm-233GP 2.9V 70C	processor
110	121	MediaGXm 266 (70C)	GXm-266BP 2.9V 70C	processor
109	121	MediaGXm 266 (85C)	GXm-266BP 2.9V 85C	processor
111	121	MediaGXm 266 (85C)	GXm-266GP 2.9V 85C	processor
112	121	MediaGXm 266 (70C)	GXm-266GP 2.9V 70C	processor
1332	121	MediaGXm 300 (60C)	GXm-300GP 2.9V 60C	processor
113	121	MediaGXm 300 (70C)	GXm-300GP 2.9V 70C	processor
114	121	MediaGXm 300 (85C)	GXm-300GP 2.9V 85C	processor
115	121	MediaGXm 300 (85C)	GXm-300BP 2.9V 85C	processor
116	121	MediaGXm 300 (70C)	GXm-300BP 2.9V 70C	processor
793	121	MediaGXm 266	GXm-266GP 2.9V	processor
1331	121	MediaGXm 233	GXm-233GP 2.9V	processor
117	25	\N	M1411	chipsetpart
118	987	Crusoe	TM3200	chipsetpart
120	207	Xeon DP 1.4	RN80528KC017G0K	processor
121	207	Xeon DP 1.5	RN80528KC021G0K	processor
122	207	Xeon DP 1.7	RN80528KC029G0K	processor
123	207	Xeon DP 2.0	RN80528KC041G0K	processor
124	207	Xeon MP 1.4	YF80528KC017512	processor
125	207	Xeon MP 1.5	YF80528KC021512	processor
126	207	Xeon MP 1.6	YF80528KC0251M	processor
127	207	Xeon DP 1.8	RN80532KC033512	processor
128	207	Xeon DP 2.0A	RN80532KC041512	processor
129	207	Xeon DP 2.0B	RK80532KE041512	processor
130	207	Xeon DP 2.2	RN80532KC049512	processor
131	207	Xeon DP 2.4	RN80532KC056512	processor
132	207	Xeon DP 2.4B	RK80532KE056512	processor
133	207	Xeon DP 2.6	RN80532KC064512	processor
134	207	Xeon DP 2.66	RK80532KE067512	processor
135	207	Xeon DP 2.8	RN80532KC072512	processor
136	207	Xeon DP 2.8B	RK80532KE072512	processor
137	207	Xeon DP 3.0	RN80532KC080512	processor
138	207	Xeon DP 3.06	RK80532KE083512	processor
139	207	Xeon DP 1.6 (LV)	RK80532EC025512	processor
140	207	Xeon DP 2.0A (LV)	RK80532EC041512	processor
141	207	Xeon DP 2.4B (LV)	RK80532EE056512	processor
142	207	Xeon DP 2.4B	RK80532KE0561M	processor
143	207	Xeon DP 2.8B	RK80532KE0721M	processor
144	207	Xeon DP 3.06	RK80532KE0831M	processor
145	207	Xeon DP 3.2	RK80532KE0881M	processor
146	207	Xeon DP 3.2	RK80532KE0882M	processor
147	207	Xeon MP 1.5	RN80532KC0211M	processor
148	207	Xeon MP 1.9	RN80532KC0371M	processor
149	207	Xeon MP 2.0	RN80532KC0411M	processor
150	207	Xeon MP 2.0	RN80532KC0412M	processor
151	207	Xeon MP 2.2	RN80532KC0492M	processor
152	207	Xeon MP 2.5	RN80532KC0601M	processor
153	207	Xeon MP 2.7	RN80532KC0682M	processor
154	207	Xeon MP 2.8	RN80532KC0722M	processor
155	207	Xeon MP 3.0	RN80532KC0804M	processor
156	207	Xeon MP 3.16	RK80546KF0871M	processor
157	207	Xeon MP 3.66	RK80546KF1071M	processor
158	207	Xeon MP 2.83	RK80546KF0734M	processor
159	207	Xeon MP 3.0	RK80546KF0808M	processor
160	207	Xeon MP 3.33	RK80546KF0938M	processor
161	207	Xeon DP 2.8	NE80546KG0721M	processor
162	207	Xeon DP 2.8D	B80546KG0721M	processor
163	207	Xeon DP 3.0	RK80546KG0801M	processor
164	207	Xeon DP 3.0D	NE80546KG0801M	processor
165	207	Xeon DP 3.2	RK80546KG0881M	processor
166	207	Xeon DP 3.4	RK80546KG0961M	processor
167	207	Xeon DP 3.6	RK80546KG1041M	processor
168	207	Xeon DP 2.8 (LV)	RK80546KG0721M	processor
169	207	Xeon DP 2.8	RK80546KG0722MM	processor
170	207	Xeon DP 2.8E	NE80546KG0722MM	processor
171	207	Xeon DP 3.0	RK80546KG0802MM	processor
172	207	Xeon DP 3.0E	NE80546JG0802MM	processor
173	207	Xeon DP 3.2	RK80546KG0882MM	processor
174	207	Xeon DP 3.2E	NE80546KG0882MM	processor
175	207	Xeon DP 3.4	RK80546KG0962MM	processor
176	207	Xeon DP 3.4E	NE80546KG0962MM	processor
177	207	Xeon DP 3.6	RK80546KG1042MM	processor
178	207	Xeon DP 3.6E	NE80546KG1042MM	processor
179	207	Xeon DP 3.8	RK80546KG1122MM	processor
180	207	Xeon DP 3.8E	NE80546KG0722M	processor
181	207	Xeon DP 3.2 (MV)	NE80546QG0882MM	processor
182	207	Xeon DP 3.0 (LV)	NE80546JG0802MM	processor
183	987	Crusoe TM120	TM120-02	processor
184	987	Crusoe TM3120	TM3120-02	processor
185	987	Crusoe TM3200	TM3200-02	processor
186	987	Crusoe TM5400-12	TM5400-12	processor
187	987	Crusoe TM5400-13	TM5400-13	processor
188	987	Crusoe TM5400-15	TM5400-15	processor
189	987	Crusoe TM5400-17	TM5400-17	processor
190	987	Crusoe TM5500-667	5500A066710	processor
191	987	Crusoe TM5600-12	TM5600-12	processor
192	987	Crusoe TM5600-13	TM5600-13	processor
193	311	\N	4L50F2052	chipsetpart
194	987	Crusoe TM5600-15	TM5600-15	processor
195	311	CHIP 3	14L50F2056	chipsetpart
196	311	CHIP 5	14L40F2054	chipsetpart
197	987	Crusoe TM5600-16	TM5600-16	processor
198	311	CHIP 6	14L50F2053	chipsetpart
199	311	CHIP 7	14L40F2058	chipsetpart
200	987	Crusoe TM5600-17	TM5600-17	processor
201	987	Crusoe TM5700-667	5700E066710	processor
202	987	Crusoe TM5800-733	5800A073310	processor
203	987	Crusoe TM5800-800	5800A080010	processor
204	987	Crusoe TM5800-800-ULP	5800U080021	processor
205	987	Crusoe TM5800-867	5800A086710	processor
206	987	Crusoe TM5800-900	5800A09004	processor
207	987	Crusoe TM5800-933	5800C093310	processor
208	987	Crusoe TM5800-1000	5800R100021	processor
209	987	Crusoe TM5800-1000-LP	5800P100021	processor
210	987	Crusoe TM5800-1000-VLP	5800N100021	processor
211	987	Crusoe TM5800-1000-ULP	5800T100021	processor
212	987	Crusoe TM5900-800	5900A080010	processor
213	987	Crusoe TM5900-1000-6.5	5900A100010	processor
214	987	Crusoe TM5900-1000-7.5	5900B100010	processor
215	987	Crusoe TM5900-1000-8.5	5900C100010	processor
216	987	Crusoe TM5900-1000-9.5	5900D100010	processor
217	207	\N	A82385SX	chipsetpart
218	535	\N	D80	chipsetpart
219	157	\N	F108251PC	chipsetpart
220	157	\N	F108106PC	chipsetpart
221	994	System Controller	SL6001	chipsetpart
222	994	Memory Decode	SL6002	chipsetpart
223	994	Address & Data Buffer	SL6003	chipsetpart
224	994	Address & Data Buffer	SL6004	chipsetpart
225	994	Address & Data Buffer	SL6005	chipsetpart
226	995	\N	SC	chipsetpart
227	408	\N	UM82C391	chipsetpart
230	207	GMCH	82945G	chipsetpart
231	207	MCH	82955X	chipsetpart
232	207	GMCH	82940GML	chipsetpart
233	207	GMCH	82943GML	chipsetpart
234	207	GMCH	82945GSE	chipsetpart
235	207	GMCH	82945GMS	chipsetpart
236	207	GMCH	82945GM	chipsetpart
237	207	GMCH	82945GME	chipsetpart
238	207	MCH	82945PM	chipsetpart
239	207	GMCH	82945GC	chipsetpart
240	207	GMCH	82945GZ	chipsetpart
241	207	MCH	82946PL	chipsetpart
242	207	GMCH	82946GZ	chipsetpart
243	207	MCH	82P965	chipsetpart
244	207	GMCH	82G965	chipsetpart
245	207	GMCH	82Q965	chipsetpart
246	207	GMCH	82Q963	chipsetpart
247	207	MCH	82975X	chipsetpart
248	207	MCH	82P31	chipsetpart
249	207	GMCH	82G31	chipsetpart
250	207	GMCH	82G33	chipsetpart
251	207	MCH	82P35	chipsetpart
252	207	GMCH	82G35	chipsetpart
253	207	GMCH	82Q33	chipsetpart
254	207	GMCH	82Q35	chipsetpart
255	207	GMCH	82G41	chipsetpart
256	207	GMCH	82B43	chipsetpart
257	207	MCH	82P43	chipsetpart
258	207	MCH	82P45	chipsetpart
259	207	GMCH	82G43	chipsetpart
260	207	GMCH	82G45	chipsetpart
261	207	GMCH	82Q43	chipsetpart
262	207	GMCH	82Q45	chipsetpart
263	207	MCH	82X38	chipsetpart
264	207	MCH	82X48	chipsetpart
268	207	PCH	BD82H55	chipsetpart
269	207	PCH	BD82P55	chipsetpart
270	207	PCH	BD82H57	chipsetpart
271	207	PCH	BD82Q57	chipsetpart
272	207	IOH	AC82X58	chipsetpart
273	207	GMCH	82965GM	chipsetpart
274	207	MCH	82965PM	chipsetpart
275	207	GMCH	82GL40	chipsetpart
276	207	GMCH	82GS40	chipsetpart
277	207	GMCH	82GS45	chipsetpart
278	207	GMCH	82GM45	chipsetpart
279	207	MCH	82PM45	chipsetpart
280	207	PCH	BD82PM55	chipsetpart
281	207	PCH	BD82HM55	chipsetpart
282	207	PCH	BD82HM57	chipsetpart
283	207	PCH	BD82QM57	chipsetpart
284	207	PCH	BD82QS57	chipsetpart
286	207	ICH5R	82801ER	chipsetpart
2792	207	ICH5	82801EB	chipsetpart
3005	207	ICH6	82801FB	chipsetpart
287	207	ICH6R	82801FR	chipsetpart
289	207	ICH7	82801GB	chipsetpart
290	207	ICH7 DH	82801GDH	chipsetpart
292	207	ICH8M	82801HM	chipsetpart
291	207	ICH7R	82801GR	chipsetpart
293	207	ICH8M-E	82801HEM	chipsetpart
294	207	ICH8	82801HB	chipsetpart
295	207	ICH8R	82801HR	chipsetpart
296	207	ICH8 DH	82801HH	chipsetpart
297	207	ICH8 DO	82801HO	chipsetpart
298	207	ICH9M	82801IBM	chipsetpart
299	207	ICH9M-E	82801IEM	chipsetpart
300	207	ICH9	82801IB	chipsetpart
301	207	ICH9R	82801IR	chipsetpart
302	207	ICH9 DH	82801IH	chipsetpart
303	207	ICH9 DO	82801IO	chipsetpart
304	207	ICH10	82801JB	chipsetpart
305	207	ICH10D	82801JH	chipsetpart
306	207	ICH10R	82801JR	chipsetpart
307	207	ICH10 DO	82801JO	chipsetpart
308	207	XMB	E8500	chipsetpart
309	207	XMB	E8501	chipsetpart
310	207	MCH	3000	chipsetpart
311	207	MCH	3010	chipsetpart
312	207	MCH	3200	chipsetpart
313	207	MCH	3210	chipsetpart
314	207	MCH	5000P	chipsetpart
315	207	MCH	5000V	chipsetpart
316	207	MCH	5000Z	chipsetpart
317	207	MCH	5000X	chipsetpart
318	207	MCH	7300	chipsetpart
319	207	PCH	3400	chipsetpart
320	207	PCH	3420	chipsetpart
321	207	PCH	3450	chipsetpart
322	207	IOH	5500	chipsetpart
323	207	IOH	5520	chipsetpart
324	207	631xESB	631xESB	chipsetpart
325	207	632xESB	632xESB	chipsetpart
331	471	MCP55	MCP55	chipsetpart
266	207	GMCH	82915GMS	chipsetpart
265	207	GMCH	82910GML	chipsetpart
285	207	ICH7M	82801GBM	chipsetpart
288	207	ICH7M DH	82801GHM	chipsetpart
267	207	GMCH	82960GL	chipsetpart
328	471	MCP51	MCP51	chipsetpart
330	471	MCP61	MCP61	chipsetpart
329	471	nForce4 MCP	MCP04	chipsetpart
327	471	MCP65	MCP65	chipsetpart
326	471	nForce4 MCP	CK8-04	chipsetpart
333	471	Crush19	C19	chipsetpart
334	59	\N	IXP380/SB380	chipsetpart
335	59	\N	IXP400/SB400	chipsetpart
336	59	\N	IXP450/SB450	chipsetpart
337	59	\N	IXP460/SB460	chipsetpart
3122	59	\N	IXP320/SB320	chipsetpart
339	59	\N	SB300C	chipsetpart
341	59	\N	RX380	chipsetpart
343	59	Radeon Xpress 200	RS480	chipsetpart
344	59	Radeon Xpress 200P	RX480	chipsetpart
345	59	Radeon Xpress 200M	RS480M	chipsetpart
346	59	Radeon Xpress 1100	RS482	chipsetpart
347	59	Radeon Xpress 1150	RS485	chipsetpart
348	59	CrossFire Xpress 1600	RD480	chipsetpart
3124	59	Radeon IGP 320M	U1	chipsetpart
340	59	Radeon 380 IGP	RS380	chipsetpart
342	59	Radeon 380M IGP	RS380M	chipsetpart
3116	59	Radeon IGP 340M	RS200M	chipsetpart
3118	59	Mobility Radeon 7000 IGP	RS250M	chipsetpart
350	59	Radeon Xpress 1250	RS600	chipsetpart
351	59	Radeon CrossFire Xpress 3200	RD600	chipsetpart
352	59	Radeon Xpress 200/1150	RS400	chipsetpart
353	59	Radeon Xpress 200/1150	RS415	chipsetpart
354	59	Radeon Xpress 200/1150	RC400	chipsetpart
355	59	Radeon Xpress 200/1150	RC410	chipsetpart
356	59	CrossFire Xpress 3100	RD570	chipsetpart
349	59	CrossFire Xpress 3200	RD580	chipsetpart
357	27	690V	RS690C	chipsetpart
358	27	690G	RS690	chipsetpart
359	27	M690V	RS690MC	chipsetpart
360	27	M690	RS690M	chipsetpart
361	27	M690E	RS690T	chipsetpart
362	27	M690T	RS690T	chipsetpart
363	27	740	RX740	chipsetpart
364	27	740G	RS740	chipsetpart
365	27	760G	RS780L	chipsetpart
366	27	770	RX780	chipsetpart
367	27	780V	RS780C	chipsetpart
368	27	780G	RS780I	chipsetpart
369	27	M780V	RS780MC	chipsetpart
370	27	M780G	RS780M	chipsetpart
371	27	785G	RS880	chipsetpart
372	27	785E	RS785E	chipsetpart
373	27	790GX	RS780D	chipsetpart
374	27	790X	RD780	chipsetpart
375	27	790FX	RD790	chipsetpart
376	27	870	RX880	chipsetpart
377	27	880G	RS880P	chipsetpart
378	27	880M	RS880M	chipsetpart
379	27	890GX	RS880D	chipsetpart
380	27	890FX	RD890	chipsetpart
381	27	970	RX980	chipsetpart
382	27	990X	RD980	chipsetpart
383	27	990FX	RD990	chipsetpart
384	27	\N	SB700	chipsetpart
385	27	\N	SB710	chipsetpart
386	27	\N	SB750	chipsetpart
387	27	\N	SB810	chipsetpart
388	27	\N	SB850	chipsetpart
389	27	\N	SB920	chipsetpart
390	27	\N	SB950	chipsetpart
338	59	SB600	SB600	chipsetpart
391	207	MCH	5100	chipsetpart
392	207	MCH	5400	chipsetpart
423	557	\N	ADC006	chipsetpart
424	25	\N	M1203	chipsetpart
394	207	IOH	7500	chipsetpart
425	25	\N	M1201	chipsetpart
393	207	6700PXH	6700PXH	chipsetpart
395	207	GMCH	82945GT	chipsetpart
396	272	\N	91A401	chipsetpart
397	272	\N	91A402	chipsetpart
398	471	Crush51	C51	chipsetpart
332	471	Crush51G	C51G	chipsetpart
399	471	MCP68	MCP68	chipsetpart
400	471	MCP73	MCP73	chipsetpart
401	471	MCP78	MCP78	chipsetpart
402	471	MCP72	MCP72	chipsetpart
403	471	nForce200	NF200-SLI	chipsetpart
404	471	MCP7A	MCP7A	chipsetpart
405	471	MCP55 Pro	MCP55 Pro	chipsetpart
2932	471	nForce3 250/250Gb/Ultra MCP	CK8S	chipsetpart
2926	471	nForce2 MCP	MCP2	chipsetpart
2930	471	nForce2 MCP Gigabit	MCP2-GB	chipsetpart
2927	471	nForce2 MCP SoundStorm/LAN	MCP2-T	chipsetpart
406	471	Crush55	C55	chipsetpart
407	207	6702PXH	6702PXH	chipsetpart
408	73	\N	AT40411	chipsetpart
409	73	\N	AT40412	chipsetpart
410	73	\N	AT40392	chipsetpart
411	73	\N	AT40492	chipsetpart
412	73	\N	AT40281	chipsetpart
413	73	\N	AT40283	chipsetpart
414	73	\N	AT40285	chipsetpart
415	73	\N	AT40410	chipsetpart
416	73	\N	AT40495	chipsetpart
417	73	\N	AT40498	chipsetpart
418	73	\N	AT40957	chipsetpart
419	73	\N	AT40958	chipsetpart
420	73	\N	AT40959	chipsetpart
421	73	\N	AT40391	chipsetpart
422	995	\N	SC-9204-A	chipsetpart
426	25	\N	M2107	chipsetpart
427	25	\N	M5103	chipsetpart
428	155	\N	ET82C492	chipsetpart
429	207	Pentium M 745 (C1)	RH80536GC0332M	processor
430	207	Pentium M 745A	RH80536GC0332MT	processor
431	207	Pentium M 750	RJ80536GE0362M	processor
432	207	Pentium M 755	RJ80536GC0412M	processor
433	207	Pentium M 765	RJ80536GC0452M	processor
434	207	Pentium M 760	RJ80536GE0412M	processor
435	207	Pentium M 760 (C1)	RH80536GE0412M	processor
436	207	Pentium M 770	RJ80536GE0462M	processor
437	207	Pentium M 780	RJ80536GE0512M	processor
438	207	Pentium M 730	RJ80536GE0252M	processor
439	207	Pentium M 740	RJ80536GE0302M	processor
440	207	Celeron M 320	RJ80535NC013512	processor
441	207	Celeron M 330	RJ80535NC017512	processor
442	207	Celeron M 340	RJ80535NC021512	processor
443	194	\N	CS8005	chipsetpart
444	194	\N	CS8006	chipsetpart
445	194	\N	SC9204	chipsetpart
446	207	Celeron M 350J	RH80536NC0131M	processor
447	207	Celeron M 360	RH80536NC0171M	processor
448	207	Celeron M 360J	RH80536NC0171M	processor
449	207	Celeron M 370	RH80536NC0211M	processor
450	207	Celeron M 380	RH80536NC0251M	processor
451	207	Celeron M 390	RH80536NC0291M	processor
452	303	\N	82C691	chipsetpart
2512	303	\N	82C696	chipsetpart
1999	552	286	CS80C286-20	processor
453	207	i386 DX-12	A80386-12	processor
716	207	i386 DX-16	A80386DX-16	processor
994	207	i386 DX-25	A80386DX-25	processor
995	207	i386 DX-33	A80386DX-33 IV	processor
454	207	i386 DX-25	NG80386DX-25	processor
455	207	i386 DX-33	NG80386DX33	processor
119	27	Am386 DX/DXL-33	A80386DX-33	processor
996	27	Am386 DX/DXL-40	A80386DX-40	processor
456	27	Am386 DX/DXL-25	A80386DX-25	processor
457	27	Am386 DX/DXL-20	A80386DX-20	processor
458	27	Am386 DX-25	NG80386DX-25	processor
459	27	Am386 DX-33	NG80386DX-33	processor
460	27	Am386 DX-40	NG80386DX-40	processor
461	27	Am386 DE-33	Am386DE-33GC	processor
462	393	ATU	TACT83443	chipsetpart
463	393	MCU	TACT83442	chipsetpart
464	393	DPU	TACT83441	chipsetpart
465	393	\N	TACT82201	chipsetpart
466	393	\N	TACT82202	chipsetpart
467	393	\N	TACT82203	chipsetpart
468	393	\N	TACT82204	chipsetpart
469	393	\N	TACT82205	chipsetpart
470	471	nForce Professional 2200	MCP 2200	chipsetpart
471	471	nForce Professional 2050	MCP 2050	chipsetpart
472	193	\N	HT12	chipsetpart
2890	417	KX133	VT8371	chipsetpart
2896	417	KM133A	VT8365A	chipsetpart
41	417	CLE266	VT8623	chipsetpart
2881	417	P4X266	VT8753	chipsetpart
3128	417	PN133T	VT8606T	chipsetpart
2889	417	KN400	VT8373	chipsetpart
473	417	\N	P4M900	chipsetpart
474	207	\N	82443ZXM	chipsetpart
475	417	P4M266A	VT8751A	chipsetpart
476	303	Viper-M IPC	82C558M	chipsetpart
2488	303	Viper-M SYSC	82C557M	chipsetpart
477	107	\N	82C599	chipsetpart
478	417	SMC-SX	SL9252	chipsetpart
479	417	SMC-DX	SL9352	chipsetpart
480	417	PIMC-DX	SL9351	chipsetpart
481	417	PIMC-SX	SL9251	chipsetpart
482	417	PMU	SL9095	chipsetpart
483	417	PIMC	SL9151	chipsetpart
484	417	\N	P4M800	chipsetpart
485	417	\N	K8T800	chipsetpart
486	417	\N	P4M400	chipsetpart
487	417	\N	P4X600	chipsetpart
488	417	\N	P4X533	chipsetpart
489	417	\N	K8T890	chipsetpart
490	417	K8T400M	VT8385	chipsetpart
491	417	K8T400	VT8383	chipsetpart
492	417	\N	P4M890	chipsetpart
493	417	\N	PT890	chipsetpart
494	417	\N	K8T800Pro	chipsetpart
496	417	\N	K8N800A	chipsetpart
495	417	\N	VT8235M	chipsetpart
\.


--
-- Data for Name: chip_alias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chip_alias (id, chip_id, manufacturer_id, name, part_number) FROM stdin;
1	59	207	Pentium M 735	RH80536GC0292M
2	60	207	Pentium M 735A	RH80536GC0292MT
3	61	207	Pentium M 745	BXM80536GC1800F
4	61	207	Pentium M 745	LE80536GC0332M
5	61	207	Pentium M 745	RH80536GC0332M
6	61	207	Pentium M 745	LE80536GC0332M
7	61	207	Pentium M 745	RH80536GC0332M
8	61	207	Pentium M 745	RJ80536GC0332M
9	2409	393	LBX	CF64743APPM
10	95	523	Geode GXm 180 (70C)	GXm-180B 2.9V 70C
11	96	523	Geode GXm 180 (85C)	GXm-180B 2.9V 85C
12	97	523	Geode GXm 180 (70C)	GXm-180P 2.9V 70C
13	98	523	Geode GXm 180 (85C)	GXm-180P 2.9V 85C
14	99	523	Geode GXm 200 (70C)	GXm-200B 2.9V 70C
15	100	523	Geode GXm 200 (85C)	GXm-200B 2.9V 85C
16	101	523	Geode GXm 200 (70C)	GXm-200P 2.9V 70C
17	102	523	Geode GXm 200 (85C)	GXm-200P 2.9V 85C
18	105	523	Geode GXm 233 (85C)	GXm-233B 2.9V 85C
19	106	523	Geode GXm 233 (70C)	GXm-233B 2.9V 70C
20	107	523	Geode GXm 233 (85C)	GXm-233P 2.9V 85C
22	109	523	Geode GXm 266 (85C)	GXm-266B 2.9V 85C
23	110	523	Geode GXm 266 (70C)	GXm-266B 2.9V 70C
24	111	523	Geode GXm 266 (85C)	GXm-266P 2.9V 85C
25	112	523	Geode GXm 266 (70C)	GXm-266P 2.9V 70C
21	108	523	Geode GXm 233 (70C)	GXm-233P 2.9V 70C
26	118	987	Crusoe	TM5400
27	118	987	Crusoe	TM5600
28	128	207	Xeon DP 2.0A	BX80532KC2000D
29	127	207	Xeon DP 1.8	BX80532KC1800D
30	130	207	Xeon DP 2.2	BX80532KC2200D
31	131	207	Xeon DP 2.4	BX80532KC2400D
32	133	207	Xeon DP 2.6	BX80532KC2600D
33	135	207	Xeon DP 2.8	BX80532KC2800D
34	147	207	Xeon MP 1.5	BX80532KC1500E
35	148	207	Xeon MP 1.9	BX80532KC1900E
36	149	207	Xeon MP 2.0	BX80532KC2000E
37	150	207	Xeon MP 2.0	BX80532KC2000F
38	151	207	Xeon MP 2.2	BX80532KC2200F
39	152	207	Xeon MP 2.5	BX80532KC2500E
40	153	207	Xeon MP 2.7	BX80532KC2700F
41	154	207	Xeon MP 2.8	BX80532KC2800F
42	155	207	Xeon MP 3.0	BX80532KC3000H
43	190	987	Crusoe TM5500-667	5500A066721
44	195	311	CHIP 3	6L70F2061
45	203	987	Crusoe TM5800-800	5800A08004
46	2727	534	ET82C596	ET82C596
47	2735	534	ET82C692BX	ET82C692BX
50	349	27	580X	RD580
49	356	27	570X/550X	RD570
48	348	27	480X	RD480
51	338	27	SB600	SB600
52	991	27	Am386SX-33	NG80386SX-33
53	991	27	Am386SXL-33	NG80386SXL-33
54	2884	379	85C360	85C360
55	429	207	Pentium M 745 (C1)	LE80536GC0332M
56	431	207	Pentium M 750	RH80536GE0362M
57	431	207	Pentium M 750	LE80536GE0362M
58	432	207	Pentium M 755	RH80536GC0412M
59	433	207	Pentium M 765	RH80536GC0452M
60	434	207	Pentium M 760	RH80536GE0412M
61	434	207	Pentium M 760	LE80536GE0412M
62	435	207	Pentium M 760 (C1)	LE80536GE0412M
63	436	207	Pentium M 770	RH80536GE0462M
64	436	207	Pentium M 770	LE80536GE0462M
65	437	207	Pentium M 780	RH80536GE0512M
66	437	207	Pentium M 780	LE80536GE0512M
67	438	207	Pentium M 730	RH80536GE0252M
68	438	207	Pentium M 730	LE80536GE0252M
69	439	207	Pentium M 740	RH80536GE0302M
70	439	207	Pentium M 740	LE80536GE0302M
71	884	207	Celeron M 310	RH80535NC009512
72	440	207	Celeron M 320	LE80535NC013512
73	440	207	Celeron M 320	RH80535NC013512
74	440	207	Celeron M 320	RH80535NC0131M
75	441	207	Celeron M 330	RH80535NC017512
76	441	207	Celeron M 330	RH80535NC0171M
77	442	207	Celeron M 340	RH80535NC021512
78	442	207	Celeron M 340	RH80535NC0211M
79	885	207	Celeron M 350	RJ80536NC0131M
80	446	207	Celeron M 350J	RJ80536NC0131M
81	447	207	Celeron M 360	RJ80536NC0171M
82	448	207	Celeron M 360J	RJ80536NC0171M
83	449	207	Celeron M 370	RJ80536NC0211M
84	449	207	Celeron M 370	LE80536NC0211M
85	449	207	Celeron M 370	BX80536NC1500EJ
86	450	207	Celeron M 380	RJ80536NC0251M
87	450	207	Celeron M 380	LE80536NC0251M
88	450	207	Celeron M 380	BX80536NC1600EJ
89	451	207	Celeron M 390	RJ80536NC0291M
90	451	207	Celeron M 390	LE80536NC0291M
91	716	207	i386 DX-16	A80386-16
92	716	207	i386 DX-16	A80386DX-16 IV
93	716	207	i386 DX-16	A80386DX16
94	716	207	i386 DX-16	MG80386-16
95	716	207	i386 DX-16	MG80386-16/B
96	716	207	i386 DX-16	MG8038616
97	993	207	i386 DX-20	A80386-20
98	993	207	i386 DX-20	A80386DX-20 IV
99	993	207	i386 DX-20	A80386DX20
100	993	207	i386 DX-20	MG80386-20
101	994	207	i386 DX-25	A80386-25
102	994	207	i386 DX-25	A80386DX-25 IV
103	994	207	i386 DX-25	A80386DX-25I
104	994	207	i386 DX-25	A80386DX25
105	994	207	i386 DX-25	A80386DX25 IV
106	994	207	i386 DX-25	MG80386-25
107	994	207	i386 DX-25	MG80386-25/B
108	994	207	i386 DX-25	TA80386DX-25
109	994	207	i386 DX-25	TA80386DX25
110	995	207	i386 DX-33	A80386DX-33I
111	995	207	i386 DX-33	A80386DX33
112	995	207	i386 DX-33	A80386DX33I
113	455	207	i386 DX-33	NT80386DX33
114	996	27	Am386 DX-40	A80386DXL-40
115	119	27	Am386 DX-33	A80386DXL-33
116	456	27	Am386 DX/DXL-25	A80386DXL-25
117	457	27	Am386 DX/DXL-20	A80386DXL-20
\.


--
-- Data for Name: chip_documentation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chip_documentation (id, chip_id, language_id, file_name, link_name, updated_at) FROM stdin;
2	443	1	cs8005-reg-61fbdbba79f68911134043.pdf	Register finds	2022-02-03 13:42:18
5	2774	1	82443zx-intelcorporation-620296aa88332782183197.pdf	440ZX AGPset: 82443ZX Host Bridge/Controller Datasheet	2022-02-08 16:13:30
6	2715	1	vt82c496g-1-6202988dc9056711526343.pdf	VT82C496G GREEN PC 80486 PCI/VL/ISA System Datasheet	2022-02-08 16:21:33
3	2988	1	vt82c505-6202992f22ef6889725501.pdf	VT82C505 Pentium/486 VL to PCI BRIDGE	2022-02-08 16:24:15
4	2988	1	via-82c505-6202992f23863105468309.pdf	VT82C505 Interface with Other VL/ISA Chipsets	2022-02-08 16:24:15
1	3153	1	contaq597-datasheet-6202999c75abf347745793.pdf	Contaq 82C597 Datasheet	2022-02-08 16:26:04
7	477	1	contaq599-datasheet-620299eeadc47634370673.pdf	Contaq 82C599 Datasheet	2022-02-08 16:27:26
8	2629	1	ali-m1644-6206777c47f44401022650.pdf	M1644 Datasheet	2022-02-11 14:49:32
9	2631	1	ali-m1646-6206779006ee5261459164.pdf	M1646 Datasheet	2022-02-11 14:49:52
10	2635	1	ali-m1651t-620677a00f2fc929819448.pdf	M1651T Datasheet	2022-02-11 14:50:08
\.




--
-- Data for Name: chipset; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chipset (id, manufacturer_id, name, encyclopedia_link, release_date, part_no, description) FROM stdin;
90	305	\N	\N	\N	\N	\N
41	311	ALi Aladdin IV+ oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TX Two%20	<05/28/97	TX Two	\N
136	452	\N	\N	\N	\N	\N
712	471	nForce2 IGP	\N	2002	\N	\N
105	393	\N	\N	\N	TACT80101	\N
92	311	UTron / HiNT UT801X oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=VX Pro II%20	\N	VX Pro II	\N
93	311	SiS 5597/5598 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TX Pro II%20	<04/15/97	TX Pro II	\N
743	311	CHIP 2	\N	\N	\N	\N
675	379	\N	\N	2001	645	\N
713	471	nForce2 400	\N	2003	\N	\N
676	379	\N	\N	\N	645DX	\N
714	471	nForce2 400	\N	2003	\N	\N
677	379	\N	\N	2002	645DX	\N
715	471	nForce2 400	\N	2004	\N	\N
730	489	Logic	\N	\N	\N	\N
716	471	nForce2 400	\N	2004	\N	\N
1365	393	\N	\N	\N	TACT8220x	\N
744	311	ALi Aladdin IV+ oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Super TX%20	\N	Super TX	\N
746	311	SiS5591/92,5595 (David) oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=PC100%20	\N	PC100	\N
94	311	VIA Apollo VP oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=VX Pro%20	<02/15/96	VX Pro	\N
740	311	VIA Apollo Pro+ oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXtoo%20	\N	BXtoo	\N
731	311	VIA Apollo VPX oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=VX Pro +%20	\N	VX Pro+	\N
742	311	VIA MVP4 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=VIA GRA%20	\N	VIA GRA	\N
667	474	Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=SOLUTIONS%2088	\N	88C4386C	\N
1022	465	STPC Atlas	\N	\N	\N	\N
277	207	PCIset VX Triton II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430VX%20	1996-02-12	430VX	\N
6	417	unidentified	\N	\N	\N	generic placeholder for boards with an unknown VIA chipset
1226	207	Greencreek	\N	2006	5000X	\N
256	197	PC/XT chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=IBM%20PC/XT:%20	1981	\N	\N
336	207	Canterwood	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*875P%20	2003-04-14	875P	\N
389	303	PTMAWB Pentium Adaptive Write-back (Cobra)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C596/597%20	1993	82C596/597	\N
417	379	486-VIP 486 Green PC VESA/ISA/PCI Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C496/497%20	1995	85C496/497	\N
433	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*620%20	1999-04	620	\N
465	408	386/486 PC Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C480%20	1991	UM82C480	\N
503	417	Apollo Pro	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C691/2BX%20	1998-05	VT82C691	\N
553	422	TOPCAT 286/386SX PC/AT-Compatible Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C286-SET%20	1990-02	VL82C286-SET	\N
557	422	SCAMP-DT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C311%20	\N	VL82C311	\N
665	303	PTMAWB Pentium Adaptive Write-back (Cobra)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C596/597%20	1993	82C596/597	\N
666	303	System/Power Management Controller (cached) (PCI)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C802G/GP%20	1993	82C802G/GP	\N
674	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*741/741GX%20	\N	741	\N
678	417	Apollo Pro	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C691/2BX%20	1998-05	VT82C691	\N
685	311	SiS 5600 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXPro%20	1998-11	BX Pro	\N
698	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8367%20	2002-02	KT333	\N
728	417	ProSavage8	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8375%20	2002-03	KM266/KL266	\N
690	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366A%20	2001-09	KT266A	\N
856	417	\N	\N	2005-09	P4M800	\N
689	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366A%20	2001-09	KT266A	\N
1375	417	\N	\N	2003	P4M400	\N
688	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366A%20	2001-09	KT266A	\N
699	417	K7-Twister	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8362/5%20	2000-09-26	KM133	\N
697	417	UniChrome AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8378%20	2002-10	KM400/KN400	\N
729	207	Brookdale-E	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845E%20	2002-05-20	845E	\N
745	25	386SX/SLC Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1217/M1209%20	1991	M1209	\N
687	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363%20	2000-06	KT133	\N
857	417	\N	\N	2005-09	P4M800	\N
896	379	\N	\N	\N	648	\N
1250	471	GeForce 6100 + nForce 430	\N	2005	C51G + MCP51	\N
14	422	unidentified	\N	\N	\N	generic placeholder for boards with an unknown VLSI chipset
70	68	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Addonics chipset
29	5	unidentified	\N	\N	\N	generic placeholder for boards with an unknown ACC Microelectronics chipset
19	25	unidentified	\N	\N	\N	generic placeholder for boards with an unknown ALi chipset
51	27	unidentified	\N	\N	\N	generic placeholder for boards with an unknown AMD chipset
28	107	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Contaq chipset
36	155	unidentified	\N	\N	\N	generic placeholder for boards with an unknown ETEQ chipset
81	195	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Highland chipset
63	254	unidentified	\N	\N	\N	generic placeholder for boards with an unknown MIC chipset
72	361	unidentified	\N	\N	\N	generic placeholder for boards with an unknown SIO chipset
38	381	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Symphony chipset
67	424	unidentified	\N	\N	\N	generic placeholder for boards with an unknown VTI chipset
123	25	\N	\N	\N	M1101	\N
1377	417	\N	\N	2003-04	K8T800	\N
717	471	nForce2 400	\N	2004	\N	\N
732	490	UT801x	\N	\N	\N	\N
703	471	nForce 220	\N	2001	IGP-64	\N
718	471	nForce2 Ultra 400	\N	2003	\N	\N
704	471	nForce 415	\N	2001	IGP-128	\N
719	471	nForce2 Ultra 400	\N	2003	\N	\N
705	471	nForce 420	\N	2001	IGP-128	\N
720	471	nForce2 Ultra 400	\N	2004	\N	\N
706	471	nForce 220	\N	2001	IGP-64	\N
721	471	nForce2 Ultra 400	\N	2004	\N	\N
707	471	nForce 415	\N	2001	IGP-128	\N
722	471	nForce2 Ultra 400	\N	2004	\N	\N
153	5	?Pentium 3.3V Notebook 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2056%20	<Jan96 	ACC2056 	\N
734	311	SiS 530 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=SX Pro%20	\N	SX Pro	\N
747	141	??? (386DX chipset)	\N	\N	\N	\N
151	5	WB 486 Notebook/Embedded Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2048%20	?	ACC2048	\N
141	5	AT Chip Set  (286 12.5/16MHz Max)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC82010%20	c88	ACC82010	\N
142	5	Turbo PC/AT Chip Set (286/386SX 25MHz Max)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC82020%20	c88	ACC82020	\N
143	5	Turbo PC/AT Chip Set (286/386SX 25MHz Max)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC82021%20	>88	ACC82021	\N
144	5	386 AT Chip Set (386DX)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC82300%20	c88	ACC82300	\N
145	5	Single-Chip PC/XT Systems-Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC82C100%20	c90	ACC82C100	\N
146	5	Model 30 Integrated Chip Set (MCA)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC83000%20	c88	ACC83000	\N
147	5	Model 50/60 Chipset (MCA)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC85000/A%20	c88	ACC85000	\N
148	5	Turbo PC/XT Integrated Bus and Peripheral Ctrl.	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC1000%20	04/02/1988	ACC1000	\N
149	5	Single Chip Solution 2036 (286/386SX)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2036%20	<Jul92	ACC2036	\N
150	5	486DX/486SX/386DX Single Chip AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2046/ST%20	<Jul92	ACC2046/ST	\N
762	27	\N	\N	2003	8000 w/ 8151	\N
692	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366/8372%20	2001-01	KT266	\N
683	417	Apollo Pro 266	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8633%20	2000-09	VT8633	\N
669	207	Tehama-E	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*850E%20	2002-05-06	850E	\N
197	27	(286 Embeded CPU + integrated peripherals)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AMD%20Am286ZX	\N	Am286ZX/LX	\N
198	27	Pentium Based on VIA VT82C590	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AMD%20640	1997	640/645	\N
199	27	Irongate	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20750%20	1999	750	\N
200	27	760	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20760%20	2000	760	\N
201	27	760MP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20760MP%20	2001	760MP	\N
202	27	760MPX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20760MPX%20	2001	760MPX	\N
203	460	PC1512/1640 8MHz 8086 Personal Computer	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*PC1512/1640%20	1986	AMS40040,AMS40039	\N
208	73	ISA/PC/VL PC/AT Core Logic Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40410%20	\N	AT40410	\N
204	73	80386SX Core Logic Controller w/ optional Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40281%20	\N	AT40281	\N
205	73	80386SX Core Logic Controller w/o Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40283%20	\N	AT40283	\N
206	73	80386SX/486SLC/486SLC2 PC/AT Core Logic	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40285%20	\N	AT40285	\N
289	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440ZX-M%20	1999-05	440ZX-M	\N
319	207	Brookdale-GV	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845GV%20	2002-10-07	845GV	\N
608	121	MediaGx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MediaGx%20	\N	Cx5510	\N
641	262	386SX PC/AT Single Chip w/Posted Write or Write-Thru	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MIC9283%20	\N	MIC9283	\N
642	262	386DX PC/AT Chip Set w/Write-Thru Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MIC9382%20	\N	MIC9382	\N
644	262	486DX PC/AT Single Chip w/Write-Back Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MIC9498%20	\N	MIC9498	\N
647	348	386sx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=RC2015%20	\N	RC2015	\N
663	381	Haydn II [Cache]	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C460%20	1991-06	SL82C460	\N
672	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*741/741GX%20	\N	741GX	\N
670	417	Apollo Pro 133A, 133+ & 133Z	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C694X/MP/Z/A%20	1999-10	VT82C694X	\N
680	417	ProMedia	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8601/A/T%20	2001	PLE133T	\N
679	417	ProMedia	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8601/A/T%20	2001	PLE133	\N
682	417	ProMedia-II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8605/6%20	2001?	PM133T	\N
695	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8377A%20	2003-03	KT400A	\N
691	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366A%20	2001-09	KT266A	\N
735	417	Venus Chip Set	\N	1993	VT82C495	\N
693	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366/8372%20	2001-01	KN266	\N
694	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366/8372%20	2001-01	KN266	\N
736	417	\N	\N	1992?	VT82C485	\N
681	417	ProMedia-II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8605/6%20	2000-06-12	PM133	\N
1366	27	8000 w/ 8131	\N	\N	\N	\N
1202	207	Crestline	\N	2007	GM965	\N
834	417	Apollo P4X266E	\N	2002	P4X266E	\N
828	417	ProSavageDDR	\N	2001-09	P4M266	\N
258	207	High Integration AT-Compatible Chip Set(ZyMOS)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82230/82231%20	1988-08	82230/82231	\N
170	25	386DX/486 ISA Cache? Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1219%20	\N	M1219	\N
168	25	286 Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1207%20	\N	M1207	\N
169	25	386SX/SLC Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1217/M1209%20	1991	M1217	\N
806	417	\N	\N	2004	K8T890	\N
821	417	\N	\N	2005	K8M890	\N
172	25	486 VLB/PCI/ISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*Ml429/31/35%20	1993-10	M1429/31/35	\N
173	25	486 VLB/PCI/ISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1439/31/45%20	1995-05	M1439/31/45	\N
209	73	80486DX PC/AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40492/392%20	\N	AT40492,AT40392	\N
210	73	80486 PC/AT System & Cache Ctrler	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40495%20	\N	AT40495	\N
211	73	80486 Core Logic Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40498%20	\N	AT40498	\N
216	118	CHIPS/250 PS/2 50/60	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8225%20	1988	CS8225	\N
217	118	CHIPSlite	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8227%20	\N	CS8227	\N
218	118	386/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8230%20	1987-02	CS8230	\N
219	118	TURBO CACHE-BASED 386/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8231%20	1986	CS8231	\N
220	118	CMOS 386/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8232%20	1986	CS8232	\N
221	118	PEAK/386 AT (Cached)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8233%20	1990-12	CS8233	\N
222	118	386/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8236%20	1986	CS8236	\N
223	118	TURBO CACHE-BASED 386/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8237%20	1986	CS8237	\N
224	118	CHIPS/280 & 281 (386 MCA)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8238%20	1989-08	CS8238	\N
225	118	PEAK/DM 386 AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS82310%20	1991	CS82310	\N
226	118	NEATsx (386SX)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8281%20	1989-12	CS8281	\N
227	118	LeAPset-sx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8283%20	1990-03	CS8283	\N
228	118	PEAKsx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8285%20	1991	CS8285	\N
230	118	WinCHIPS	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS4000%20	1992	CS4000	\N
229	118	CHIPSlite-sx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8288%20	\N	CS8288	\N
251	155	386/486 WB Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ET2000%20	\N	ET2000	\N
252	155	Cheetah 486DX/SX Non-Cache System	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ET6000%20	1992-04	ET6000	\N
254	155	Firefox 386SX Write Back chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ET9800/391%20	\N	ET9800/391	\N
255	155	Panda S.C. 386SX Direct Mapped Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C390SX%20	1992-02	82C390SX	\N
317	207	Brookdale-GE	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845GE%20	2002-10-07	845GE	\N
409	379	286 chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C211/2/5%20	\N	85C211/2/5	\N
410	379	'Rabbit' High performance 386DX chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C310/320/330%20	1991	85C310/320/330	\N
411	379	ISA 386DX Single Chip chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C360%20	\N	85C360	\N
412	379	ISA 486DX/SX Cache chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C401/402%20	\N	85C401/402	\N
413	379	EISA 386/486 Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C406/5/411/420/431%20	1991	85C406/5/411/420/431	\N
414	379	ISA 386DX/486 Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C460%20	\N	85C460	\N
416	379	Green PC ISA-VLB 486 Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C471/407%20	1994	85C471/407	\N
418	379	Pentium/P54C PCI/ISA Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C501/502/503%20	1995-01-09	85C501/502/503	\N
443	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*740%20	2001-11	740	\N
616	170	386	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX36C200/100%20	\N	FRX36C200/100	\N
617	170	386 Write Through	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX36C300/200%20	\N	FRX36C300/200	\N
618	170	386 Write Through	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX36C300/46C402%20	\N	FRX36C300/46C402	\N
619	170	Single Chip 386SX with Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX36C311%20	\N	FRX36C311	\N
620	170	386 Write Through	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX46C411/402%20	\N	FRX46C411/402	\N
621	170	386 Write Through	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX46C411/412%20	\N	FRX46C411/412	\N
622	170	386 Write Back	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX46C421A/422%20	\N	FRX46C421A/422	\N
623	170	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX46C521A%20	\N	FRX46C521A	\N
624	170	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX58C613/601A%20	\N	FRX58C613/601A	\N
625	170	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=FRX58C613A/602B/601B%20	\N	FRX58C613A/602B/601B	\N
814	379	\N	\N	2003	755	\N
820	379	\N	\N	2005	761GX	\N
1378	417	\N	\N	2002-10	K8M400	\N
907	379	\N	\N	\N	661FX	\N
1279	471	nForce 740a SLI	\N	2008	MCP72	\N
1376	417	\N	\N	2003	P4X800	\N
543	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8379%20	2004-02	KT880	\N
20	379	unidentified	\N	\N	\N	generic placeholder for boards with an unknown SiS chipset
154	5	PCI Notebook/Embedded Single Chip 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2057%20	<Aug96 	ACC2057 	\N
155	5	486 Notebook/Embedded Single Chip 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2066NT%20	? 	ACC2066NT 	\N
156	5	486 VL-based System Super Chip Solution 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2086%20	? 	ACC2086 	\N
157	5	Enhanced Super Chip (486 Single Chip) 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2087%20	<Aug96 	ACC2087 	\N
158	5	486 PCI-based System Super Chip 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2089%20	? 	ACC2089 	\N
160	5	32-bit 486 Green System Single Chip 	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2178A%20	? 	ACC2178A 	\N
826	417	ProSavageDDR	\N	2001-09	P4M266	\N
811	417	\N	\N	2005	K8M890	\N
262	207	Chip Set (VLSI)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82340DX%20	1990-01-08	82340DX	\N
261	207	MCA compatible Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82320%20	1989-04-10	82320	\N
264	207	EISA Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82350%20	1989-07-10	82350	\N
279	207	PCIset KX Orion WS/Mars	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82450KX	1995-11-01	450KX	\N
263	207	Chip Set (VLSI)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82340SX%20	1989-01-25	82340SX	\N
260	207	High Integration MCA Compatible Perip. Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82311%20	1988-11-14	82311	\N
272	207	PCIset LX Mercury (Late)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430LX%20	1993-03-22	430LX	\N
265	207	EISA Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82350DT%20	1991-04-22	82350DT	\N
271	207	PCIset EX Aries	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420EX%20	1994-12	420EX	\N
268	207	PCIset TX Saturn	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1992-11	420TX	\N
273	207	PCIset NX Neptune	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430NX%20	1994-03	430NX	\N
292	207	Profusion	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Profusion	1999	???????	\N
293	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810%20	1999-04-26	810	\N
161	5	?486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2268%20	\N	ACC2268	\N
162	5	Maple/Maple-133 486-System-On-Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC????%20	\N	ACC????	\N
189	25	Aladdin-T Cyberblade	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1644M	\N	M1644M/M1535D+	\N
190	25	Aladdin Pro 5	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1651	\N	M1651/M1535D+	\N
191	25	Aladdin Pro 5T	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1651T	\N	M1651T/M1535D+	\N
192	25	Cyber MAGIK	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1646%20	\N	M1646	\N
193	25	MAGiK 1	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1647	\N	M1647/M1535D+	\N
194	25	MAGiK 1	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1649	\N	M1649/M1535D+	\N
195	25	MAGiK 2	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1667	\N	M1667/M1563	\N
196	25	Aladdin K7 III	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1657%20	\N	M1657/?	\N
213	118	PC/AT compatible CHIPSet	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8220%20	1985-10	CS8220	\N
214	118	NEW Enhanced AT (NEAT)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8221%20	1986	CS8221	\N
257	197	AT chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=IBM%20AT:%20	1984	\N	\N
266	207	xPress Server Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82356/3/1%20	1992	82356/3/1	\N
269	207	PCIset ZX Saturn II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1993	420ZX	\N
267	207	Xtended Xpress Server Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*6379XX%20	1995-06	6379XX	\N
270	207	PCIset ZX Saturn II-50	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1993	420ZX-50	\N
284	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440DX%20	\N	440DX	\N
290	207	Banister	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440MX%20	1999-05-17	440MX	\N
298	207	Solano	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815%20	2000-06-19	815	\N
299	207	Solano-2	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815e%20	2000-06-19	815E	\N
304	207	Solano-3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815eg%20	2001-09	815EG	\N
305	207	Camino	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*820%20	1999-11-15	820	\N
306	207	Camino-2	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*820e%20	2000-06-05	820E	\N
310	207	Carmel	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*840%20	1999-10-25	840	\N
311	207	Brookdale	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845%20	2001-09-10	845	\N
314	207	Brookdale-E	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845E%20	2002-05-20	845E	\N
318	207	Brookdale-PE	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845PE%20	2002-10-07	845PE	\N
320	207	Breeds Hill	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*848P%20	2003-08	848P	\N
596	464	System I/O Controller With PCI Arbiter	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*W83C553F%20	1995	W83C553F	\N
597	464	PCI TO ISA Bridge Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*W83628F/29D%20	1998	W83628F/29D	\N
598	464	LPC TO ISA Bridge Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*W83626F/D%20	2000	W83626F/D	\N
815	379	\N	\N	2004	755FX	\N
818	379	\N	\N	2003	760	\N
859	417	\N	\N	2005-09	P4M800 Pro	\N
1171	207	Bearlake-G+ (Digital Home)	\N	2007	G33	\N
533	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366A%20	2001-09	KT266A	\N
283	207	Seattle	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440BX%20	1998-04	440BX	\N
328	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*855GM%20	2003-03-12	855GM	\N
281	207	Natoma	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440FX%20	1996-05-06	440FX	\N
326	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*852GME%20	2003-06-11	852GME	\N
325	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*852PM%20	2003-06-11	852PM	\N
323	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*852GM%20	2003-01-14	852GM	\N
274	207	PCIset FX Triton I	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430FX%20	1995-01-31	430FX	\N
286	207	Marlinespike	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440GX%20	1998-06-29	440GX	\N
324	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*852GMV%20	\N	852GMV	\N
297	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810e2%20	2001-01-03	810E2	\N
809	417	\N	\N	2005	K8M890	\N
850	417	\N	\N	2003	PM800	\N
287	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440ZX%20	1999-01-04	440ZX	\N
288	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440ZX-66%20	1999-01-04	440ZX-66	\N
327	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*854%20	2005-04-11	854	\N
322	207	Tehama-E	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*850E%20	2002-05-06	850E	\N
300	207	Solano-?	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815em%20	2000-10-23	815EM	\N
321	207	Tehama	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*850%20	2000-11-20	850	\N
295	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810-DC100%20	1999-04-26	810-DC100	\N
294	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810L%20	1999-04-26	810L	\N
296	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810e%20	1999-09-27	810E	\N
282	207	Balboa	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440LX%20	1997-08-27	440LX	\N
291	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*450NX%20	1998-06-29	450NX	\N
285	207	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*440EX%20	1998-04	440EX	\N
303	207	Solano-3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815g%20	2001-09	815G	\N
301	207	Solano-3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815ep%20	2000-11	815EP	\N
302	207	Solano-3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*815p%20	2000-03	815P	\N
307	207	Almador	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*830M%20	2001-07-30	830M	\N
308	207	Almador	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*830MP%20	2001-07-30	830MP	\N
309	207	Almador	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*830MG%20	2001-07-30	830MG	\N
312	207	Brookdale-M	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845MP%20	2002-03-04	845MP	\N
313	207	Brookdale-M	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845MZ%20	2002-03-04	845MZ	\N
315	207	Brookdale-G	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845G%20	2002-05-20	845G	\N
316	207	Brookdale-GL	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*845GL%20	2002-05-20	845GL	\N
338	193	12/16MHz PC/AT Compatible Chip Set + EMS 4.0	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*GC101/102/103%20	1989-07	GC101,GC102,GC103	\N
339	193	80386 AT Compatible Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*GCK113%20	1989	GCK113	\N
340	193	Universal PS/2 Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*GCK181%20	1989-03	GCK181	\N
341	193	Single 286 AT Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT11%20	1990-08	HT11	\N
343	193	80386SX Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT18%20	1991-09	HT18	\N
344	193	386SX/286 Single Chip (20 MHz)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT21%20	1991-08	HT21	\N
345	193	386SX/286 Single Chip (25 MHz)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT22%20	1991-09	HT22	\N
346	193	3-volt Core Logic for 386SX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT25%20	1992-12	HT25	\N
347	193	Single-Chip Peripheral Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT35%20	\N	HT35	\N
348	193	386DX Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HTK320%20	1991-09	HTK320	\N
358	305	286/3868X Desktop Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*OTI-020%20	1991-12	OTI-020	\N
359	305	286/3868X OakNote Notebook Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*OTI-040%20	1991-01	OTI-040	\N
360	305	286/386SX OakHorizon Chip set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*OTI-050%20	1989-11	OTI-050	\N
361	303	SCNB Single Chip Notebook	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C263%20	1992	82C263	\N
363	303	386SX System Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C283%20	1991	82C283	\N
362	303	Cache Sx/AT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C281/282%20	1991-08-22	82C281/282	\N
364	303	SXWB PC/AT Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C291%20	1991	82C291	\N
365	303	SLCWB PC/AT Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C295%20	\N	82C295	\N
366	303	HiD/386	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C381/382%20	1989	82C381/382	\N
367	303	386WB PC/AT Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C391/392%20	1990-12	82C391/392	\N
368	303	Notebook PC/AT chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C461/462%20	\N	82C461/462	\N
537	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8368%20	2002-08	KT400	\N
1049	508	??? (386SX chipset)	\N	\N	\N	\N
756	311	Aladdin TNT oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GFXpro%20	\N	GFXpro	\N
1025	471	nForce3 250Gb	\N	2004	CK8S	\N
330	207	Odem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*855PM%20	2003-03-12	855PM	\N
331	207	Colusa	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*860%20	2001-05-21	860	\N
1367	207	Whitney	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*810%20	1999-04-26	810 ICH2	\N
333	207	Springdale-PE	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865PE%20	2003-05-21	865PE	\N
335	207	Springdale-GV	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865GV%20	2003-09	865GV	\N
349	193	Shasta 486 Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HTK340%20	1992-06	HTK340	\N
369	303	SCNB Single Ship Notebook	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82c463%20	1992	82C463	\N
370	303	Single-Chip Mixed Voltage Notebook Solution	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82c465MV/A/B%20	1997-10	82C465MV/A/B	\N
371	303	HiP/486 & HiB/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C481\\?/482\\?%20	1989-10	82C481?/482?	\N
374	303	LCWB PC/AT chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C495SX/392SX%20	\N	82C495SX/392SX	\N
372	303	486WB PC/AT Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C491/392%20	1991-04-21	82C491/392	\N
812	417	\N	\N	2005	K8T900	\N
373	303	486SXWB	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C493/392%20	1991-10-21	82C493/392	\N
376	303	PC/AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C495XLC%20	1993	82C495XLC	\N
379	303	DXWB PC/AT chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C498%20	\N	82C498	\N
378	303	DXBB PC/AT Chipset (Cached)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C496/7%20	1992-01-16	82C496/7	\N
380	303	DXSC DX System Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C499%20	1993	82C499	\N
381	303	Python PTM3V	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C546/547%20	1994	82C546/547	\N
382	303	Viper	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C556/7/8%20	\N	82C556/7/8	\N
384	303	Viper-N+ Viper Notebook Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C556M/7M/8E%20	1996	82C556M/7M/8E	\N
383	303	Viper-N Viper Notebook Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C556/7/8N%20	1995-05-25	82C556/7/8N	\N
385	303	Viper-Max Chipset Scalable MultiMedia PC Solution	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C566/7/8%20	\N	82C566/7/8	\N
386	303	486/Pentium	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C571/572%20	1993	82C571/572	\N
387	303	Viper Xpress	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C576/7/8%20	\N	82C576/7/8	\N
390	303	Discovery (Pentium Pro)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C650/1/2%20	\N	82C650/1/2	\N
388	303	Viper XPress+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C576/8/9%20	1997-01-16	82C576/8/9	\N
391	303	386/486WB EISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C681/2/6/7%20	1992	82C681/2/6/7	\N
392	303	386/486AWB EISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C683%20	\N	82C683	\N
393	303	Pentium uP Write Back Cache EISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C693/6/7%20	1993	82C693/6/7	\N
394	303	FireStar	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C700%20	1997	82C700	\N
395	303	FireStar Plus	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C701%20	1997	82C701	\N
396	303	Vendetta	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C750%20	\N	82C750	\N
397	303	SCWB2 DX Single Chip Solution	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82c801%20	1992	82C801	\N
398	303	SCWB2 PC/AT Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C802%20	\N	82C802	\N
400	303	System/Power Management Controller (cached)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C895%20	1994-09	82C895	\N
401	303	System/Power Management Controller (non-cache)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C898%20	1994-11	82C898	\N
402	345	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*KS82C***%20	1988	KS82C***	\N
403	345	Pentium cache EDO	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*KS82C531%20	1995	KS82C531	\N
404	345	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*KS82C884%20	\N	KS82C884	\N
434	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*621%20	\N	621	\N
460	408	PC/XT Integration Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C088%20	1991	UM82C088	\N
461	408	286AT MORTAR Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C230%20	1991	UM82C230	\N
462	408	386SX/286 AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C210%20	1991	UM82C210	\N
464	408	386 HEAT PC/AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C380%20	1991	UM82C380	\N
478	417	\N	\N	2007-02	CN896	\N
861	417	\N	\N	2005	PT880 Pro	\N
477	417	\N	\N	2007-02	CN896	\N
480	417	\N	\N	2009-03	VX855	\N
481	417	\N	\N	2010-12	VN1000	\N
479	417	\N	\N	2008-04	VX800	\N
816	379	\N	\N	2003	755	\N
476	417	Flex II/386SXP	\N	1990-06-12	\N	\N
493	417	Apollo VP2, VP2/97	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C590%20	1997-01-10	VT82C590	\N
527	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363A%20	2000-12	KT133A	\N
827	417	ProSavageDDR	\N	2001-09	P4M266	\N
829	417	Apollo P4X266	\N	2001-08	P4X266	\N
824	417	Apollo P4X266	\N	2001-08	P4X266	\N
490	417	Apollo Master, Green Pentium/P54C	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C570M%20	1995-06-22	VT82C570M	\N
494	417	Apollo VP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C597/AT%20	1997-10-03	VT82C597/AT	\N
488	417	Pluto, Green PC 80486 PCI/VL/ISA System	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C496G%20	1994-05-30	VT82C496G	\N
505	417	Apollo Pro+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693%20	1998-12	VT82C693	\N
504	417	Apollo Pro+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693%20	1998-12	VT82C693	\N
506	417	Apollo Pro+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693%20	1998-12	VT82C693	\N
509	417	Apollo Pro 133	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693A%20	1999-07	VT82C693A	\N
510	417	Apollo Pro 133	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693A%20	1999-07	VT82C693A	\N
508	417	Apollo Pro 133	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693A%20	1999-07	VT82C693A	\N
507	417	Apollo Pro 133	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C693A%20	1999-07	VT82C693A	\N
519	417	Apollo Pro 266	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8633%20	2000-09	VT8633	\N
399	303	System/Power Management Controller (cached)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C802G/GP%20	1993	82C802G/GP	\N
463	408	Twinstar	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C3xx%20	\N	UM82C3xx	\N
466	408	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C493/491%20	\N	UM82C493/491	\N
467	408	486 VL Chipset "Super Energy Star Green"	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM8498/8496%20	1994	UM8498/8496	\N
468	408	HB4 PCI Chipset "Super Energy Star Green"	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM8881/8886%20	1994	UM8881/8886	\N
813	417	\N	\N	2005	K8T900	\N
807	417	\N	\N	2004	K8T890	\N
469	408	Pentium chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM8890%20	\N	UM8890BF	\N
473	417	\N	\N	2006-07	VX700	\N
482	417	\N	\N	2006	CN700	\N
472	417	Flex II/386DX	\N	1990-06-12	\N	\N
471	417	\N	\N	2006-11	CN800	\N
486	417	Venus Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C495/480%20	1993	VT82C495	\N
484	417	Jupiter, Chip Set (w/cache) 386	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C475%20	1992?	VT82C475	\N
475	417	\N	\N	2006-02	P4M890	\N
474	417	\N	\N	2006-05	P4M900	\N
512	417	Apollo Pro 133T	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C694T%20	2001-03	VT82C694T	\N
485	417	GMC chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C486/2/3%20	1993	VT82C486	\N
487	417	EISA Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C495/491%20	1993	VT82C495	\N
483	417	Jupiter, Chip Set (w/o cache) 386	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C470%20	1992?	VT82C470	\N
526	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363%20	2000-06	KT133	\N
517	417	ProSavageDDR	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8607/8%20	2000-10	PM266/PM266T	\N
532	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8366/8372%20	2001-01	KT266	\N
528	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363E%20	2001	KT133E	\N
516	417	ProMedia-II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8605/6%20	2000-06-12	PM133	\N
539	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8377A%20	2003-03	KT400A	\N
541	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*?%20	2003	KM400A	\N
529	417	ProSavage4 AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8364%20	2001	KL133	\N
531	417	K7-Twister	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8365A%20	2001	KM133A	\N
470	417	\N	\N	2005-08	VN800	\N
520	417	Apollo Pro 266T & PX266	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8653%20	2001-10	VT8653	\N
544	422	PC/XT 8-10MHz	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C***%20	\N	VL82C***	\N
545	422	AT 8-10MHz	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C***%20	\N	VL82C***	\N
547	422	AT 16 MHz 0/1 ws	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCPM-QC%20	1988	VL82CPCPM-QC	\N
548	422	AT 16 MHz, 0/1 ws	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-16QC/-20QC%20	1989	VL82CPCAT-16QC	\N
549	422	AT 20 MHz, 0/1 ws	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-16QC/-20QC%20	1989	VL82CPCAT-20QC	\N
550	422	AT 16 MHz, Page-Mode	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCPM-16QC/-20QC%20	1989	VL82CPCPM-16QC	\N
551	422	AT 20 MHz, Page-Mode	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCPM-16QC/-20QC%20	1989	VL82CPCPM-20QC	\N
817	379	\N	\N	2004	756	\N
523	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8371%20	2000-01-10	KX133	\N
708	471	nForce 420	\N	2001	IGP-128	\N
498	417	Apollo MVP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C598MVP%20	1997-09-22	VT82C598MVP	\N
823	379	\N	\N	2001	645	\N
501	417	Apollo P6	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C680%20	1996-08-30	VT82C680	\N
1370	579	(386DX/486DLC chipset)	\N	\N	\N	\N
496	417	Apollo MVP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C598MVP%20	1997-09-22	VT82C598MVP	\N
500	417	Apollo MVP4	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8501%20	1998-11-04	VT8501	\N
1185	207	Eaglelake-P+ (RAID)	\N	2008	P45	\N
502	417	Apollo Pro II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C691/2BX%20	1998-05	VT82C692BX	\N
524	417	Trident Blade 3D	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8361%20	2001	KLE133	\N
518	417	mobile	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8613%20	2001-10	PN266T	\N
513	417	Twister	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8601%20	2001	PN133	\N
534	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8367%20	2002-02	KT333	\N
538	417	ProSavage8	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8375%20	2002-03	KM266/KL266	\N
522	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT????%20	2004-01	CM400	\N
540	417	UniChrome AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8378%20	2002-10	KM400/KN400	\N
535	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8367A%20	2002-02	KT333A	\N
542	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8377?%20	2003-05	KT600	\N
530	417	ProSavage4 AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8364A%20	2001	KL133A	\N
536	417	Zeotrope AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*?%20	2002-06	KM333/KN333	\N
1379	417	\N	\N	2003	K8N400	\N
552	422	PS/2 Model 30-compatible chip set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C031/032/033%20	1988	VL82C031/032/033	\N
515	417	ProSavage	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8604/T%20	2001	PL133/PL133T	\N
556	422	SCAMP-LT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C310%20	\N	VL82C310	\N
558	422	SCAMP-DT 286	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C311L%20	\N	VL82C311L	\N
559	422	SCAMP Power Management Unit (PMU)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C312%20	\N	VL82C312	\N
560	422	SCAMP II, Low-Power Notebook Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C315A%20	\N	VL82C315A	\N
561	422	SCAMP II, Power Management Unit (PMU)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C322A%20	\N	VL82C322A	\N
562	422	SCAMP II, PC/AT-Compatible System Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C316%20	\N	VL82C316	\N
563	422	SCAMP II, 5 Volt Power Management Unit (PMU)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C323%20	\N	VL82C323	\N
564	422	Single chip 386DX PC/AT Controller +on-chip cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C380%20	\N	VL82C380	\N
881	417	Apollo P4X333	\N	2002-03	P4X333	\N
565	422	VL82C386SX System Cache controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C325%20	\N	VL82C325	\N
566	422	VL82C386DX System Cache ctrl.	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C335%20	\N	VL82C335	\N
567	422	Kodiak 32-Bit Low-Voltage Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C315A/322A/3216%20	\N	VL82C315A/322A/3216	\N
568	422	SCAMP IV	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C420/144/146%20	1993	VL82C420/144/146	\N
569	422	System/Cache/ISA bus Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C480%20	\N	VL82C480	\N
570	422	System/Cache/ISA bus Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C481%20	1992	VL82C481	\N
571	422	Single-Chip 486, SC486, Controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C486%20	\N	VL82C486	\N
572	422	486 Cache controller	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C425%20	\N	VL82C425	\N
573	422	Cheetah 486, PCI	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*????????%20	\N	????????	\N
574	422	Bus Expanding Controller Cache with write buffer	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C3216%20	\N	VL82C3216	\N
575	422	Lynx/M	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C521/522%20	\N	VL82C521/522	\N
576	422	Eagle ?	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C530%20	1995	VL82C530	\N
578	422	SuperCore 590	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C591/593%20	1994	VL82C591/593	\N
588	426	CPU Core Logic for PS/2 386SX Compatibles	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD6400SX/LP%20	1990	WD6400SX/LP	\N
589	426	CPU Core Logic for PS/2 386DX/486 Compatible	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD6500%20	1990	WD6500	\N
602	452	ISA 486/386 Cache System Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=82C3480	\N	82C3480	\N
590	426	System Chip Set for 80286 or 80386SX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD7600A/LP/LV%20	1991-11-25	WD7600A/LP/LV	\N
591	426	System Chip Set for 80286 or 80386SX (Cache)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD7700/LP%20	1991-11-25	WD7700/LP	\N
592	426	System controller for 80386SX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD7855%20	1992-09-25	WD7855	\N
593	426	System Chip Set for 80286 or 80386SX (Cache)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD7900/LP/LV%20	1991-11-25	WD7900/LP/LV	\N
594	426	System controller for 80386DX/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*WD8110%20	1993-11-30	WD8110	\N
916	379	\N	\N	2002	R658	\N
555	422	TOPCAT 286/386SX PC/AT-Compatible Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C386sx-SET%20	\N	VL82C386SX-SET	\N
1060	311	CHIP 5 + 6 (OPTi 391/392 clone)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C480%20	\N	\N	\N
709	471	nForce2 SPP	\N	2002	\N	\N
710	471	nForce2 SPP	\N	2002	\N	\N
724	471	nForce3 250	\N	2004	CK8S	\N
637	192	PowerPC ISA/PCI Motherboard	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=HYF82481%20	\N	HYF82481	\N
635	194	Sierra	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=SC8006%20	\N	CS8006	\N
175	25	Genie, Quad Pentium	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M????%20	1995	M????	\N
176	25	Aladdin	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1451/49%20	\N	M1451/49	\N
177	25	Aladdin II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1511/12/13%20	1995-04	M1511/12/13	\N
178	25	Aladdin III	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1521/23%20	1996-11	M1521/23	\N
179	25	Aladdin IV & IV+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1531/33/43%20	1997-05-28	M1531/33/43	\N
181	25	Aladdin 7 ArtX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1561/43/35D%20	1999-11-08	M1561/43/35D	\N
183	25	Aladdin Pro	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1621	\N	M1621/M1533	\N
184	25	Aladdin Pro II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1621	\N	M1621/M1543/C	\N
185	25	Aladdin TNT2 (UMA)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1631	\N	M1631/M1535D	\N
186	25	Aladdin Cyber Blade 2	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1632%20	\N	M1632	\N
187	25	Aladdin Pro 4	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1641B	\N	M1641B/M1535D	\N
188	25	Aladdin Cyberblade XT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=M1644	\N	M1644/M1535D+	\N
215	118	LeAPset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS8223%20	\N	CS8223	\N
231	118	ISA/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS4021%20	1992	CS4021	\N
232	118	CHIPSet	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS4031%20	1993-05-10	CS4031	\N
233	118	CHIPSet	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CS4041/5%20	1995-02-10	CS4041/5	\N
234	118	ELEAT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CB8291%20	1990	CB8291	\N
235	118	ELEATsx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*CB8295%20	1990	CB8295	\N
236	118	IBM PS/2 Model 30/Super XT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C100%20	\N	82C100	\N
237	118	IBM PS/2 Model 30/Super XT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C110%20	\N	82C110	\N
238	118	Single Chip AT (SCAT)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C235%20	1989	82C235	\N
239	118	Single Chip 386sx (SCATsx)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C836%20	1991	82C836	\N
240	118	PC/CHIP Single-Chip PC	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*F8680/A%20	1993	F8680/A	\N
244	107	486 EISA chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*??????%20	1993-02	??????	\N
245	107	PCI-VLB Bridge	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C599%20	\N	82C599	\N
246	107	PCI-ISA Bridge	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C693%20	\N	82C693	\N
422	379	Pentium PCI/ISA	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5511/5512/5513%20	1995-06-14	5511/5512/5513	\N
431	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5600%20	1998-11	5600	\N
846	417	\N	\N	2003	P4X533	\N
430	379	SoC (System-on-chip)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*55x%20	2002-03-14	55x	\N
432	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*600%20	\N	600	\N
554	422	TOPCAT 386DX PC/AT-Compatible Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C386-SET%20	\N	VL82C386-SET	\N
577	422	Lynx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C541/543%20	1995	VL82C541/543	\N
579	422	Wildcat	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82C594/596/597%20	1995	VL82C594/596/597	\N
603	452	ISA 486/386 Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=82C3491%20	1993	82C3491/493	\N
604	452	ISA 486/386 Cache System Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=82C3480	\N	82C3480	\N
611	121	GXm	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GXm%20	\N	Cx5530	\N
630	459	WriteBack/WriteThru	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=82C3480%20	\N	82C3480	\N
632	194	Caesar	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=CS8001/CS8002%20	\N	CS8001/CS8002	\N
646	262	ISA 3/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MIC%20362	\N	MIC 361/362/363	\N
648	348	386sx Supports EMS/Cyrix CPU's	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=RC2016A%20	1992	RC2016A	\N
649	348	386sx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=RC2018%20	\N	RC2018	\N
650	348	PCChips UMC 82C491/493 clone	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=RC4018A4/RC4019A4%20	1993	RC4018/19	\N
651	348	386dx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=RC4018A4/RC6206A4%20	1993	RC4018A4/RC6206A4	\N
652	380	286	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=ST62C202%20	1988	ST62C202	\N
653	380	Chipset for 286	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=ST62C241%20	\N	ST62C241	\N
654	380	Chipset for 286 and 386SX	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=ST62C251%20	\N	ST62C251	\N
659	461	isa 286	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TC6154AF%20	\N	TC6154AF	\N
660	414	386/486 AT Chip Set - isa 386dx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=U4800%20	1992	U4800	\N
661	414	isa/vlb 486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=U4800-VLX%20	1993	U4800-VLX	\N
662	414	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=480VL%20	1993-08-08	480VL	\N
1380	417	\N	\N	2003-01	P4X600A	\N
1368	471	nForce Professional 2200	\N	\N	\N	\N
711	471	nForce2 IGP	\N	2002	\N	\N
738	311	VIA Apollo Pro oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXtel%20%20	\N	BXtel	\N
774	311	VIA Apollo Pro oem	\N	\N	VT133	\N
765	262	X30 chipset	\N	\N	MIC 471	\N
42	311	ALi Aladdin III oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=HX Pro%20	<Nov96	HX Pro	\N
733	311	ALi Aladdin IV oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TX Pro%20	\N	TX Pro	\N
741	311	ALi Aladdin IV+ oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Top Gun%20	\N	Top Gun	\N
749	311	ALi Aladdin Pro 4 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GFXpro PC133%20	\N	GFXpro PC133	\N
737	311	ALi Aladdin Pro II oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXcel%20	\N	BXcel	\N
739	311	VIA Apollo Pro oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXtoo%20	\N	BXtoo	\N
751	311	SiS 620 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Xcel 2000%20	\N	Xcel 2000	\N
750	311	VIA Apollo Pro 692 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXpert%20	\N	BXpert	\N
752	311	VIA MVP3 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AGP Pro PC-100%20	\N	PC-100 AGP Pro	\N
753	311	VIA VPX oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TX Pro III%20	\N	TX Pro III	\N
755	311	SiS 630 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GFXcel%20	\N	GFXcel	\N
754	311	SiS 5591/5592 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=TX Pro IV%20	\N	TX Pro IV / Super TX4 AGP	\N
241	107	3/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C591/2%20	1992-03	82C591,82C592	\N
243	107	3/486 Writeback Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C596/A%20	1992-11-11	82C596A	\N
419	379	Pentium/P54C PCI/ISA Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5101/5102/5103%20	1995-04-02	5101/5102/5103	\N
420	379	Pentium PCI/ISA Chipset (Mobile)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5120%20	1997-01-28	5120	\N
423	379	(Trinity) Pentium PCI/ISA Chipset (75MHz)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5571%20	1996-12-09	5571	\N
424	379	(Jessie) Pentium PCI/ISA Chipset (75MHz)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5581/5582%20	1997-04-15	5581/5582	\N
425	379	(David) Pentium PCI A.G.P. Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5591/5592/5595%20	1998-01-09	5591/5592/5595	\N
426	379	(Genesis) Pentium PCI Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5596/5513%20	1996-03-26	5596/5513	\N
427	379	(Jedi) Pentium PCI/ISA Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5597/5598%20	1997-04-15	5597/5598	\N
428	379	(Sinbad) Host, PCI, 3D Graphics & Mem. Ctrl.	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*530/5595%20	1998-11-10	530/5595	\N
429	379	(Spartan) Super7 2D/3D Ultra-AGP Single C.S.	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*540%20	1999-11-30	540	\N
435	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*630/630E/S%20	2000-02	630/630E/S	\N
436	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*630ST/ET%20	\N	630ST/ET	\N
437	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*633/633T%20	2001-03	633/633T	\N
438	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*635/635T%20	2001-03	635/635T	\N
439	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*640T%20	2001-03	640T	\N
440	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*730S/SE%20	2000-12	730S/SE	\N
441	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*733%20	2001-04	733	\N
442	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*735/735S%20	2001-04	735/735S	\N
444	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*745%20	2002-02	745	\N
445	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*746/DX/FX%20	2002-08	746/DX/FX	\N
446	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*748%20	2003-08	748	\N
447	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*741/741GX%20	\N	741GX	\N
448	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M741%20	\N	M741	\N
449	381	Haydn	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C360%20	1991-06	SL82C360	\N
450	381	Haydn II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C460%20	1991-06	SL82C460	\N
451	381	Mozart	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C470%20	1991-12	SL82C470	\N
452	381	Wagner	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C490%20	\N	SL82C490	\N
453	381	Rossini	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL82C550%20	1995	SL82C550	\N
454	393	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SN74LS610/2%20	1984	SN74LS610/2	\N
455	393	3-Chip 286	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*TACT82000%20	1989	TACT82000	\N
456	393	Snake	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*TACT82411%20	1990	TACT82411	\N
457	393	Snake+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*TACT82S411%20	1991	TACT82S411	\N
658	465	PC Client ST86 processor	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=ST86%20	\N	\N	\N
673	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*741/741GX%20	\N	741	\N
696	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8368%20	2002-08	KT400	\N
726	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8377?%20	2003-05	KT600	\N
776	25	ALADDiN-P4	\N	2001	M1671/M1535D+	\N
777	25	CyberALADDiN-P4	\N	2001	M1672/M1535D+	\N
819	379	\N	\N	2004	760GX	\N
1169	207	Bearlake-G+	\N	2007	G33	\N
684	417	Apollo Pro 266T & PX266	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8653%20	2001-10	VT8653	\N
12	193	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Headland chipset
757	311	SiS 730S oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=T-Bird%20	\N	T-Bird	\N
758	311	SiS 5597/5598 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Super TX3%20	\N	Super TX3	\N
759	311	SiS 645 oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=XP4%20	\N	XP4	\N
763	311	SiS 630ET oem	\N	\N	GFXcel 133	\N
764	262	MIC 472	\N	\N	\N	\N
767	262	X30WB chipset	\N	\N	\N	\N
768	155	EQ82C662X	\N	\N	\N	\N
769	155	EQ82C661X	\N	\N	\N	\N
770	311	VIA Apollo Pro (692) oem	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=BXtoo%20	\N	BX Too	\N
771	464	286 Chipset	\N	\N	W83C20x	\N
772	464	\N	\N	\N	W83C320WF	\N
781	311	SiS 740 oem	\N	\N	SiS 730D	\N
793	379	\N	\N	\N	740	\N
890	379	\N	\N	2001	650	\N
891	379	\N	\N	2001	650	\N
894	379	\N	\N	2002	651	\N
895	379	\N	\N	2002	651	\N
921	311	ALi A800N oem	\N	\N	868Pro	\N
923	262	MIC 461/462	\N	\N	\N	\N
937	239	??? (386DX chipset)	\N	\N	\N	\N
925	155	EQ82C6638 (remarked VIA MVP3)	\N	1999	\N	\N
926	292	NxVL	\N	\N	\N	\N
927	43	Presto	\N	\N	\N	\N
931	292	NxPCI	\N	\N	\N	\N
933	452	\N	\N	\N	83C888x	\N
842	417	ProSavageDDR	\N	2002-02	P4M266A	\N
838	417	Apollo P4X266A	\N	2001-11	P4X266A	\N
841	417	ProSavageDDR	\N	2002-02	P4M266A	\N
836	417	Apollo P4X266A	\N	2001-11	P4X266A	\N
837	417	Apollo P4X266A	\N	2001-11	P4X266A	\N
773	417	3.3V Pentium Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C530MV	1994-05-30	VT82C530MV	\N
835	417	Apollo P4X266E	\N	2002	P4X266E	\N
844	417	Apollo P4X333	\N	2002-03	P4X333	\N
833	417	Apollo P4X266E	\N	2002	P4X266E	\N
839	417	Apollo P4X266A	\N	2001-11	P4X266A	\N
832	417	Apollo P4X266E	\N	2002	P4X266E	\N
831	417	Apollo P4X266	\N	2001-08	P4X266	\N
782	207	Grantsdale	\N	2004	915P	\N
783	207	Grantsdale-G	\N	2004	915G	\N
786	207	Grantsdale-GL	\N	2004	910GL	\N
785	207	Grantsdale-GL	\N	2004	915GL	\N
784	207	Grantsdale-GV	\N	2004	915GV	\N
787	207	Grantsdale-PL	\N	2004	915PL	\N
182	25	386SX Single Chip PC	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M6117%20	1997	M6117	\N
171	25	386DX/486 ISA Cache  Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1419%20	1991	M1419	\N
546	422	AT 12 MHz 0/1 ws	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-QC%20	1988	VL82CPCAT-QC	\N
609	121	GXi	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GXi%20	\N	Cx5520	\N
610	121	GXm	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=GXm%20	\N	Cx5520	\N
760	27	Irongate	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20750%20	1999	750	\N
761	27	760	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=AMD%20760%20	2000	760	\N
775	555	M1689 Single Chip	\N	2004	M1689	\N
779	25	A800N	\N	2004	M1683/M1563	\N
801	417	\N	\N	2003	K8M800	\N
778	25	A8XN	\N	2003	M1681/1563	\N
788	207	Alderwood	\N	2004	925X	\N
789	207	Alderwood-XE	\N	2004	925XE	\N
790	207	Alviso	\N	2005	915PM	\N
791	207	Alviso-GM	\N	2005	915GM	\N
792	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*748%20	2003-08	748	\N
845	417	Apollo P4X400	\N	2002-04	P4X400	\N
798	417	\N	\N	2003	K8T800	\N
794	417	ProSavage DDR AGP	\N	2001?	KM266 Pro ??	\N
795	417	\N	\N	2003	K8T800	\N
803	417	\N	\N	2004	K8T800 Pro	\N
800	417	\N	\N	2003	K8M800	\N
797	417	\N	\N	2003	K8T800	\N
799	417	\N	\N	2003	K8M800	\N
805	417	\N	\N	2004	K8T890	\N
804	417	\N	\N	2004	K8T800 Pro	\N
802	417	\N	\N	2004	K8T800 Pro	\N
808	417	\N	\N	2004	K8T890	\N
822	417	\N	\N	2004	K8T890	\N
810	417	\N	\N	2005	K8M890	\N
847	417	\N	\N	2003	P4X533	\N
852	417	\N	\N	2003	PT880	\N
848	417	\N	\N	2003	PT800	\N
851	417	\N	\N	2003	PM800	\N
854	417	\N	\N	2003	PM800	\N
855	417	\N	\N	2005	PM880	\N
849	417	\N	\N	2003	PT800	\N
853	417	\N	\N	2003	PT880	\N
780	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8622/23%20	2002	CLE266	\N
892	379	\N	\N	\N	650GX	\N
893	379	\N	\N	\N	650GX	\N
897	379	\N	\N	\N	648	\N
898	379	\N	\N	2003	648FX	\N
899	379	\N	\N	2003	648FX	\N
900	379	\N	\N	2003	655	\N
901	379	\N	\N	2003	655	\N
902	379	\N	\N	2003	655FX	\N
903	379	\N	\N	2003	655FX	\N
904	379	\N	\N	\N	655TX	\N
905	379	\N	\N	\N	655TX	\N
906	379	\N	\N	\N	661FX	\N
908	379	\N	\N	\N	656	\N
909	379	\N	\N	\N	656FX	\N
910	379	\N	\N	\N	661GX	\N
911	379	\N	\N	\N	661GX	\N
912	379	\N	\N	\N	649	\N
913	379	\N	\N	\N	649FX	\N
914	379	\N	\N	\N	649DX	\N
915	379	\N	\N	\N	662	\N
917	379	\N	\N	\N	671	\N
918	379	\N	\N	\N	671FX	\N
919	379	\N	\N	\N	671DX	\N
920	379	\N	\N	\N	672	\N
843	417	\N	\N	2002-02	P4M266A	\N
932	508	\N	\N	\N	A27C011	\N
796	417	\N	\N	2002-07	K8T400M	\N
935	508	\N	\N	\N	A27C001	\N
936	403	\N	\N	\N	TH4100	\N
930	507	POACH	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=46312,\\*ZyMOS%20POACH&1=46311&2=46312#46312	\N	\N	\N
939	525	\N	\N	\N	D0A	\N
940	272	??? (386DX chipset)	\N	\N	\N	\N
941	201	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=IMS8848	\N	IMS8849	\N
942	526	\N	\N	\N	FE2010A	\N
943	528	\N	\N	\N	TD3300A	\N
944	529	\N	\N	\N	GC100A	\N
945	531	??? (XT chipset)	\N	\N	\N	\N
946	239	??? (386DX chipset)	\N	\N	\N	\N
947	423	??? (486 chipset)	\N	\N	\N	\N
948	423	??? (486 chipset)	\N	\N	\N	\N
949	452	RC2016	\N	\N	\N	\N
950	464	??? (486SLC)	\N	\N	\N	\N
951	533	Unidentified	\N	\N	\N	\N
952	534	??? (386DX chipset)	\N	\N	\N	\N
956	525	??? (XT chipset)	\N	\N	\N	\N
957	540	SLIK-3	\N	\N	\N	\N
958	426	FE3600 (286 chipset)	\N	\N	\N	\N
959	100	Unidentified	\N	\N	\N	\N
961	422	\N	\N	\N	VL82C483F?	\N
963	52	Unidentified	\N	\N	\N	\N
965	161	??? (486 chipset)	\N	\N	\N	\N
966	541	Discrete Logic	\N	\N	\N	\N
971	161	EC798	\N	\N	\N	\N
972	141	Custom ??? (386SX)	\N	\N	\N	\N
973	152	Custom	\N	\N	\N	\N
974	272	??? (386DX chipset)	\N	\N	\N	\N
1002	59	\N	\N	2004	RX330	\N
1003	59	\N	\N	2004	RX330	\N
1004	59	\N	\N	2004	RX330	\N
1005	59	\N	\N	2004	RX330	\N
992	59	Radeon IGP 340	\N	2002	RS200	\N
993	59	Radeon IGP 340	\N	2002	RS200	\N
990	59	Radeon IGP 340	\N	2002	RS200	\N
991	59	Radeon IGP 340	\N	2002	RS200	\N
985	59	Radeon IGP 330	\N	2002	RS200L	\N
989	59	Radeon IGP 330	\N	2002	RS200L	\N
988	59	Radeon IGP 330	\N	2002	RS200L	\N
987	59	Radeon IGP 330	\N	2002	RS200L	\N
986	59	Radeon IGP 330	\N	2002	RS200L	\N
1001	59	Radeon 9000 PRO IGP	\N	2004	RC350	\N
1000	59	Radeon 9000 PRO IGP	\N	2004	RC350	\N
998	59	Radeon 9000 PRO IGP	\N	2004	RC350	\N
922	379	\N	\N	\N	650GL	\N
954	535	TD-30 (286 chipset)	\N	\N	D30	\N
953	535	TD-20 (XT chipset)	\N	\N	D20	\N
999	59	Radeon 9000 PRO IGP	\N	2004	RC350	\N
994	59	Radeon 9100 PRO IGP	\N	2004	RS350	\N
995	59	Radeon 9100 PRO IGP	\N	2004	RS350	\N
996	59	Radeon 9100 PRO IGP	\N	2004	RS350	\N
997	59	Radeon 9100 PRO IGP	\N	2004	RS350	\N
978	59	Radeon IGP 320	\N	2002	A3	\N
981	59	Radeon IGP 320	\N	2002	A3	\N
979	59	Radeon IGP 320	\N	2002	A3	\N
980	59	Radeon IGP 320	\N	2002	A3	\N
982	59	Radeon IGP 320M	\N	2002	U1	\N
983	59	Radeon IGP 320M	\N	2002	U1	\N
984	59	Radeon IGP 320M	\N	2002	U1	\N
1006	59	Radeon IGP 340M	\N	2002	RS200M	\N
1007	59	Radeon IGP 340M	\N	2002	RS200M	\N
1008	59	Radeon IGP 340M	\N	2002	RS200M	\N
1009	59	Radeon IGP 345M	\N	2002	RS200M+	\N
1010	59	Radeon IGP 345M	\N	2002	RS200M+	\N
1011	59	Radeon IGP 345M	\N	2002	RS200M+	\N
1012	59	Radeon IGP 350M	\N	2003	RS200 (Rev B)	\N
1013	59	Radeon IGP 350M	\N	2003	RS200 (Rev B)	\N
1014	59	Radeon IGP 350M	\N	2003	RS200 (Rev B)	\N
1015	59	Mobility Radeon 7000 IGP	\N	2003	RS250M	\N
1016	59	Mobility Radeon 7000 IGP	\N	2003	RS250M	\N
1017	59	Mobility Radeon 7000 IGP	\N	2003	RS250M	\N
1018	59	Mobility Radeon 9000 IGP	\N	2004	RS350M	\N
1019	59	Mobility Radeon 9000 IGP	\N	2004	RS350M	\N
1020	59	Mobility Radeon 9100 IGP	\N	2004	RS350M	\N
1021	59	Mobility Radeon 9100 IGP	\N	2004	RS350M	\N
969	541	Discrete Logic w 82c206	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C206	\N	\N	\N
962	541	Discrete Logic w A82385	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82385%20	\N	\N	\N
1026	557	ADC004	\N	\N	\N	\N
1369	471	nForce Professional 2200/2050	\N	\N	\N	\N
250	155	Bengal 386DX/486 (WriteBack)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Bengal	1991-11	??????	\N
377	303	DXBB PC/AT Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82c496A/B%20	1992-03	82C496A/B	\N
885	417	\N	\N	2006	PT900	\N
863	417	\N	\N	2005	PT880 Ultra	\N
13	118	unidentified	\N	\N	\N	generic placeholder for boards with an unknown C&T chipset
880	417	\N	\N	2006	PT890	\N
869	417	\N	\N	2005	PT894 Pro	\N
867	417	\N	\N	2005	PT894	\N
870	417	\N	\N	2005	PT894 Pro	\N
866	417	\N	\N	2005	PT880 Ultra	\N
924	441	ZFx86™ 486 PC-in-a-Chip	\N	2001	ZFx86	\N
970	161	EC802G (SiS 85C471/407 clone)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C471/407%20	1994	\N	\N
1024	417	TwisterT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8605/6%20	2001	PN133T	\N
874	417	\N	\N	2006	P4M890	\N
1029	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8367%20	2002-02	KT333	\N
1170	207	Bearlake-G+ (RAID)	\N	2007	G33	\N
960	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363A%20	2000-12	KT133A	\N
1028	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8363A%20	2000-12	KT133A	\N
1023	417	TwisterT	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8605/6%20	2001	PN133T	\N
871	417	\N	\N	2006	P4M890	\N
873	417	\N	\N	2006	P4M890	\N
872	417	\N	\N	2006	P4M890	\N
875	417	\N	\N	2006	P4M890	\N
884	417	\N	\N	2006	P4M900	\N
882	417	\N	\N	2006	P4M900	\N
864	417	\N	\N	2005	PT880 Ultra	\N
889	417	\N	\N	2006	PT900	\N
888	417	\N	\N	2006	PT900	\N
887	417	\N	\N	2006	PT900	\N
886	417	\N	\N	2006	PT900	\N
868	417	\N	\N	2005	PT894	\N
878	417	\N	\N	2006	PT890	\N
877	417	\N	\N	2006	PT890	\N
876	417	\N	\N	2006	PT890	\N
879	417	\N	\N	2006	PT890	\N
865	417	\N	\N	2005-01	PT880 Ultra	\N
883	417	\N	\N	2006-05	P4M900	\N
1031	59	Radeon IGP 340	\N	\N	RS200	\N
1032	59	IGP 9100	\N	\N	RS300	\N
1033	59	IGP 9000	\N	\N	RC300L	\N
1034	155	\N	\N	\N	ET486SLC2	\N
1035	525	\N	\N	\N	215	\N
1036	579	??? 386SX	\N	\N	\N	\N
1038	579	(486 chipset)	\N	\N	\N	\N
1039	579	(486 VLB)	\N	\N	\N	\N
1040	579	(486 PCI chipset)	\N	\N	\N	\N
1042	452	\N	\N	\N	82C4800	\N
1043	107	Single Chip	\N	\N	82C597	\N
1047	268	?	\N	\N	\N	\N
1054	25	Aladdin Pro III	\N	\N	M1631/M1535D	\N
1056	207	Plumas	\N	\N	E7500	\N
1059	615	VictoryBX-66	\N	\N	SLC90E66	\N
595	464	VL-Bus chipset (Symphony Wagner SL82C491/2)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*W83C491/92%20	\N	W83C491/92	\N
152	5	PCI Single Chip Solution for Notebook Applications	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ACC2051/NT%20	c96	ACC2051/NT	\N
1061	207	Canterwood-ES	\N	\N	E7210	\N
1062	207	Lindenhurst-VS	\N	\N	E7320	\N
1064	207	Placer	\N	\N	E7505	\N
1065	207	Lindenhurst	\N	\N	E7520	\N
1066	207	Turnwater	\N	\N	E7525	\N
1067	207	Copper River	\N	\N	E7221	\N
1068	207	Mukilteo	\N	\N	E7230	\N
1063	207	Plumas 533	\N	\N	E7501	\N
1070	612	ServerSet III HE-SL/Champion 3.0 Volume	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	2001	\N	\N
1055	612	ServerSet III LE/Champion 3.0 Entry	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	1999	\N	\N
1069	612	ServerSet III HE/Champion 3.0 Enterprise	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	1999	\N	\N
1050	25	(486 chipset)	\N	\N	M1411	\N
1037	535	TD-70/275 (386SX chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=D70	\N	D70	\N
976	535	TD-90 (286 chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=D90-272	\N	D90	\N
975	535	TD-100 (386SX chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=D100-011	\N	D100	\N
1071	612	GC-HE/Grand Champion HE/Serverset IV HE	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	2001	\N	\N
1072	612	GC-LE/Grand Champion LE/Serverset IV LE	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	2001	\N	\N
1073	612	GC-WS/Grand Champion WS	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	2001	\N	\N
1075	612	ServerSet II LE/Champion 2.0	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	\N	\N	\N
1076	612	ServerSet II HE/Champion 2.0	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	\N	\N	\N
1074	612	GC-SL/Grand Champion Entry	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	2002	\N	\N
1077	207	Granite Bay	\N	\N	E7205	\N
1086	207	Placer (PCI64)	\N	\N	E7505	\N
1087	207	Plumas 533 (PCI64)	\N	\N	E7501	\N
664	207	EISA PCIset HX Triton II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430HX%20	1996-02-12	430HX	\N
280	207	PCIset GX Orion Server	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82450KX	1995-11-01	450GX	\N
1079	207	EISA PCIset LX Mercury (Early)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430LX%20	1993-03-22	430LX	\N
1080	207	EISA PCIset LX Mercury (Late)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430LX%20	1993-03-22	430LX	\N
1078	207	PCIset LX Mercury (Early)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430LX%20	1993-03-22	430LX	\N
1081	207	EISA PCIset TX Saturn	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1993-03	420TX	\N
1083	207	EISA PCIset ZX Saturn II (Late)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1994	420ZX	\N
1085	207	EISA PCIset ZX Saturn II-50 (Late)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1994	420ZX-50	\N
1082	207	EISA PCIset ZX Saturn II (Early)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1993	420ZX	\N
1084	207	EISA PCIset ZX Saturn II-50 (Early)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82420TX	1993	420ZX-50	\N
748	207	EISA PCIset NX Neptune	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430NX%20	1994-03	430NX	\N
242	107	3/486	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C593%20	1992-05	82C593	\N
375	303	DXSLC 386/486 Low Cost Write Back	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C495SLC%20	1992	82C495SLC	\N
415	379	ISA 386DX/486 Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*85C461%20	\N	85C461	\N
421	379	Pentium/P54C PCI/ISA Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5501/5502/5503%20	1995-04-02	5501/5502/5503	\N
1052	417	\N	\N	2004-03	CN400	\N
633	194	Sierra	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=SC9204%20	\N	SC9204	\N
862	417	\N	\N	2005	PT880 Ultra	\N
1155	207	Broadwater-G	\N	2006	G965	\N
1156	207	Broadwater-P (RAID)	\N	2006	P965	\N
1051	107	386 Writeback Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C596/A%20	1992-11-11	82C596	\N
1053	417	\N	\N	2006	CN700	\N
1030	417	UniChrome AGP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8378%20	2003	KM400A	\N
1058	207	Carmel (SDRAM)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*840%20	1999-10-25	840	\N
521	417	mobile	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8622/23%20	2002	CLE266	\N
1	207	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Intel chipset
860	417	\N	\N	2005	PT880 Pro	\N
1041	417	ProMedia	\N	2001	PLE133	\N
1045	417	Flex I/386DXP	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=32504&1=33837,2#32504	1990-06-12	\N	\N
1046	417	Flex I/386SX	\N	1990-04-13	\N	???
1057	417	Apollo Pro 133T	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C694T%20	2001-03	VT82C694T	\N
955	138	unidentified	\N	\N	\N	generic placeholder for boards with an unknown DEC chipset
1090	523	Geode CS5530A	\N	1999	CS5530A	\N
1091	100	Proliant 1500	\N	\N	\N	\N
977	535	TD-110 (386SX/486SLC chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=D110-014	\N	D110	\N
1092	535	TD-60 (286 chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=D60	\N	D60	\N
1093	987	Crusoe	\N	\N	\N	\N
1094	311	CHIP 6 + CHIP 7 (UMC 480 clone)	\N	\N	\N	\N
1095	612	ServerSet III  LC-T	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=29317&1=29303,2&2=29337,29330,29304,29344#29317	\N	\N	\N
1099	535	D-80 (486 chipset)	\N	\N	D80	\N
1100	157	???	\N	\N	\N	\N
964	541	Discrete Logic w VL82C100	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-QC	\N	\N	\N
1098	541	Discrete Logic w A82385sx and VL82C100	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-QC	\N	\N	\N
968	541	Discrete Logic w A82385 and VL82C100	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VL82CPCAT-QC	\N	\N	\N
159	5	32-bit 486 Green System Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C206	?	ACC2168/GT	\N
1096	541	Discrete Logic w A82385sx & 82C206	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C206	\N	\N	\N
967	541	Discrete Logic w A82385 and 82C206	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C206	\N	\N	\N
1097	541	Discrete Logic w A82385sx	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82385SX	\N	\N	\N
1048	541	C&T CS8230 w Intel A82385 and 82C206	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82385%20	\N	\N	\N
1103	995	\N	\N	\N	SC	\N
1105	408	???	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*UM82C480%20	\N	\N	\N
1112	207	Breeds Hill (RAID)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*848P%20	2003-08	848P	\N
1117	207	Alderwood (RAID)	\N	2004	925X	\N
1115	207	Grantsdale (RAID)	\N	2004	915P	\N
1104	207	EISA Natoma	\N	1996-05-06	440FX	\N
1167	207	Bearlake-P	\N	2007	P31	\N
1121	207	Lakeport-G (RAID)	\N	2005	945G	\N
1120	207	Lakeport-G	\N	2005	945G	\N
1108	207	Springdale-G (RAID)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865G%20	2003-05-21	865G	\N
1114	207	Grantsdale-G (RAID)	\N	2004	915G	\N
1134	207	Glenwood	\N	2005	975X	\N
1135	207	Glenwood (RAID)	\N	2005	975X	\N
1118	207	Lakeport	\N	2005	945P	\N
1119	207	Lakeport (RAID)	\N	2005	945P	\N
1128	207	Lakeport-GC	\N	2005	945GC	\N
1129	207	Lakeport-GC (RAID)	\N	2005	945GC	\N
1131	207	Lakeport-GZ	\N	2005	945GZ	\N
1122	207	Lakeport-PL	\N	2005	945PL	\N
1123	207	Lakeport-X	\N	2005	955X	\N
1124	207	Lakeport-X (RAID)	\N	2005	955X	\N
1136	207	Glenwood (Digital Home)	\N	2006	975X	\N
1126	207	Lakeport (Digital Home)	\N	2006	945P	\N
1125	207	Lakeport-G (Digital Home)	\N	2006	945G	\N
1130	207	Lakeport-GC (Digital Home)	\N	2006	945GC	\N
1133	207	Lakeport-GZ	\N	2006	946GZ	\N
1132	207	Lakeport-PL	\N	2006	946PL	\N
1127	207	Lakeport-X (Digital Home)	\N	2006	955X	\N
1137	207	Mukilteo 2	\N	2006	3000	\N
1138	207	Mukilteo 2 (RAID)	\N	2006	3000	\N
1140	207	Mukilteo 2 (RAID)	\N	2006	3010	\N
1139	207	Mukilteo 2	\N	2006	3010	\N
1110	207	Springdale-P	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865P%20	2003-05-21	865P	\N
643	262	386DX PC/AT Chip Set w/Write-Back Cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=MIC9391%20	\N	MIC9391	\N
668	207	Camino (SDRAM)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*820%20	1999-11-15	820	\N
1089	379	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*5571%20	1996-12-09	5577C (relabeled 5571)	\N
1101	994	PC / AT Compatible Chipset (10/12MHz)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL600X	1987-07	SL600X	\N
1102	541	Discrete Logic w Logicstar SL600X	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*SL600X	1987-07	\N	\N
1106	207	Canterwood (RAID)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*875P%20	2003-04-14	875P	\N
1107	207	Canterwood (PCI-X)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*875P%20	2003-04-14	875P	\N
1109	207	Springdale-P (RAID)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865P%20	2003-05-21	865P	\N
1111	207	Springdale-PE (RAID)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865PE%20	2003-05-21	865PE	\N
1113	207	Breeds Hill	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*848P%20	2003-08	848P	\N
1116	207	Alderwood-XE (RAID)	\N	2004	925XE	\N
1141	207	Alviso-GM	\N	2005	915GMS	\N
1142	207	Alviso-GM	\N	2005	910GML	\N
1143	207	Calistoga	\N	2006	940GML	\N
1144	207	Calistoga	\N	2006	943GML	\N
1145	207	Calistoga	\N	2006	945GSE	\N
1146	207	Calistoga	\N	2006	945GMS	\N
1147	207	Calistoga	\N	2006	945GM	\N
1148	207	Calistoga (Digital Home)	\N	2006	945GM	\N
1149	207	Calistoga (Digital Home)	\N	2006	945GT	\N
1150	207	Calistoga	\N	2006	945GME	\N
1151	207	Calistoga (Digital Home)	\N	2006	945GME	\N
1152	207	Calistoga	\N	2006	945PM	\N
1153	207	Calistoga (Digital Home)	\N	2006	945PM	\N
1154	207	Broadwater-P	\N	2006	P965	\N
1157	207	Broadwater-G (RAID)	\N	2006	G965	\N
1158	207	Broadwater-P (Digital Home)	\N	2006	P965	\N
1159	207	Broadwater-G (Digital Home)	\N	2006	G965	\N
1160	207	Broadwater-G (Digital Office)	\N	2006	Q965	\N
1161	207	Broadwater-G	\N	2006	Q965	\N
1162	207	Broadwater-G (RAID)	\N	2006	Q965	\N
1163	207	Broadwater-G	\N	2006	Q963	\N
1164	207	Broadwater-G (RAID)	\N	2006	Q963	\N
1166	207	Bearlake-P+ (RAID)	\N	2007	P35	\N
1168	207	Bearlake-G	\N	2007	G31	\N
1173	207	Bearlake	\N	2007	G35	\N
1208	272	??? (486DX)	\N	\N	\N	\N
1209	207	Cantiga	\N	2008	GL40	\N
1241	471	GeForce 6100 + nForce 400	\N	2006	MCP61	\N
1247	471	GeForce 6150 + nForce 430	\N	2005	C51G + MCP51	\N
1252	471	nForce 500 Ultra	\N	2006	CK8-04	\N
1234	471	nForce4 Ultra	\N	2004	CK8-04	\N
1236	471	nForce4 SLI X16	\N	2004	CK8-04 + C51	\N
1237	471	nForce4 Ultra Intel	\N	2006	C19 + MCP51	\N
1235	471	nForce4 SLI	\N	2004	CK8-04	\N
1233	471	nForce4	\N	2004	CK8-04	\N
723	471	nForce3 150	\N	2003	CK8	\N
725	471	nForce3 Ultra	\N	2004	CK8S	\N
1285	471	nForce 760i SLI	\N	2008	MCP7A	\N
1287	471	nForce 790i SLI	\N	2008	C73 + MCP55	\N
1227	207	Greencreek	\N	2006	5000X	\N
1206	207	Crestline	\N	2007	GL960	\N
1205	207	Crestline	\N	2007	PM965	\N
1204	207	Crestline	\N	2007	PM965	\N
1203	207	Crestline	\N	2007	GM965	\N
1193	207	Eaglelake-B	\N	2008	B43	\N
1188	207	Eaglelake-G	\N	2008	G41	\N
1189	207	Eaglelake-G	\N	2008	G43	\N
1190	207	Eaglelake-G (RAID)	\N	2008	G43	\N
1191	207	Eaglelake-G+	\N	2008	G45	\N
1192	207	Eaglelake-G+ (RAID)	\N	2008	G45	\N
1186	207	Eaglelake-P	\N	2008	P43	\N
1187	207	Eaglelake-P (RAID)	\N	2008	P43	\N
1184	207	Eaglelake-P+	\N	2008	P45	\N
1195	207	Eaglelake-Q	\N	2008	Q43	\N
1194	207	Eaglelake-Q	\N	2008	Q45	\N
1165	207	Bearlake-P+	\N	2007	P35	\N
1172	207	Bearlake-P+ (Digital Home)	\N	2007	P35	\N
1174	207	Bearlake	\N	2007	G35	\N
1175	207	Bearlake (RAID)	\N	2007	G35	\N
1176	207	Bearlake (RAID)	\N	2007	G35	\N
1177	207	Bearlake (Digital Home)	\N	2007	G35	\N
1178	207	Bearlake (Digital Home)	\N	2007	G35	\N
1179	207	Bearlake-QF	\N	2007	Q33	\N
1180	207	Bearlake-QF (RAID)	\N	2007	Q33	\N
1181	207	Bearlake-Q	\N	2007	Q35	\N
1182	207	Bearlake-Q (RAID)	\N	2007	Q35	\N
1183	207	Bearlake-Q (Digital Office)	\N	2007	Q35	\N
1196	207	Bearlake-X	\N	2007	X38	\N
1197	207	Bearlake-X (RAID)	\N	2007	X38	\N
1199	207	Bearlake-X	\N	2008	X48	\N
1200	207	Bearlake-X (RAID)	\N	2008	X48	\N
1201	207	Bearlake-X (Digital Home)	\N	2008	X48	\N
1207	207	Cantiga	\N	2008	GS40	\N
1210	207	Cantiga	\N	2008	GS45	\N
1211	207	Cantiga	\N	2008	GS45	\N
1212	207	Cantiga	\N	2008	GM45	\N
1213	207	Cantiga	\N	2008	GM45	\N
1214	207	Cantiga	\N	2008	PM45	\N
1215	207	Cantiga	\N	2008	PM45	\N
1216	207	Bigby	\N	2007	3200	\N
1217	207	Bigby (RAID)	\N	2007	3200	\N
1218	207	Bigby	\N	2007	3210	\N
1219	207	Bigby (RAID)	\N	2007	3210	\N
1220	207	Blackford	\N	2006	5000P	\N
1221	207	Blackford	\N	2006	5000P	\N
1222	207	Blackford	\N	2006	5000V	\N
1223	207	Blackford	\N	2006	5000V	\N
1224	207	Blackford	\N	2006	5000Z	\N
1225	207	Blackford	\N	2006	5000Z	\N
1228	207	San Clemente	\N	2008	5100	\N
1229	207	San Clemente	\N	2008	5100	\N
1230	207	Seaburg	\N	2008	5400	\N
1231	207	Seaburg	\N	2008	5400	\N
1238	471	nForce4 SLI XE Intel	\N	2006	C19 + MCP51	\N
1239	471	nForce4 SLI Intel	\N	2005	C19 + MCP04	\N
1240	471	nForce4 SLI X16 Intel	\N	2005	C19 + MCP04	\N
1242	471	GeForce 6100 + nForce 405	\N	2006	MCP61	\N
1243	471	GeForce 6100 + nForce 430	\N	2006	MCP61	\N
1244	471	GeForce 6150SE + nForce 400	\N	2006	MCP61	\N
1245	471	GeForce 6100 + nForce 420	\N	2006	MCP61	\N
1246	471	GeForce 6150LE + nForce 430	\N	2006	C51G + MCP51	\N
1248	471	GeForce 6150 + nForce 410	\N	2005	C51G + MCP51	\N
1249	471	GeForce 6100 + nForce 410	\N	2005	C51G + MCP51	\N
1251	471	nForce 500	\N	2006	CK8-04	\N
1253	471	nForce 500 SLI	\N	2006	CK8-04	\N
1254	471	nForce 510	\N	2006	MCP51	\N
1255	471	nForce 520 LE	\N	2007	MCP61	\N
1256	471	nForce 520 LE	\N	2007	MCP65	\N
1257	471	nForce 520	\N	2007	MCP65	\N
1258	471	nForce 550	\N	2006	MCP55	\N
1259	471	nForce 560	\N	2007	MCP65	\N
1260	471	nForce 560 SLI	\N	2007	CK8-04	\N
1261	471	nForce 570 LT SLI	\N	2007	MCP65	\N
1262	471	nForce 570 Ultra	\N	2006	MCP55	\N
1263	471	nForce 570 SLI	\N	2006	MCP55	\N
1264	471	nForce 590 SLI	\N	2006	C51 + MCP55	\N
1265	471	nForce 570 SLI Intel	\N	2006	C51 + MCP51	\N
1266	471	nForce 590 SLI Intel	\N	2006	C51 + MCP55	\N
1267	471	nForce 630a	\N	2007	MCP68	\N
1268	471	nForce 680a SLI	\N	2006	MCP55 x2	\N
1269	471	nForce 610i	\N	2007	MCP73	\N
1270	471	nForce 630i	\N	2007	MCP73	\N
1271	471	nForce 650i Ultra	\N	2006	C55 + MCP51	\N
1272	471	nForce 650i SLI	\N	2006	C55 + MCP51	\N
1273	471	nForce 680i LT SLI	\N	2007	C55 + MCP55	\N
1274	471	nForce 680i SLI	\N	2006	C55 + MCP55	\N
1275	471	nForce 710a	\N	2008	MCP78	\N
1276	471	nForce 720a	\N	2008	MCP78	\N
1277	471	nForce 720d	\N	2008	MCP78	\N
1278	471	nForce 730a	\N	2008	MCP72	\N
1280	471	nForce 750a SLI	\N	2008	MCP72	\N
1281	471	nForce 780a SLI	\N	2008	MCP72 + nForce 200	\N
1282	471	nForce 730i	\N	2008	MCP7A	\N
1283	471	nForce 740i SLI	\N	2008	MCP7A	\N
1284	471	nForce 750i SLI	\N	2007	C72 + MCP51 + NF200	\N
1286	471	nForce 780i SLI	\N	2007	C72 + MCP55 + NF200	\N
1288	27	690V Chipset	\N	2007	RS690C	\N
1289	27	690G Chipset	\N	2007	RS690	\N
1290	27	M690 Chipset	\N	2007	RS690M	\N
1294	73	ISA/VL/PCI 486DX Chipset	\N	\N	AT40411,AT40412	\N
1295	995	\N	\N	\N	SC-9204-A	\N
1296	557	\N	\N	\N	ADC006	\N
1302	27	740G Chipset	\N	2008	RS740	\N
1301	27	740G Chipset	\N	2008	RS740	\N
1303	27	760G Chipset	\N	2009	RS780L	\N
1327	27	790X Chipset	\N	2008	RD780	\N
1329	27	790X Chipset	\N	2008	RD780	\N
1328	27	790X Chipset	\N	2008	RD780	\N
1358	25	??? (XT/V30)	\N	\N	M1203	\N
1360	303	Hunter (486 EISA chipset)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82C691/6%20	\N	82C691/696	\N
1361	25	486SX/DX Single Chip	\N	\N	M1409	\N
1363	136	Concord-V	\N	\N	\N	\N
1364	136	Concord-L	\N	\N	\N	\N
1350	207	Ibex Peak	\N	2010	H55	\N
1371	303	Viper-M	\N	\N	82C556M/7M/8M	The Viper-M is comprised of three chips:\r\no   82C556M Data Buffer Controller (DBC),\r\no   82C557M System Controller (SYSC),\r\no   82C558M Integrated Peripherals Controller (IPC)
495	417	Apollo MVP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C598MVP%20	1997-09-22	VT82C598MVP	\N
499	417	Apollo MVP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C598MVP%20	1997-09-22	VT82C598MVP	\N
491	417	Apollo VP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C580VP%20	1996-02-15	VT82C580VP	\N
701	417	Apollo MVP4	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8501%20	1998-11-04	VT8501	\N
329	207	Montara-GM	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*855GME%20	2003-03-12	855GME	\N
1357	207	PCIset NX Neptune MP	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430NX%20	1994-03	430NX	\N
1351	207	Ibex Peak	\N	2009	P55	\N
1352	207	Ibex Peak	\N	2010	H57	\N
332	207	Springdale-G	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865G%20	2003-05-21	865G	\N
1355	207	Tylersburg	\N	2008	X58	\N
1353	207	Ibex Peak	\N	2010	Q57	\N
207	73	80386DX PC/AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*AT40391/392%20	\N	AT40391,AT40392	\N
212	73	80386/80486 EISA/ISA PC/AT Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ATAT40957/8/9%20	\N	AT40957,AT40958,AT40959	\N
249	155	Bobcat 386DX/486DX chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Cougar/Bobcat	1991-11	???? ('491)	\N
253	155	Jaguar 486 Write Back Cache AT Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*ET9000%20	1992-06	ET9000	\N
458	393	Tiger	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*TACT83000%20	1989	TACT83000	\N
342	193	Single 286 AT Chip with EMS support	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*HT12/+/A%20	1990-08	HT12/+/A	\N
634	194	VLISA Single Chip	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=CS8005,%20	1994	CS8005	\N
934	509	PR3029/3031 (ALi M1429 clone)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*Ml429/31/35%20	1994	\N	\N
1291	27	M690V Chipset	\N	2007	RS690MC	\N
1292	27	M690E Chipset	\N	2007	RS690T	\N
1293	27	M690T Chipset	\N	2007	RS690T	\N
1297	27	740 Chipset	\N	2008	RX740	\N
1298	27	740 Chipset	\N	2008	RX740	\N
1299	27	740 Chipset	\N	2008	RX740	\N
1300	27	740G Chipset	\N	2008	RS740	\N
1304	27	770 Chipset	\N	2008	RX780	\N
1305	27	770 Chipset	\N	2008	RX780	\N
1306	27	770 Chipset	\N	2008	RX780	\N
1307	27	770 Chipset	\N	2008	RX780	\N
1308	27	780V Chipset	\N	2008	RS780C	\N
1309	27	780V Chipset	\N	2008	RS780C	\N
1310	27	780V Chipset	\N	2008	RS780C	\N
1311	27	780G Chipset	\N	2008	RS780I	\N
1312	27	780G Chipset	\N	2008	RS780I	\N
1313	27	780G Chipset	\N	2008	RS780I	\N
1314	27	M780V Chipset	\N	2008	RS780MC	\N
1315	27	M780V Chipset	\N	2008	RS780MC	\N
1316	27	M780V Chipset	\N	2008	RS780MC	\N
1317	27	M780G Chipset	\N	2008	RS780M	\N
1318	27	M780G Chipset	\N	2008	RS780M	\N
1319	27	M780G Chipset	\N	2008	RS780M	\N
1320	27	785G Chipset	\N	2009	RS880	\N
1321	27	785G Chipset	\N	2009	RS880	\N
1322	27	785G Chipset	\N	2009	RS880	\N
1323	27	785E Chipset	\N	\N	RS785E	\N
1324	27	785E Chipset	\N	\N	RS785E	\N
1325	27	790GX Chipset	\N	2008	RS780D	\N
1326	27	790X Chipset	\N	2008	RD780	\N
1330	27	790FX Chipset	\N	2008	RD790	\N
1331	27	790FX Chipset	\N	2008	RD790	\N
1332	27	790FX Chipset	\N	2008	RD790	\N
1333	27	870 Chipset	\N	2010	RX880	\N
1334	27	880G Chipset	\N	2010	RS880P	\N
1335	27	880G Chipset	\N	2010	RS880P	\N
1336	27	880G Chipset	\N	2010	RS880P	\N
1337	27	880G Chipset	\N	2010	RS880P	\N
1338	27	890GX Chipset	\N	2010	RS880D	\N
1339	27	890GX Chipset	\N	2010	RS880D	\N
1340	27	890GX Chipset	\N	2010	RS880D	\N
1341	27	890GX Chipset	\N	2010	RS880D	\N
1342	27	890FX Chipset	\N	2010	RD890	\N
1343	27	890FX Chipset	\N	2010	RD890	\N
1344	27	890FX Chipset	\N	2010	RD890	\N
1345	27	890FX Chipset	\N	2010	RD890	\N
1346	27	970 Chipset	\N	2011	RX980	\N
1347	27	970 Chipset	\N	2011	RX980	\N
1348	27	990X Chipset	\N	2011	RD980	\N
1349	27	990FX Chipset	\N	2011	RD990	\N
1356	59	Radeon Xpress 1250	\N	2006	RS600	\N
1359	155	Cougar 386DX/486DX chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Cougar/Bobcat	1991-11	???? ('491)	\N
671	417	Apollo Pro 133A, 133+ & 133Z	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C694X/MP/Z/A%20	1999-10	VT82C694X	\N
1362	417	\N	\N	2003	PT880	\N
15	303	unidentified	\N	\N	\N	generic placeholder for boards with an unknown OPTi chipset
23	161	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Efar chipset
1354	207	Tylersburg	\N	2008	X58	\N
30	120	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Cypress chipset
48	176	unidentified	\N	\N	\N	generic placeholder for boards with an unknown G-2 chipset
278	207	PCIset TX Triton II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430TX%20	1997-02-17	430TX	## Overview\r\n\r\nThe Intel 430TX PCIset (430TX) consists of the 82439TX System Controller (MTXC) and the 82371AB PCI\r\nISA IDE Xcelerator (PIIX4). \r\n\r\nThe 430TX supports both mobile and desktop architectures. The 430TX forms a Host-to-PCI bridge and provides the second level cache control and a full function 64-bit data path to main memory. \r\n\r\nThe MTXC integrates the cache and main memory DRAM control functions and provides bus control to transfers between the CPU, cache, main memory, and the PCI Bus. The second level (L2) cache controller supports a writeback cache policy for cache sizes of 256 Kbytes and 512 Kbytes. \r\n\r\nThe cache memory can be implemented with pipelined burst SRAMs or standard SRAMs. \r\nAn external Tag RAM is used for the address tag and an internal Tag RAM for the cache line status bits. \r\nFor the MTXC DRAM controller, six rows are supported for up to 256 Mbytes of main memory.\r\n\r\nThe MTXC is highly integrated by including the Data Path into the same BGA chip. \r\nUsing the snoop ahead feature, the MTXC allows PCI masters to achieve full PCI bandwidth. \r\nFor increased system performance, the MTXC integrates posted write and read prefetch buffers. \r\nThe 430TX integrates many Power Management features that enable the system to save power when the system resources become idle.\r\n\r\n## Features\r\n\r\n- PCI 2.1 Compliant\r\n- Supports the Universal Serial Bus (USB 1.1)\r\n- Integrated Data Path (Host Bus <=> DRAM <=> PCI) on die\r\n- Integrated DRAM Controller\r\n  * 4 Mbytes to 256 MBytes main memory\r\n  * 64-Mbit DRAM/SDRAM Technology Support\r\n  * FPM (Fast Page Mode), EDO and\r\n  * SDRAM DRAM Support\r\n  * 6 RAS Lines Available\r\n  * Integrated Programmable drive Strength for DRAM Interface\r\n  * CAS-Before-RAS Refresh, Extended Refresh and Self Refresh for EDO\r\n  * CAS-Before-RAS and Self Refresh for SDRAM\r\n\r\n- Integrated L2 Cache Controller\r\n  * 64-MB DRAM Cacheability\r\n  * Direct Mapped Organization (Write Back Only)\r\n  * Supports 256K and 512K Pipelined Burst SRAM and standard SRAM\r\n  * Cache Hit Read/Write Cycle Timings at 3-1-1-1\r\n  * Back-to-Back Read/Write Cycles at 3-1-1-1-1-1-1-1\r\n  * 64K x 32 SRAM also supported\r\n\r\n- Fully Synchronous, Minimum Latency 30/33-MHz PCI Bus Interface\r\n  * Five PCI Bus Masters (including PIIX4)\r\n  * 10 DWord PCI-to-DRAM Read Prefetch Buffer\r\n  * 18 DWord PCI-DRAM Post Buffer\r\n  * Multi-Transaction Timer to Support\r\n  * Multiple Short PCI Transactions\r\n\r\n- Power Management Features\r\n  * PCI CLKRUN# Support\r\n  * Dynamic Stop Clock Support\r\n  * Suspend to RAM (STR)\r\n  * Suspend to Disk (STD)\r\n  * Power On Suspend (POS)\r\n  * Internal Clock Control\r\n  * SDRAM and EDO Self Refresh During Suspend\r\n  * ACPI Support\r\n  * Compatible SMRAM (C_SMRAM) and Extended SMRAM (E_SMRAM)\r\n  * SMM Writeback Cacheable in E_SMRAM Mode up to 1 MB\r\n  * 3.3/5V DRAM, 3.3/5V PCI 3.3/5V Tag and 3.3/2.5 SRAM Support
47	262	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Micronics chipset
39	348	unidentified	\N	\N	\N	generic placeholder for boards with an unknown SARC chipset
34	380	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Suntac chipset
830	417	Apollo P4X266	\N	2001-08	P4X266	\N
825	417	ProSavageDDR	\N	2001-09	P4M266	\N
492	417	Apollo VPX, VPX/97	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C580VPX%20	1997-01-09	VT82C580VPX	\N
702	417	Apollo MVP4	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8501%20	1998-11-04	VT8501	\N
35	393	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Ti chipset
275	207	PCIset MX Mobile Triton	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430MX%20	1995-11-01	430MX	\N
334	207	Springdale-P	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*865P%20	2003-05-21	865P	\N
180	25	Aladdin V/V+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1541/42/33/43%20	\N	M1541/42/43/C	Overview:\r\nThe ALi Aladdin V/V+ (ALi M1541 for ATX/NLX/LPX systems, ALi M1542 for Baby AT systems) is a chipset intended for the Super Socket 7 platform and the main competitor to the VIA MVP3\r\n\r\nConfigurations:\r\nM1541/M1542 System Controller\r\nM1543 PCI-to-ISA Bus Bridge\r\n\r\nM1541 + M1543\r\nM1542 + M1543\r\nM1541 + M1543C\r\nM1542 + M1543C\r\n\r\nSpecifications:\r\n\r\nFSB 50/60/66/75/83/100 MHz\r\nPC66/100 SDRAM Support\r\nFPM and EDO Support\r\nECC Support (83 MHz or below only)\r\nAGP 2x Support\r\nATA-33 Support via ALi M1543
337	193	12/16MHz PC/AT Compatible Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*GC101/102%20	1988-02	GC101,GC102	\N
645	280	Compactest 386DX Chipset with Cache - isa 386dx no cache	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=Compactest%20	\N	MX83C30x	\N
1198	207	Bearlake-X (Digital Home)	\N	2007	X38	\N
1088	417	CastleRock	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8622/23%20	2002	CLE266	\N
525	417	K7-Twister	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8362/5%20	2000-09-26	KM133	https://www.anandtech.com/show/686
938	423	unidentified	\N	\N	\N	generic placeholder for boards with an unknown VTech chipset
514	417	ProMedia	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8601/A/T%20	2001	PLE133	\N
511	417	Apollo Pro 133A, 133+ & 133Z	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C694X/MP/Z/A%20	1999-10	VT82C694X	\N
16	170	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Forex chipset
66	73	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Atmel chipset
43	82	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Biostar chipset
49	121	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Cyrix chipset
40	194	unidentified	\N	\N	\N	generic placeholder for boards with an unknown HiNT chipset
84	201	unidentified	\N	\N	\N	generic placeholder for boards with an unknown IMS chipset
686	417	\N	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8371%20	2000-01-10	KX133	\N
840	417	ProSavageDDR	\N	2002-02	P4M266A	\N
1027	417	Apollo VPX, VPX/97	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C580VPX%20	1997-01-09	VT82C580VPX	\N
489	417	Apollo Master	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C570M%20	1994-05-30	VT82C570M	\N
276	207	PCIset HX Triton II	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82430HX%20	1996-02-12	430HX	\N
259	207	Micro Channel Compatible Peripheral Chip Set	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*82310%20	1988-04-21	82310	\N
174	25	FinALi-486 PCI Chipset	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1489/87%20	1995-02	M1489/87	\N
459	393	AT Chip Set (486, EISA)	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*TACT84500%20	1991	TACT84500	\N
1232	471	nForce4-4x	\N	2004	CK8-04	\N
1372	25	Aladdin V/V+	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*M1541/42/33/43%20	\N	ALi M1541/42/33	Overview:\r\nThe ALi Aladdin V/V+ (ALi M1541 for ATX/NLX/LPX systems, ALi M1542 for Baby AT systems) is a chipset intended for the Super Socket 7 platform and the main competitor to the VIA MVP3\r\n\r\nConfigurations:\r\nM1541/M1542 System Controller\r\nM1533 PCI-to-ISA Bus Bridge\r\n\r\nM1541 + M1533\r\nM1542 + M1533\r\n\r\nSpecifications:\r\nFSB 50/60/66/75/83/100 MHz\r\nPC66/100 SDRAM Support\r\nFPM and EDO Support\r\nECC Support (83 MHz or below only)\r\nAGP 2x Support\r\nATA-33 Support via ALi M1533
727	417	ProSavage8	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8375%20	2002-03	KM266/KL266	\N
700	417	K7-Twister Mobile	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT8362/5%20	2001	KN133	\N
1374	417	\N	\N	2002-06	K8T400	\N
1373	417	\N	\N	2002-05	P4X600	\N
17	408	unidentified	\N	\N	\N	generic placeholder for boards with an unknown UMC chipset
65	71	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Alcor chipset
80	197	unidentified	\N	\N	\N	generic placeholder for boards with an unknown IBM chipset
83	216	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Intercomp chipset
82	280	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Macronix chipset
89	364	unidentified	\N	\N	\N	generic placeholder for boards with an unknown SMD chipset
100	385	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Tandy chipset
85	414	unidentified	\N	\N	\N	generic placeholder for boards with an unknown Unichip chipset
1044	417	Flex I/386SXP	http://66.113.161.23/~mR_Slug/chipset/chipsets-v1.00.pl?big=32504&1=33837,2#32504	1990-04-13	\N	\N
858	417	\N	\N	2005-09	P4M800 Pro	\N
497	417	Apollo MVP3	http://66.113.161.23/~mR_Slug/chipset/cs-search.pl?searchOne=*VT82C598MVP%20	1997-09-22	VT82C598MVP	\N
\.


--
-- Data for Name: chipset_bios_code; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chipset_bios_code (id, chipset_id, bios_manufacturer_id, code) FROM stdin;
119	467	408	2C4X6
120	415	379	2C4I7
47	485	417	214L2
48	485	417	2A4L4
49	773	417	2A4L4
44	488	417	2A4L4
45	488	417	2A4L6
46	488	417	2C4L6
50	490	417	2A5L7
51	490	417	2A5L9
52	490	417	2A5C7
53	491	417	2A5LA
54	493	417	2A5LC
55	492	417	2A5LD
56	495	417	2A5LE
57	500	417	2A5LH
58	678	417	2A6LF
59	502	417	2A6LG
60	506	417	2A6LG
61	511	417	2A6LJ
62	523	417	2A6LK
63	678	417	3A6LF
64	495	417	6A5LE
65	500	417	6A5LH
66	507	417	6A6LG
67	514	417	6A6LI
68	511	417	6A6LJ
69	523	417	6A6LK
70	516	417	6A6LL
71	514	417	6A6LO
72	526	417	6A6LM
73	524	417	6A6LN
74	525	417	6A6LN
75	1057	417	6A6LP
76	960	417	6A6LS
77	532	417	6A6LU
78	688	417	6A6LV
79	1029	417	6A6LV
80	538	417	6A6LV
85	1030	417	6A6LY
83	726	417	6A6LY
84	540	417	6A6LY
82	539	417	6A6LY
81	537	417	6A6LY
86	825	417	6A6LW
87	829	417	6A6LW
88	796	417	6A7L0
89	800	417	6A7L1
90	849	417	6A7L2
91	853	417	6A7L2
92	847	417	6A7L2
93	855	417	6A7L2
94	857	417	6A7L2
95	543	417	6A7L3
96	861	417	6A7L4
97	806	417	6A7L5
98	805	417	6A7L7
99	859	417	6A7L6
100	877	417	6A7L8
101	511	417	IA6LJ
102	526	417	JA6LM
103	526	417	TA6LM
104	375	303	214UE
105	381	303	215UM
106	381	303	2A5UM
107	399	303	2A4UK
108	399	303	2C4UK
109	400	303	2C4UK
110	400	303	2A4UK
111	665	303	2A5UI
112	386	303	2A5UL
113	382	303	2A5UN
114	385	303	2A5UP
115	466	408	214X2
116	466	408	2C4X2
117	468	408	2A4X5
1	271	207	2A499
2	268	207	2A496
3	269	207	2A498
7	274	207	2A59C
27	748	207	2B59F
8	276	207	2A59F
5	273	207	2A59A
11	278	207	2A59I
9	277	207	2A59G
10	277	207	2A59H
15	283	207	2A69K
18	283	207	3A69K
14	285	207	2A69J
12	281	207	2A69H
16	286	207	2A69K
13	282	207	2A69J
20	290	207	6A69N
17	287	207	2A69K
19	287	207	3A69K
21	280	207	2B69D
23	293	207	6A69M
24	298	207	6A69R
22	305	207	6A69L
25	310	207	6A69P
28	311	207	6A69V
29	315	207	6A69T
43	318	207	6A69V
42	318	207	9A69V
34	320	207	6A79A
35	320	207	6A79X
26	321	207	6A69S
33	335	207	6A79W
31	334	207	6A79Y
32	333	207	6A79Z
36	336	207	6A79B
37	791	207	6A79G
41	788	207	6A79F
38	782	207	6A79D
39	782	207	6A79U
40	782	207	6A79V
6	272	207	2A59B
4	272	207	2A597
118	469	408	2A5X7
121	413	379	154I5
122	416	379	214I8
123	416	379	2C4I8
124	416	379	2C4I9
126	417	379	2A4IB
127	418	379	2A5IA
128	421	379	2A5IC
129	422	379	2A5ID
130	419	379	2A5IE
131	426	379	2A5IF
132	423	379	2A5IH
133	424	379	2A5II
134	420	379	2A5IJ
135	425	379	2A5IK
136	428	379	2A5IM
137	428	379	2A5IO
138	431	379	2A6IL
139	433	379	2A6IN
140	435	379	2A6IR
141	435	379	6A6IR
142	440	379	6A6IS
143	441	379	6A6IU
144	443	379	6A6IY
145	446	379	6A7I1
146	816	379	6A7I3
147	816	379	6A7I7
148	818	379	6A7I7
149	673	379	6A7I8
150	817	379	6A7IC
151	820	379	6A7ID
152	443	379	6A7IY
153	438	379	6A6IT
154	890	379	6A6IX
156	896	379	6A7I0
157	898	379	6A7I0
158	906	379	6A7I4
159	902	379	6A7I5
160	894	379	6A7IA
161	912	379	6A7IB
162	915	379	6A7IE
163	171	25	214K6
164	169	25	219K3
165	172	25	2A4K9
166	172	25	2A4KA
167	173	25	2A4KC
168	173	25	2C4KC
169	174	25	2A4KD
170	176	25	2A5KB
171	177	25	2A5KE
172	178	25	2A5KF
173	179	25	2A5KI
174	180	25	2A5KK
175	180	25	6A5KK
176	181	25	6A5KP
177	184	25	2A6KL
178	185	25	2A6KO
179	185	25	6A6KO
180	182	25	2A9KG
181	182	25	2A9KH
182	193	25	6A6KT
183	190	25	6A6KU
184	776	25	6A6KX
185	779	25	6A7K1
186	779	25	6A7K2
187	650	728	213V1
188	648	728	219V0
189	648	728	2C9V0
190	633	728	21480
191	633	728	214D1
192	635	728	214D1
193	1051	728	2A4H2
194	1051	728	2A4H4
195	595	728	2A4J6
196	595	728	2C4J6
197	579	728	2A5G7
198	577	728	2A5GB
199	624	728	2A5R5
200	625	728	2A5R6
201	152	728	2A5T8
202	151	728	2C4T7
203	661	728	2C460
204	404	728	2C4Y1
205	658	728	6A450
206	658	728	6A451
208	941	728	2A4Z0
209	637	728	2C470
210	608	728	2A431
211	609	728	2A432
212	609	728	2A433
213	611	728	2A434
214	611	728	6A434
215	978	728	6A660
216	980	728	6A661
217	991	728	6A662
218	994	728	6A664
219	761	728	6A6S6
220	199	728	6A6S2
221	760	728	6A6S3
222	201	728	6A6S7
223	675	379	IL6IX
155	675	379	6A6IX
225	1064	207	6A69W
224	1086	207	6A69W
226	1077	207	6A69W
229	1088	417	6A6LU
230	780	417	6A6LU
233	1095	728	6A602
207	1055	728	6A601
231	1090	728	2A434
232	1093	728	6A522
234	198	728	2A5LC
235	1106	207	6A79B
236	1107	207	6A79B
30	332	207	6A79A
238	1109	207	6A79Y
239	1110	207	6A79Y
240	1111	207	6A79Z
237	1108	207	6A79A
241	1112	207	6A79A
242	1112	207	6A79X
243	1113	207	6A79A
244	1113	207	6A79X
245	1114	207	6A79D
246	1114	207	6A79U
247	783	207	6A79D
248	783	207	6A79U
249	1115	207	6A79V
250	1115	207	6A79U
251	1115	207	6A79D
252	1116	207	6A79F
253	789	207	6A79F
254	1117	207	6A79F
255	1118	207	6A79H
256	1118	207	6A79T
257	1119	207	6A79H
258	1119	207	6A79T
259	1120	207	6A79H
260	1121	207	6A79H
261	1122	207	6A79H
262	1122	207	6A79T
263	1123	207	6A79I
264	1124	207	6A79I
265	1125	207	6A79H
266	1126	207	6A79H
267	1126	207	6A79T
268	1127	207	6A79I
269	1128	207	6A79H
270	1128	207	6A89H
271	1128	207	7A89H
272	1129	207	6A79H
273	1129	207	6A89H
274	1129	207	7A89H
275	1130	207	6A79H
276	1131	207	6A79H
277	1133	207	6A79L
278	1132	207	6A79L
279	1134	207	6A79I
280	1134	207	6A79R
281	1135	207	6A79I
282	1135	207	6A79R
283	1136	207	6A79I
284	1136	207	6A79R
285	1141	207	6A79G
286	1142	207	6A79G
287	1143	207	6A79K
288	1144	207	6A79K
289	1145	207	6A79K
290	1146	207	6A79K
291	1147	207	6A79K
292	1148	207	6A79K
293	1149	207	6A79K
294	1150	207	6A79K
295	1151	207	6A79K
296	1154	207	6A79L
297	1155	207	6A79L
298	1156	207	6A79L
299	1157	207	6A79L
300	1158	207	6A79L
301	1159	207	6A79L
302	1160	207	6A79L
303	1161	207	6A79L
304	1162	207	6A79L
305	1163	207	6A79L
306	1164	207	6A79L
307	1165	207	6A79O
308	1166	207	6A79O
309	1167	207	6A99O
310	1168	207	6A99O
311	1169	207	6A79O
312	1170	207	6A79O
313	1171	207	6A79O
314	1172	207	6A79O
315	1179	207	6A79O
316	1180	207	6A79O
317	1181	207	6A79O
318	1182	207	6A79O
319	1183	207	6A79O
320	1184	207	6A79P
321	1185	207	6A79P
322	1186	207	7A69P
323	1187	207	7A69P
324	1188	207	6A79P
325	1189	207	7A89P
326	1190	207	7A89P
327	1191	207	7A89P
328	1192	207	7A89P
329	1194	207	7A69P
330	1194	207	8A79W
331	1195	207	7A69P
332	1195	207	8A79W
333	1196	207	6A79O
334	1197	207	6A79O
335	1198	207	6A79O
336	1199	207	6A79P
337	1200	207	6A79P
338	1201	207	6A79P
339	1202	207	6A79N
340	1203	207	6A79N
341	1204	207	6A79N
342	1205	207	6A79N
343	1206	207	6A79N
345	1209	207	8A79S
344	1207	207	8A79S
346	1210	207	8A79S
347	1211	207	8A79S
348	1212	207	8A79S
349	1213	207	8A79S
350	1214	207	8A79S
351	1215	207	8A79S
352	1232	471	6A61F
353	1233	471	6A61F
354	1234	471	6A61F
355	1235	471	6A61F
356	1236	471	6A61F
357	1239	471	6A61E
358	416	379	214I9
359	634	728	214D1
360	1362	417	6A7L2
361	469	408	2A5X8
362	1367	207	6A69M
363	1371	303	2A5UN
364	1372	25	2A5KK
365	1372	25	6A5KK
\.


--
-- Data for Name: chipset_chipset_part; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chipset_chipset_part (chipset_id, chipset_part_id) FROM stdin;
168	2597
169	2599
170	2600
171	2601
172	2602
172	2603
172	2643
173	2602
173	2604
173	2605
174	2608
174	2609
175	2596
176	2606
176	2607
177	2610
177	2611
177	2612
178	2613
178	2614
179	2615
179	2616
179	2621
180	2619
180	2620
180	2621
181	2617
181	2621
181	2623
182	2638
183	2616
183	2625
184	2625
185	2617
185	2626
186	2627
187	2617
187	2628
188	2618
188	2629
189	2618
189	2630
190	2618
190	2634
191	2618
191	2635
192	2631
193	2618
193	2632
194	2618
194	2633
195	2624
195	2637
196	2636
198	2378
199	2394
200	2395
202	2397
213	2423
213	2424
213	2425
213	2426
213	2427
214	2428
214	2429
214	2430
214	2431
217	2434
217	2502
218	2442
218	2443
218	2444
218	2445
218	2446
218	2447
219	2442
219	2444
219	2445
219	2446
219	2447
219	2448
220	2442
220	2443
220	2444
220	2445
220	2446
220	2447
221	2449
221	2450
221	2451
222	2428
222	2442
222	2443
222	2444
222	2445
222	2446
222	2447
223	2428
223	2442
223	2444
223	2445
223	2446
223	2447
223	2448
224	2432
224	2433
224	2452
224	2453
224	2454
225	2458
225	2459
225	2460
226	2428
226	2431
226	2520
226	2521
227	2435
227	2501
227	2524
228	2522
228	2523
229	2502
229	2522
229	2523
230	2380
231	2529
232	2530
233	2531
256	2579
256	2580
256	2582
256	2583
256	2585
256	2586
257	2576
257	2577
257	2578
257	2581
257	2584
257	2644
257	2649
257	2657
258	2398
258	2399
262	2402
262	2403
262	2404
263	2400
263	2401
271	2406
271	2407
272	2408
272	2410
273	2409
273	2411
274	2413
274	2416
275	2354
275	2412
276	2417
291	2419
291	2420
291	2421
291	2422
361	2436
362	2437
362	2438
363	2439
364	2440
365	2441
366	2461
366	2462
367	2463
367	2464
368	2466
368	2467
369	2468
278	2418
370	2469
371	2470
371	2471
372	2464
372	2472
373	2464
373	2473
374	2465
374	2475
375	2474
376	2476
377	2478
377	2479
378	2477
378	2480
379	2481
380	2482
381	2483
381	2484
382	2485
382	2487
382	2489
383	2350
383	2485
383	2487
383	2491
384	2486
384	2488
384	2490
385	2487
385	2489
385	2492
386	2493
386	2494
387	2495
387	2496
387	2497
388	2495
388	2497
388	2498
389	2499
389	2500
390	2503
390	2504
390	2505
391	2506
391	2507
391	2509
391	2510
392	2508
393	2511
393	2512
393	2513
394	2514
395	2515
396	2516
397	2517
398	2518
399	2519
400	2525
401	2526
402	2587
402	2588
402	2589
402	2590
402	2591
402	2592
402	2593
402	2594
402	2595
409	2532
409	2533
409	2534
410	2535
410	2536
410	2537
411	2538
412	2539
412	2540
413	2541
413	2542
413	2544
413	2545
413	2546
414	2547
415	2548
416	2543
416	2549
417	2550
417	2551
418	2552
418	2553
418	2554
419	2351
419	2355
420	2358
421	2355
421	2356
422	2355
422	2357
423	2361
424	2362
424	2363
425	2364
425	2365
425	2366
426	2360
426	2367
427	2368
427	2369
428	2359
428	2366
435	2370
435	2371
436	2372
436	2373
437	2374
437	2375
438	2376
438	2377
439	2379
440	2381
440	2382
441	2383
442	2384
442	2385
443	2386
444	2389
445	2390
445	2391
445	2392
446	2393
447	2388
448	2639
460	2658
461	2660
462	2659
463	2661
463	2663
464	2662
465	2664
466	2665
466	2666
467	2667
467	2668
468	2669
468	2670
469	2671
483	2707
484	2708
485	2710
485	2711
485	2712
487	2713
487	2714
488	2715
489	2717
489	2719
490	2716
490	2718
490	2720
491	2722
491	2723
491	2725
492	2721
493	2724
493	2726
494	2724
494	2730
495	2724
495	2731
496	2728
496	2731
497	2729
497	2731
498	2731
498	2732
499	2731
499	2733
500	2740
502	2727
502	2735
503	2724
503	2734
504	2729
504	2736
505	2728
505	2736
506	2724
506	2736
507	2728
507	2737
508	2729
508	2737
509	2732
509	2737
511	2729
511	2739
516	2741
517	2743
517	2744
544	2685
544	2696
544	2702
544	2704
544	2705
545	2672
545	2678
545	2679
545	2685
545	2696
545	2702
545	2703
552	2673
552	2674
552	2675
555	2681
555	2684
567	2680
567	2682
567	2683
568	2676
568	2677
568	2686
569	2688
570	2689
571	2690
572	2687
574	2682
575	2691
575	2692
576	2693
577	2694
577	2695
578	2697
578	2698
579	2699
579	2700
579	2701
595	2747
595	2748
596	2749
597	2746
597	2750
598	2745
602	2455
603	2456
603	2457
604	2455
616	2558
616	2559
617	2559
617	2560
618	2560
618	2562
619	2561
620	2562
620	2563
621	2563
621	2564
622	2565
622	2566
623	2567
624	2568
624	2571
625	2569
625	2570
625	2572
645	2647
645	2648
646	2640
646	2641
646	2642
652	2651
652	2652
652	2653
652	2654
652	2655
652	2656
277	2751
277	2414
277	2415
278	2752
283	2754
281	2755
281	2756
281	2751
282	2757
282	2752
276	2751
274	2758
557	2759
465	2760
465	2761
450	2763
450	2764
663	2763
663	2764
663	2765
452	2766
452	2767
422	2360
664	2417
286	2754
283	2753
285	2754
554	2769
554	2684
554	2770
389	2771
665	2499
665	2500
665	2772
665	2771
410	2773
666	2519
666	2772
287	2774
287	2754
455	2777
455	2776
455	2775
285	2778
336	2805
336	2792
310	2796
310	2780
331	2811
331	2788
311	2797
311	2788
320	2803
320	2792
305	2779
305	2780
668	2779
668	2816
668	2780
298	2782
298	2780
314	2798
314	2791
306	2795
306	2788
318	2802
318	2791
299	2783
299	2788
304	2787
304	2788
293	2781
293	2780
296	2780
296	2817
301	2784
301	2788
321	2794
321	2788
303	2786
303	2780
302	2785
302	2780
332	2808
332	2792
335	2809
335	2792
300	2830
300	2826
313	2823
313	2827
312	2824
312	2827
308	2832
308	2827
309	2833
309	2827
307	2831
307	2827
327	2821
327	2828
330	2825
330	2828
315	2799
315	2791
317	2804
317	2791
316	2801
316	2791
319	2800
319	2791
326	2820
326	2828
328	2814
328	2828
334	2807
334	2792
333	2806
333	2792
324	2819
324	2828
325	2822
325	2828
323	2818
323	2828
329	2815
329	2828
322	2810
322	2788
669	2810
669	2791
431	2837
431	2366
670	2732
670	2739
671	2733
671	2739
447	2845
672	2388
672	2843
673	2387
673	2843
674	2387
674	2845
446	2843
433	2848
433	2366
445	2843
439	2841
448	2843
432	2849
432	2366
434	2850
434	2366
443	2841
675	2851
675	2841
676	2852
676	2841
677	2852
677	2842
469	2863
469	2864
678	2734
678	2727
514	2865
514	2732
679	2865
679	2733
680	2866
680	2733
516	2732
681	2741
681	2733
682	2742
682	2733
519	2867
519	2878
683	2878
683	2868
520	2879
520	2868
684	2879
684	2867
286	2883
295	2781
295	2780
667	2884
42	2613
42	2614
41	2615
41	2621
93	2368
93	2369
94	2723
94	2722
94	2725
685	2366
685	2837
123	2885
136	2886
136	2887
297	2817
297	2788
294	2781
294	2789
542	2872
523	2890
523	2732
686	2890
686	2733
526	2891
687	2891
687	2733
528	2892
528	2733
527	2893
527	2733
533	2899
533	2867
688	2899
688	2868
689	2899
689	2871
690	2899
690	2869
691	2899
691	2870
532	2897
532	2867
692	2897
692	2868
693	2911
693	2867
694	2911
694	2868
531	2896
531	2733
541	2872
543	2906
543	2872
539	2905
539	2871
695	2905
695	2872
537	2902
537	2871
696	2902
696	2872
540	2907
540	2871
697	2907
697	2872
534	2901
534	2869
698	2901
698	2871
535	2909
535	2871
542	2904
525	2894
525	2732
699	2894
699	2733
700	2900
700	2867
529	2903
529	2733
536	2871
524	2895
524	2733
515	2733
515	2912
530	2908
530	2733
513	2865
513	2867
518	2868
518	2913
522	2872
501	2914
501	2915
501	2916
501	2723
500	2729
701	2740
701	2732
702	2740
702	2733
521	2880
521	2868
703	2917
703	2920
704	2918
704	2920
705	2919
705	2920
706	2917
706	2921
707	2918
707	2921
708	2919
708	2921
709	2922
709	2926
710	2922
710	2927
711	2923
711	2926
712	2923
712	2927
713	2924
713	2926
714	2924
714	2927
715	2924
715	2928
716	2924
716	2929
717	2924
717	2930
718	2925
718	2926
719	2925
719	2927
720	2925
720	2928
721	2925
721	2929
722	2925
722	2930
723	2931
724	2932
726	2904
726	2871
538	2898
538	2868
727	2898
727	2869
728	2898
728	2871
729	2798
729	2788
731	2721
732	2935
732	2936
92	2935
92	2936
733	2615
733	2616
734	2359
734	2366
735	2939
735	2714
736	2941
737	2621
737	2625
738	2724
738	2734
739	2724
739	2734
740	2728
740	2736
741	2615
741	2621
742	2732
742	2740
742	2942
743	2943
744	2615
744	2621
745	2598
746	2364
746	2366
553	2684
553	2681
747	2944
664	2946
664	2948
749	2621
749	2628
750	2729
750	2735
751	2848
751	2366
731	2724
752	2731
752	2724
492	2724
492	2725
731	2725
753	2724
753	2721
753	2725
754	2364
754	2366
755	2370
756	2617
756	2626
757	2381
758	2366
758	2369
759	2851
199	2953
760	2394
760	2732
200	2954
761	2395
761	2733
201	2954
202	2955
198	2952
201	2397
762	2958
762	2396
763	2372
764	2959
765	2960
288	2961
288	2754
768	2962
768	2963
769	2964
769	2965
769	2966
770	2724
770	2735
486	2714
486	2709
771	2968
771	2969
771	2970
771	2971
771	2972
268	2973
268	2974
269	2975
269	2973
280	2976
280	2977
280	2978
280	2979
284	2980
279	2981
279	2982
279	2983
279	2984
772	2985
773	2986
773	2987
773	2988
773	2989
489	2720
774	2733
774	2737
775	2990
776	2618
776	2991
777	2618
777	2992
778	2624
778	2993
779	2624
779	2994
780	2871
781	2386
782	2997
782	3005
783	3001
783	3005
784	3002
784	3005
785	3003
785	3005
786	3004
786	3005
787	2998
787	3005
788	2999
788	3005
789	3000
789	3005
790	3008
790	3006
791	3007
791	3006
792	2393
792	2845
793	2386
793	2842
794	2871
795	2872
796	2871
797	2873
798	2876
799	2872
800	2873
801	2876
802	2872
803	2873
804	2876
805	2872
806	2873
807	2876
808	2876
809	2872
810	2873
811	2876
812	2873
813	2876
815	3010
815	2845
814	3009
814	2843
816	3009
816	2845
817	3011
817	2844
818	3012
818	2845
819	3013
819	2845
820	3014
820	2845
821	2874
822	2874
823	2851
823	2842
825	2882
825	2868
826	2882
826	2869
827	2882
827	2870
828	2882
828	2871
829	2881
829	2868
824	2869
824	2881
830	2881
830	2870
831	2881
831	2871
832	2881
832	2868
833	2881
833	2869
834	2881
834	2870
835	2881
835	2871
836	2881
836	2868
837	2881
837	2869
838	2881
838	2870
839	2881
839	2871
840	2868
841	2869
842	2870
843	2871
844	2910
844	2871
845	2910
845	2871
846	2872
847	2873
848	2872
849	2873
850	2872
851	2873
852	2872
853	2873
854	2872
855	2873
856	2872
857	2873
858	2934
858	2872
859	2934
859	2873
860	2872
861	2873
862	2872
863	2873
864	2874
865	2875
866	2876
867	2872
868	2873
869	2872
870	2873
871	2872
872	2873
873	2874
874	2876
875	2875
876	2872
877	2873
878	2874
879	2875
880	2876
881	2910
881	2869
882	2874
883	2875
884	2876
885	2872
886	2873
887	2874
888	2875
889	2876
890	2853
890	2841
891	2853
891	2842
892	2854
892	2841
893	2854
893	2842
894	2855
894	2841
895	2855
895	2842
896	2856
896	2843
897	2856
897	2845
898	2857
898	2843
899	2857
899	2845
900	2858
900	2843
901	2858
901	2845
902	2859
902	2843
903	2859
903	2845
904	2860
904	2843
905	2860
905	2845
906	2861
906	2843
907	2861
907	2845
908	3022
908	2844
909	3026
909	2846
910	2862
910	2843
911	2862
911	2845
912	3023
912	2844
913	3025
913	2846
914	3024
914	2846
915	3016
915	2846
916	3021
916	2843
917	3017
917	2847
918	3018
918	2847
919	3019
919	2847
920	3020
920	2847
921	2624
921	2994
922	3028
922	2841
923	3029
923	3030
546	2944
546	3031
546	3032
546	3033
546	3034
925	3039
925	2963
926	3041
927	3045
930	3047
930	3048
931	3050
931	3049
931	2950
932	3051
932	3052
933	3053
933	3054
934	2643
934	2602
249	3055
249	3056
935	3051
936	3057
937	3059
937	3058
939	3060
940	3061
940	3062
250	3063
250	3064
941	3065
941	3066
942	3068
943	3069
944	3070
945	3071
945	3072
945	3073
946	3074
946	3075
947	3076
947	3077
948	3078
948	3079
949	3080
950	3081
950	3082
952	3083
952	3084
953	3085
954	3086
956	3087
958	3091
958	3088
958	3089
958	3090
960	2893
960	2867
961	3092
962	3094
962	3095
964	3094
964	2944
965	3098
965	3097
966	3094
967	3094
967	2428
968	3094
968	2944
969	3094
969	2428
967	3095
968	3095
970	3097
970	3096
971	3100
972	2428
974	3101
974	3102
974	3103
650	3104
650	3105
975	3107
976	3106
977	3108
978	3123
978	3109
979	3123
979	3112
980	3123
980	2733
981	3123
981	2618
982	3124
982	3109
983	3124
983	2618
984	3124
984	2733
985	3115
985	3109
986	3115
986	3111
987	3115
987	3112
988	3115
988	2733
989	3115
989	2618
990	3114
990	3109
991	3114
991	3111
992	3114
992	3112
993	3114
993	2618
994	3119
994	3110
995	3119
995	3109
996	3119
996	3113
997	3119
997	3122
998	3120
998	3110
999	3120
999	3109
1000	3120
1000	3113
1001	3120
1001	3122
1002	3121
1002	3110
1003	3121
1003	3109
1004	3121
1004	3113
1005	3121
1005	3122
1006	3116
1006	3109
1007	3116
1007	2618
1008	3116
1008	2733
1009	3117
1009	3109
1010	3117
1010	2618
1011	3117
1011	2733
1012	3125
1012	3109
1013	3125
1013	2618
1014	3125
1014	2733
1015	3118
1015	3109
1016	3118
1016	2618
1017	3118
1017	2733
1018	3109
1018	3126
1019	3126
1019	3110
1020	3126
1020	3110
1021	3126
1021	3109
1022	3127
1023	3128
1023	2733
1024	3128
1024	2732
1026	3130
1027	2725
1027	2721
1027	2723
1028	2732
1028	2893
510	2733
510	2737
512	2733
512	2738
1029	2868
1029	2901
632	3131
632	3132
1030	2872
1030	3133
1031	2733
1031	3114
1032	3134
1032	3109
1033	3135
1033	3109
1034	3136
1034	2428
1035	2885
1035	3137
548	2944
548	3138
548	3139
548	3140
548	3141
349	3142
349	3143
1036	3146
1037	3144
1037	3146
1036	3145
1038	3147
1039	3149
1039	3150
1040	3151
1041	2865
1041	2867
1042	3152
1043	3153
1044	3155
1044	3156
1044	3157
1044	3158
1044	3154
1044	3159
1045	3155
1045	3156
1045	3157
1045	3158
1045	3154
1045	3160
1046	3161
1046	3154
1046	3156
1046	3157
1046	3158
1046	3159
1047	3165
1047	3166
1047	3162
1047	3163
1047	3164
1047	3167
1047	3168
1047	3169
1048	3095
1048	2446
1048	2447
1048	2445
1048	2444
1048	2443
1048	2442
1048	2428
1049	3170
1050	3171
242	3176
241	3174
241	3175
243	3173
1051	3172
1054	2626
1054	2617
266	3179
266	3178
266	3177
1055	3180
1055	3181
1056	3182
1056	3183
1056	3184
279	3094
1057	2738
1057	2867
1058	2796
1058	3185
1058	2780
1059	2753
1059	3188
290	1
1060	2761
1061	5
1061	2793
1062	9
1062	2793
1063	10
1063	3183
1064	2813
1064	2791
1065	11
1065	2793
1066	12
1066	2793
1067	7
1067	3005
1068	8
1068	3005
1069	17
1069	18
1069	3181
1070	20
1070	18
1070	14
1069	15
1071	21
1071	14
1071	26
1071	33
1072	22
1072	27
1072	14
1073	32
1073	27
1073	14
1073	34
1074	24
1074	27
1074	13
1075	31
1076	19
1076	31
1075	35
1077	2791
1077	2812
748	2409
748	2946
748	2948
748	2411
273	2950
272	2950
1078	2408
1078	2410
1078	2949
1079	2408
1079	2410
1079	2945
1079	2947
1080	2408
1080	2410
1080	2946
1080	2948
268	2949
1081	2973
1081	2974
1081	2945
1081	2947
269	2950
1082	2975
1082	2973
1082	2945
1082	2947
1083	2975
1083	2973
1083	2946
1083	2948
270	36
270	2973
270	2950
1084	36
1084	2973
1084	2945
1084	2947
1085	36
1085	2973
1085	2946
1085	2948
1086	2813
1086	2791
1086	3184
1087	10
1087	2790
1087	3184
1053	2934
1053	2874
1052	37
1052	2872
141	44
141	42
141	43
142	44
142	42
142	45
143	44
143	42
143	46
144	42
144	48
144	47
145	49
146	51
146	50
147	52
147	54
147	55
147	53
148	56
149	57
150	58
1088	41
1088	2871
780	2880
1090	70
1091	2409
1091	93
1092	94
1050	117
1093	118
1093	2732
1060	196
1060	198
1094	198
1094	199
1094	2761
1095	3180
1095	14
1097	3094
1097	217
1096	217
1096	3094
1096	2428
1098	3094
1098	217
1098	2944
1099	218
1100	220
1100	219
1101	221
1101	222
1101	223
1101	224
1101	225
1102	3094
1102	221
1102	222
1102	223
1102	224
1102	225
1103	226
1104	2755
1104	2756
1104	2946
1104	2948
1105	227
1105	2760
1106	286
1106	2805
1107	2793
1107	2805
1108	2808
1108	286
1109	286
1109	2807
1110	2791
1110	2807
1111	286
1111	2806
1112	286
1112	2803
1113	2791
1113	2803
1114	287
1114	3001
1115	287
1115	2997
1116	287
1116	3000
1117	287
1117	2999
1118	289
1118	229
1119	291
1119	3094
1120	289
1120	230
1121	291
1121	230
1122	289
1122	228
1123	289
1123	231
1124	291
1124	231
1125	290
1125	230
1126	290
1126	229
1127	290
1127	231
1128	289
1128	239
1129	291
1129	239
1130	290
1130	239
1131	289
1131	240
1132	289
1132	241
1133	289
1133	242
1134	289
1134	247
1135	291
1135	247
1136	290
1136	247
1137	289
1137	310
1138	291
1138	310
1139	289
1139	311
1140	291
1140	311
1141	3006
1141	266
1142	3006
1142	265
1143	285
1143	232
1144	285
1144	233
1145	285
1145	234
1146	285
1146	235
1147	285
1147	236
1148	288
1148	236
1149	288
1149	395
1150	285
1150	237
1151	288
1151	237
1152	285
1152	238
1153	288
1153	238
1154	294
1154	243
1155	294
1155	244
1156	295
1156	243
1157	295
1157	244
1158	296
1158	243
1159	296
1159	244
1160	297
1160	245
1161	294
1161	245
1162	295
1162	245
1163	294
1163	246
1164	295
1164	3094
1165	300
1165	251
1166	301
1166	251
1167	289
1167	248
1168	289
1168	249
1169	300
1169	250
1170	301
1170	250
1171	302
1171	250
1172	302
1172	251
1173	294
1173	252
1174	300
1174	252
1175	295
1175	252
1176	301
1176	252
1177	296
1177	252
1178	302
1178	252
1179	300
1179	253
1180	301
1180	253
1181	300
1181	254
1182	301
1182	254
1183	303
1183	254
1184	304
1184	258
1185	306
1185	258
1186	304
1186	257
1187	306
1187	257
1188	289
1188	255
1189	304
1189	259
1190	306
1190	259
1191	304
1191	260
1192	306
1192	260
1193	305
1193	256
1194	307
1194	262
1195	305
1195	261
1196	300
1196	263
1197	301
1197	263
1198	302
1198	263
1199	300
1199	264
1200	301
1200	264
1201	302
1201	264
1202	292
1202	273
1203	293
1203	273
1204	292
1204	274
1205	293
1205	274
1206	292
1206	267
1208	396
1208	397
1208	3103
1209	298
1209	275
1207	276
1207	298
1210	298
1210	277
1211	299
1211	277
1212	298
1212	278
1213	299
1213	278
1214	298
1214	279
1215	299
1215	279
1216	300
1216	312
1217	301
1217	312
1218	300
1218	313
1219	301
1219	313
1220	324
1220	314
1221	325
1221	314
1222	324
1222	315
1223	325
1223	315
1224	324
1224	316
1225	325
1225	316
1226	324
1226	317
1227	325
1227	317
1228	324
1228	391
1229	325
1229	391
1230	324
1230	392
1231	325
1231	392
1232	326
1233	326
1234	326
1235	326
1236	326
1236	398
1237	333
1237	328
1238	333
1238	328
1239	333
1239	329
1240	333
1240	329
1241	330
1242	330
1243	330
1244	330
1245	330
1246	332
1246	328
1247	332
1247	328
1248	332
1248	328
1249	332
1249	328
1250	332
1250	328
1251	326
1025	2932
725	2932
1252	326
1253	326
1254	328
1255	330
1256	327
1257	327
1258	331
1259	327
1260	326
1261	327
1262	331
1263	331
1264	398
1264	331
1265	398
1265	328
1266	398
1266	331
1267	399
1268	331
1269	400
1270	400
1271	328
1271	406
1272	406
1272	328
1273	406
1273	331
1274	406
1274	331
1275	401
1276	401
1277	401
1278	402
1279	402
1280	402
1281	402
1281	403
1282	404
1283	404
1284	3129
1284	328
1284	403
1285	404
1286	3129
1286	331
1286	403
1287	2933
1287	331
1288	357
1288	338
1289	358
1289	338
1290	360
1290	338
1291	359
1291	338
1292	361
1292	338
1293	362
1293	338
212	418
212	419
212	420
207	410
207	421
1294	408
1294	409
1296	423
1297	363
1297	338
1298	363
1298	384
1299	363
1299	386
1300	364
1300	338
1301	364
1301	384
1302	364
1302	386
1303	365
1303	385
1304	366
1304	338
1305	366
1305	384
1306	366
1306	385
1307	366
1307	386
1308	367
1308	384
1309	367
1309	385
1310	368
1310	386
1311	368
1311	384
1312	368
1312	385
1313	368
1313	386
1314	369
1314	338
1315	369
1315	384
1316	369
1316	385
1317	370
1317	338
1318	370
1318	384
1319	370
1319	385
1320	371
1320	385
1321	371
1321	386
1322	371
1322	387
1323	372
1323	387
1324	372
1324	388
1325	373
1325	385
1326	374
1326	338
1327	374
1327	384
1328	374
1328	386
1329	374
1329	386
1330	375
1330	338
1331	375
1331	386
1332	375
1332	388
1333	376
1333	388
1334	377
1334	385
1335	377
1335	386
1336	377
1336	387
1337	377
1337	388
1338	379
1338	385
1339	379
1339	386
1340	379
1340	387
1341	379
1341	388
1342	380
1342	385
1343	380
1343	386
1344	380
1344	387
1345	380
1345	388
1346	381
1346	389
1347	381
1347	390
1348	382
1348	390
1349	383
1349	390
1350	268
1351	269
1352	270
1353	271
1354	2789
1354	272
1355	306
1355	272
1356	350
1356	338
1357	2409
1357	2411
1357	2951
1358	424
1358	425
1358	426
1358	427
1359	3055
1359	428
635	444
635	2428
634	443
634	2428
633	445
633	2428
1360	452
1360	2512
1361	3171
1362	2876
458	462
458	463
458	464
1365	465
1365	466
1365	467
1365	468
1365	469
1366	2396
1366	2956
1367	2781
1367	2788
1368	470
1369	471
1369	470
342	472
289	474
526	2732
840	475
841	475
842	475
1370	3148
1370	2428
1371	2486
1371	2488
1371	476
1372	2619
1372	2620
1372	2616
184	2621
1378	2871
1377	2871
476	3158
472	3158
476	478
472	479
857	484
856	484
883	473
474	473
474	2874
801	2996
800	2996
799	2996
798	485
795	485
797	485
541	3133
1375	486
847	488
846	488
1377	485
796	490
807	489
1374	491
475	492
475	2873
843	475
470	2874
470	2934
471	39
471	2873
473	38
477	40
477	2875
478	40
478	2876
481	2877
482	2934
482	2876
\.



--
-- Data for Name: chipset_part; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chipset_part (id, description, rank) FROM stdin;
2456	\N	1
2483	\N	1
2541	\N	1
2537	\N	1
2691	\N	1
2675	\N	1
2503	\N	1
2627	\N	1
2376	\N	1
2351	\N	1
2448	\N	1
2618	\N	1
2356	\N	1
2505	\N	1
2464	\N	1
2628	\N	1
2534	\N	1
2423	\N	1
2661	\N	1
2401	\N	1
2509	\N	1
2484	\N	1
2435	\N	1
2549	\N	1
2651	\N	1
2535	\N	1
2482	\N	1
2476	\N	1
2683	\N	1
2372	\N	1
2566	\N	1
2446	\N	1
2444	\N	1
2707	\N	1
2520	\N	1
2516	\N	1
2497	\N	1
2373	\N	1
2701	\N	1
2511	\N	1
2451	\N	1
2461	\N	1
2600	\N	1
2544	\N	1
2562	\N	1
2589	\N	1
2519	\N	1
2419	\N	1
2741	\N	1
2540	\N	1
2656	\N	1
2602	\N	1
2736	\N	1
2626	\N	1
2438	\N	1
2361	\N	1
2524	\N	1
2622	\N	1
2474	\N	1
2445	\N	1
2629	\N	1
2439	\N	1
2508	\N	1
2399	\N	1
2730	\N	1
2371	\N	1
2449	\N	1
2686	\N	1
2685	\N	1
2369	\N	1
2693	\N	1
2652	\N	1
2450	\N	1
2358	\N	1
2670	\N	1
2379	\N	1
2532	\N	1
2466	\N	1
2380	\N	1
2590	\N	1
2694	\N	1
2426	\N	1
2526	\N	1
2494	\N	1
2595	\N	1
2393	\N	1
2492	\N	1
2637	\N	1
2412	\N	1
2709	\N	1
2606	\N	1
2539	\N	1
2525	\N	1
2569	\N	1
2567	\N	1
2616	\N	1
2522	\N	1
2384	\N	1
2404	\N	1
2607	\N	1
2704	\N	1
2485	\N	1
2465	\N	1
2523	\N	1
2592	\N	1
2513	\N	1
2496	\N	1
2720	\N	1
2665	\N	1
2603	\N	1
2359	\N	1
2548	\N	1
2692	\N	1
2667	\N	1
2502	\N	1
2430	\N	1
2561	\N	1
2666	\N	1
2421	\N	1
2653	\N	1
2400	\N	1
2615	\N	1
2588	\N	1
2364	\N	1
2498	\N	1
2738	\N	1
2677	\N	1
2538	\N	1
2659	\N	1
2499	\N	1
2554	\N	1
2510	\N	1
2458	\N	1
2630	\N	1
2564	\N	1
2706	\N	1
2648	\N	1
2531	\N	1
2459	\N	1
2366	\N	1
2610	\N	1
2593	\N	1
2460	\N	1
2605	\N	1
2715	\N	1
2398	\N	1
2578	\N	1
2649	\N	1
2644	\N	1
2581	\N	1
2657	\N	1
2579	\N	1
2583	\N	1
2585	\N	1
2357	\N	1
2580	\N	1
2360	\N	1
2355	\N	1
2643	\N	1
2409	\N	1
2408	\N	1
2377	\N	1
2682	\N	1
2633	\N	1
2378	\N	1
2397	\N	1
2395	\N	1
2394	\N	1
2641	\N	1
2642	\N	1
2718	\N	1
2428	\N	1
2684	\N	1
2634	\N	1
2552	\N	1
2447	\N	1
2617	\N	1
2431	\N	1
2750	\N	1
2735	\N	1
2385	\N	1
2717	\N	1
2427	\N	1
2745	\N	1
2636	\N	1
2467	\N	1
2365	\N	1
2613	\N	1
2403	\N	1
2639	\N	1
2571	\N	1
2559	\N	1
2367	\N	1
2598	\N	1
2386	\N	1
2388	\N	1
2734	\N	1
2391	\N	1
2374	\N	1
2737	\N	1
2679	\N	1
2437	\N	1
2712	\N	1
2625	\N	1
2719	\N	1
2680	\N	1
2663	\N	1
2512	\N	1
2591	\N	1
2455	\N	1
2570	\N	1
2491	\N	1
2418	\N	1
2457	\N	1
2687	\N	1
2658	\N	1
2672	\N	1
2660	\N	1
2452	\N	1
2668	\N	1
2723	\N	2
2728	\N	2
2727	\N	2
2732	\N	2
2405	\N	2
2479	\N	1
2725	\N	1
2698	\N	1
2463	\N	1
2425	\N	1
2368	\N	1
2647	\N	1
2477	\N	1
2703	\N	1
2700	\N	1
2553	\N	1
2596	\N	1
2402	\N	1
2530	\N	1
2678	\N	1
2748	\N	1
2669	\N	1
2382	\N	1
2705	\N	1
2422	\N	1
2716	\N	1
2468	\N	1
2631	\N	1
2699	\N	1
2624	\N	1
2469	\N	1
2470	\N	1
2434	\N	1
2543	\N	1
2473	\N	1
2489	\N	1
2688	\N	1
2515	\N	1
2529	\N	1
2565	\N	1
2443	\N	1
2433	\N	1
2500	\N	1
2472	\N	1
2363	\N	1
2493	\N	1
2546	\N	1
2429	\N	1
2440	\N	1
2654	\N	1
2501	\N	1
2697	\N	1
2655	\N	1
2475	\N	1
2560	\N	1
2722	\N	1
2481	\N	1
2689	\N	1
2387	\N	1
2714	\N	1
2436	\N	1
2381	\N	1
2747	\N	1
2572	\N	1
2621	\N	1
2453	\N	1
2696	\N	1
2632	\N	1
2612	\N	1
2662	\N	1
2478	\N	1
2375	\N	1
2488	\N	1
2601	\N	1
2370	\N	1
2739	\N	1
2743	\N	1
2420	\N	1
2673	\N	1
2746	\N	1
2742	\N	1
2676	\N	1
2558	\N	1
2521	\N	1
2614	\N	1
2486	\N	1
2514	\N	1
2362	\N	1
2432	\N	1
2563	\N	1
2708	\N	1
2545	\N	1
2587	\N	1
2350	\N	1
2711	\N	1
2702	\N	1
2620	\N	1
2389	\N	1
2681	\N	1
2536	\N	1
2635	\N	1
2413	\N	1
2584	\N	1
2586	\N	1
2582	\N	1
2664	\N	1
2550	\N	1
2551	\N	1
2414	\N	1
2410	\N	1
2608	\N	1
2506	\N	1
2471	\N	1
2604	\N	1
2594	\N	1
2695	\N	1
2740	\N	1
2640	\N	1
2599	\N	1
2480	\N	1
2441	\N	1
2611	\N	1
2547	\N	1
2517	\N	1
2504	\N	1
2406	\N	1
2638	\N	1
2542	\N	1
2674	\N	1
2507	\N	1
2354	\N	1
2518	\N	1
2568	\N	1
2495	\N	1
2383	\N	1
2597	\N	1
2392	\N	1
2690	\N	1
2623	\N	1
2454	\N	1
2713	\N	1
2619	\N	1
2442	\N	1
2533	\N	1
2390	\N	1
2490	\N	1
2487	\N	1
2744	\N	1
2749	\N	1
2726	\N	1
2462	\N	1
2424	\N	1
2407	\N	1
2755	\N	1
2756	\N	1
2753	\N	1
2757	\N	1
2417	\N	1
2416	\N	1
2576	\N	1
2577	\N	1
2759	\N	1
2760	\N	1
2761	\N	1
2762	\N	1
2763	\N	1
2764	\N	1
2765	\N	1
2766	\N	1
2767	\N	1
2769	\N	1
2770	\N	1
2771	\N	1
2772	\N	1
2773	\N	1
2774	\N	1
2775	\N	1
2776	\N	1
2777	\N	1
2778	\N	1
2779	\N	1
2784	\N	1
2785	\N	1
2793	\N	1
2794	\N	1
2781	\N	1
2786	\N	1
2782	\N	1
2783	\N	1
2787	\N	1
2795	\N	1
2796	\N	1
2797	\N	1
2798	\N	1
2799	\N	1
2800	\N	1
2801	\N	1
2802	\N	1
2803	\N	1
2804	\N	1
2805	\N	1
2806	\N	1
2807	\N	1
2808	\N	1
2809	\N	1
2810	\N	1
2811	\N	1
2812	\N	1
2813	\N	1
2814	\N	1
2815	\N	1
2816	\N	1
2817	\N	1
2818	\N	1
2819	\N	1
2820	\N	1
2724	\N	2
2733	\N	2
2754	\N	2
2780	\N	2
2789	\N	2
2788	\N	2
2790	\N	2
2791	\N	2
2792	\N	2
2752	\N	2
2758	\N	2
2751	\N	2
2415	\N	2
2821	\N	1
2822	\N	1
2823	\N	1
2824	\N	1
2825	\N	1
2831	\N	1
2832	\N	1
2833	\N	1
2830	\N	1
2837	\N	1
2841	\N	1
2842	\N	1
2843	\N	1
2844	\N	1
2845	\N	1
2847	\N	1
2848	\N	1
2849	\N	1
2850	\N	1
2851	\N	1
2852	\N	1
2853	\N	1
2854	\N	1
2855	\N	1
2856	\N	1
2857	\N	1
2858	\N	1
2859	\N	1
2860	\N	1
2861	\N	1
2862	\N	1
2671	\N	1
2863	\N	1
2864	\N	1
2865	\N	1
2866	\N	1
2609	\N	1
2878	\N	1
2879	\N	1
2880	\N	1
2881	\N	1
2882	\N	1
2883	\N	1
2411	\N	1
2884	\N	1
2885	\N	1
2886	\N	1
2887	\N	1
2889	\N	1
2890	\N	1
2891	\N	1
2892	\N	1
2893	\N	1
2894	\N	1
2895	\N	1
2896	\N	1
2897	\N	1
2898	\N	1
2899	\N	1
2900	\N	1
2901	\N	1
2902	\N	1
2904	\N	1
2905	\N	1
2906	\N	1
2907	\N	1
2903	\N	1
2908	\N	1
2909	\N	1
2910	\N	1
2911	\N	1
2912	\N	1
2913	\N	1
2914	\N	1
2915	\N	1
2916	\N	1
2917	\N	1
2918	\N	1
2919	\N	1
2920	\N	1
2921	\N	1
2922	\N	1
2923	\N	1
2924	\N	1
2925	\N	1
2926	\N	1
2927	\N	1
2928	\N	1
2929	\N	1
2930	\N	1
2931	\N	1
2932	\N	1
2933	\N	1
2934	\N	1
2935	\N	1
2936	\N	1
2938	\N	1
2937	\N	1
2939	\N	1
2941	\N	1
2942	\N	1
2943	\N	1
2944	\N	1
2721	\N	1
2952	\N	1
2953	\N	1
2954	\N	1
2955	\N	1
2396	\N	1
2956	\N	1
2957	\N	1
2958	\N	1
2961	\N	1
2962	\N	1
2963	\N	1
2964	\N	1
2965	\N	1
2966	\N	1
2968	\N	1
2969	\N	1
2970	\N	1
2971	\N	1
2972	\N	1
2973	\N	1
2974	\N	1
2975	\N	1
2976	\N	1
2977	\N	1
2978	\N	1
2979	\N	1
2980	\N	1
2981	\N	1
2982	\N	1
2983	\N	1
2984	\N	1
2985	\N	1
2986	\N	1
2987	\N	1
2988	\N	1
2989	\N	1
2960	\N	1
2959	\N	1
2991	\N	1
2992	\N	1
2993	\N	1
2994	\N	1
2995	\N	1
2996	\N	1
2997	\N	1
2998	\N	1
2999	\N	1
3000	\N	1
3001	\N	1
3002	\N	1
3003	\N	1
3004	\N	1
3007	\N	1
3008	\N	1
3009	\N	1
3010	\N	1
3011	\N	1
3012	\N	1
3013	\N	1
3014	\N	1
3015	\N	1
3016	\N	1
3017	\N	1
3018	\N	1
3019	\N	1
3020	\N	1
3021	\N	1
3022	\N	1
3023	\N	1
3024	\N	1
3025	\N	1
3026	\N	1
3027	\N	1
3028	\N	1
3029	\N	1
3030	\N	1
3032	\N	1
3033	\N	1
3035	\N	1
3036	\N	1
3037	\N	1
3038	\N	1
3039	\N	1
3034	\N	1
3040	\N	1
3041	\N	1
3045	\N	1
3046	\N	1
3047	\N	1
3048	\N	1
3049	\N	1
3050	\N	1
3051	\N	1
3052	\N	1
3053	\N	1
3054	\N	1
2990	\N	1
2869	\N	2
2870	\N	2
2871	\N	2
2867	\N	2
2873	\N	2
2872	\N	2
2874	\N	2
2875	\N	2
2877	\N	2
2826	\N	2
2827	\N	2
2828	\N	2
2829	\N	2
3005	\N	2
3006	\N	2
2951	\N	2
2949	\N	2
2948	\N	2
2947	\N	2
2946	\N	2
2945	\N	2
2846	\N	2
3055	\N	1
3056	\N	1
3057	\N	1
3058	\N	1
3059	\N	1
3060	\N	1
3061	\N	1
3062	\N	1
3063	\N	1
3064	\N	1
3065	\N	1
3066	\N	1
3069	\N	1
3070	\N	1
3071	\N	1
3072	\N	1
3073	\N	1
3074	\N	1
3075	\N	1
3076	\N	1
3077	\N	1
3078	\N	1
3079	\N	1
3080	\N	1
3081	\N	1
3082	\N	1
3083	\N	1
3084	\N	1
3085	\N	1
3086	\N	1
3087	\N	1
3067	\N	1
3068	\N	1
3088	\N	1
3091	\N	1
3089	\N	1
3090	\N	1
3092	\N	1
3095	\N	1
3094	\N	1
3096	\N	1
3098	\N	1
3097	\N	1
3100	\N	1
3101	\N	1
3102	\N	1
3103	\N	1
3104	\N	1
3105	\N	1
3106	\N	1
3107	\N	1
3108	\N	1
3110	\N	1
3111	\N	1
3113	\N	1
3114	\N	1
3115	\N	1
3116	\N	1
3117	\N	1
3118	\N	1
3119	\N	1
3120	\N	1
3121	\N	1
3122	\N	1
3123	\N	1
3124	\N	1
3125	\N	1
3126	\N	1
3109	\N	1
3112	\N	1
3127	\N	1
3128	\N	1
3031	\N	1
3129	\N	1
3130	\N	1
3131	\N	1
3132	\N	1
3133	\N	1
3134	\N	1
3135	\N	1
3136	\N	1
3137	\N	1
3138	\N	1
3139	\N	1
3140	\N	1
3141	\N	1
3142	\N	1
3143	\N	1
3144	\N	1
3145	\N	1
3146	\N	1
3147	\N	1
3148	\N	1
3150	\N	1
3149	\N	1
3151	\N	1
3152	\N	1
3153	\N	1
3155	\N	1
3156	\N	1
3157	\N	1
3161	\N	1
3162	\N	1
3163	\N	1
3164	\N	1
3165	\N	1
3166	\N	1
3167	\N	1
3168	\N	1
3169	\N	1
3170	\N	1
3171	\N	1
3172	\N	1
3173	\N	1
3174	\N	1
3175	\N	1
3176	\N	1
3177	\N	1
3178	\N	1
3179	\N	1
3180	\N	1
3181	\N	1
3182	\N	1
3184	\N	1
3185	\N	1
3186	\N	1
3187	\N	1
3188	\N	1
1	\N	1
4	\N	1
5	\N	1
6	\N	1
7	\N	1
8	\N	1
9	\N	1
10	\N	1
11	\N	1
12	\N	1
13	\N	1
14	\N	1
15	\N	1
16	\N	1
17	\N	1
18	\N	1
19	\N	1
20	\N	1
21	\N	1
22	\N	1
23	\N	1
24	\N	1
25	\N	1
26	\N	1
27	\N	1
28	\N	1
29	\N	1
31	\N	1
32	\N	1
33	\N	1
34	\N	1
35	\N	1
36	\N	1
37	\N	1
38	\N	1
39	\N	1
40	\N	1
41	\N	1
42	\N	1
43	\N	1
44	\N	1
45	\N	1
46	\N	1
47	\N	1
48	\N	1
49	\N	1
50	\N	1
51	\N	1
52	\N	1
53	\N	1
54	\N	1
55	\N	1
56	\N	1
57	\N	1
58	\N	1
70	\N	1
93	\N	1
94	\N	1
117	\N	1
118	\N	1
193	\N	1
195	\N	1
196	\N	1
198	\N	1
199	\N	1
217	\N	1
218	\N	1
219	\N	1
220	\N	1
221	\N	1
222	\N	1
223	\N	1
224	\N	1
225	\N	1
226	\N	1
227	\N	1
228	\N	1
229	\N	1
230	\N	1
231	\N	1
232	\N	1
233	\N	1
234	\N	1
235	\N	1
236	\N	1
237	\N	1
238	\N	1
239	\N	1
240	\N	1
241	\N	1
242	\N	1
3	\N	2
2	\N	2
3158	Integrated Peripheral Controller	1
3154	Universal PC/AT Clock Chip	1
243	\N	1
244	\N	1
245	\N	1
246	\N	1
247	\N	1
248	\N	1
249	\N	1
250	\N	1
251	\N	1
252	\N	1
253	\N	1
254	\N	1
255	\N	1
256	\N	1
257	\N	1
258	\N	1
259	\N	1
260	\N	1
261	\N	1
262	\N	1
263	\N	1
264	\N	1
265	\N	1
266	\N	1
267	\N	1
268	\N	1
269	\N	1
270	\N	1
271	\N	1
272	\N	1
273	\N	1
274	\N	1
275	\N	1
276	\N	1
277	\N	1
278	\N	1
279	\N	1
280	\N	1
281	\N	1
282	\N	1
283	\N	1
284	\N	1
308	\N	1
309	\N	1
310	\N	1
311	\N	1
312	\N	1
313	\N	1
314	\N	1
315	\N	1
316	\N	1
317	\N	1
318	\N	1
319	\N	1
320	\N	1
321	\N	1
322	\N	1
323	\N	1
324	\N	1
325	\N	1
326	\N	1
327	\N	1
328	\N	1
329	\N	1
330	\N	1
331	\N	1
332	\N	1
333	\N	1
334	\N	1
335	\N	1
336	\N	1
337	\N	1
338	\N	1
339	\N	1
340	\N	1
341	\N	1
342	\N	1
343	\N	1
344	\N	1
345	\N	1
346	\N	1
347	\N	1
348	\N	1
349	\N	1
350	\N	1
351	\N	1
352	\N	1
353	\N	1
354	\N	1
355	\N	1
356	\N	1
357	\N	1
358	\N	1
359	\N	1
360	\N	1
361	\N	1
362	\N	1
363	\N	1
364	\N	1
365	\N	1
366	\N	1
367	\N	1
368	\N	1
369	\N	1
370	\N	1
371	\N	1
372	\N	1
373	\N	1
374	\N	1
375	\N	1
376	\N	1
377	\N	1
378	\N	1
379	\N	1
380	\N	1
381	\N	1
382	\N	1
383	\N	1
384	\N	1
385	\N	1
386	\N	1
387	\N	1
388	\N	1
389	\N	1
390	\N	1
391	\N	1
392	\N	1
393	\N	1
394	\N	1
395	\N	1
396	\N	1
397	\N	1
398	\N	1
399	\N	1
400	\N	1
401	\N	1
402	\N	1
403	\N	1
404	\N	1
405	\N	1
406	\N	1
407	\N	1
408	\N	1
409	\N	1
410	\N	1
411	\N	1
412	\N	1
413	\N	1
414	\N	1
415	\N	1
416	\N	1
417	\N	1
418	\N	1
419	\N	1
420	\N	1
421	\N	1
422	\N	1
423	\N	1
424	\N	1
425	\N	1
426	\N	1
427	\N	1
428	\N	1
443	\N	1
444	\N	1
445	\N	1
452	\N	1
462	\N	1
463	\N	1
464	\N	1
465	\N	1
466	\N	1
467	\N	1
468	\N	1
469	\N	1
470	\N	1
471	\N	1
472	\N	1
473	\N	1
474	\N	1
475	\N	1
476	\N	1
2729	\N	2
2868	\N	2
2876	\N	2
2710	\N	2
300	\N	2
306	\N	2
286	\N	2
287	\N	2
289	\N	2
285	\N	2
290	\N	2
288	\N	2
291	\N	2
294	\N	2
293	\N	2
296	\N	2
292	\N	2
297	\N	2
295	\N	2
307	\N	2
305	\N	2
304	\N	2
301	\N	2
303	\N	2
302	\N	2
299	\N	2
298	\N	2
2731	##Overview\r\n\r\nThe VIA Apollo MVP3 aka VT82C598MVP is a Single-Chip Socket-7 / Super-7 North Bridge for Desktop and Mobile PC Systems with AGP and PCI plus Advanced ECC Memory Controller supporting SDRAM, EDO, and FPG ram.\r\n\r\n## Features\r\n\r\n### WIP\r\n\r\n- Interfaces\r\n  * AGP / PCI / ISA / ISA Mobile\r\n  * Single chip implementation for 64-bit Socket-7-CPU Host Bus, 64-bit system memory, 32-bit PCI and 32-bit AGP interfaces\r\n  * Supports 3.3V and sub-3.3V interface to CPU\r\n  * Supports separately powered 3.3V (5V tolerant) interface to system memory, AGP, and PCI bus\r\n  * PC-97 compatible using VIA VT82C586B (208-pin PQFP) south bridge chip with ACPI Power Management\r\n  * Modular power management and clock control for mobile system applications\r\n\r\n- Integration\r\n  * VT82C598MVP system controller with PCI link to VT82C586B PCI to ISA bridge\r\n  * VT82C586B also includes UltraDMA-33 EIDE, USB, and Keyboard / PS2-Mouse Interfaces plus RTC / CMOS on chip\r\n  * Can be combined with VIA VT82C596 (Intel PIIX4 pin compatible 324-pin BGA) “Mobile South” south bridge chip\r\n\r\n- CPU Interface\r\n  * Supports all Socket-7 processors including 64-bit Intel Pentium / Pentium with MMX, AMD K6, Cyrix/IBM 6X86 / 6X86MX, and IDT/Centaur C6 CPUs\r\n  * 66 / 75 / 83 / 100 MHz CPU external bus speed (internal 300MHz and above)\r\n  * Built-in deskew DLL (Delay Lock Loop) circuitry for optimal skew control within and between clocking regions\r\n  * Cyrix/IBM 6X86 linear burst support\r\n  * AMD K6 write allocation support\r\n  * System management interrupt, memory remap and STPCLK mechanism\r\n\r\n- Advanced Cache Controller\r\n  * Direct map write back or write through secondary cache\r\n  * Pipelined burst synchronous SRAM (PBSRAM) cache support\r\n  * Flexible cache size: 0K / 256K / 512K / 1M / 2MB\r\n  * 32 byte line size to match the primary cache\r\n  * Integrated 8-bit tag comparator\r\n  * 3-1-1-1-1-1-1-1 back to back read timing for PBSRAM access up to 100 MHz\r\n  * Tag timing optimized (less than 4ns setup time) to allow external tag SRAM implementation for most flexible cache organization\r\n  * Sustained 3 cycle write access for PBSRAM access or CPU to DRAM & PCI bus post write buffers up to 100 MHz\r\n  * Supports CPU single read cycle L2 allocation\r\n  * System and video BIOS cacheable and write-protect\r\n  * Programmable cacheable region	1
477	\N	1
3183	\N	2
2950	\N	2
478	80386SX System and Memory Controller	1
479	80386DX System and Memory Controller	1
480	80386DX Page Interleave Memory Controller	1
481	80386SX Page Interleave Memory Controller	1
3159	80386SX Page Mode Memory Controller (16/20MHz 8MB)	1
3160	80386DX Page Mode Memory Controller (16-25MHz 16MB)	1
482	Power Management Unit	1
483	80286 Page Interleave Memory Controller (16-25MHz)	1
484	\N	1
485	\N	1
486	\N	1
487	\N	1
488	\N	1
489	\N	1
490	\N	1
491	\N	1
492	\N	1
493	\N	1
494	\N	1
496	\N	1
495	\N	2
\.


--
-- Data for Name: coprocessor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.coprocessor (id) FROM stdin;
964
965
967
968
969
970
972
976
977
978
979
982
983
980
1567
1614
1615
1616
1617
1618
1619
1620
1621
1622
1623
1624
1625
1626
1627
1628
1630
1631
1632
1633
1634
1635
1636
1637
1638
1639
1640
1641
1642
1643
1645
1646
1647
1749
1750
1751
1752
1753
1754
1755
1756
1757
1758
1759
1760
1761
1762
1763
1764
1765
1766
1767
1768
1769
1770
1771
1772
1773
1774
1775
1776
1777
1778
1779
1780
1781
1782
1783
1784
1785
1786
1787
1788
1789
1790
1791
1792
1793
1794
1795
1796
1797
1798
1799
1800
1801
1802
1803
1804
1805
1806
1807
1808
1809
1810
1811
1812
1813
1814
1815
1816
1817
1818
1819
1820
1821
1822
\.


--
-- Data for Name: cpu_socket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cpu_socket (id, name, type) FROM stdin;
11	Slot 1	Slot-242
23	Slot A	Slot-242
24	Slot 2	Slot-330
27	Socket 604	mPGA604
14	Socket 478	mPGA478
10	Socket 370	PGA370
7	Socket 1	PGA169
17	Socket A	PGA462
26	Socket 603	mPGA603
12	\N	PGA168
16	Socket T	LGA775
13	\N	PGA132
33	\N	PGA128
34	\N	PGA179
36	\N	PGA431
15	Socket 423	PGA423
39	\N	PLCC44
28	\N	DIP40
40	\N	PGA169
30	\N	PLCC68
38	\N	PQFP100
37	\N	PQFP132
31	\N	CLCC68
35	\N	PGA206
29	\N	PGA68
18	Socket 563	mPGA563
25	Socket 479	mPGA479M
22	Socket AM2	mPGA940
19	Socket 754	mPGA754
20	Socket 939	mPGA939
21	Socket 940	mPGA940
6	Socket 2	PGA238
5	Socket 3	PGA237
1	Socket 4	PGA273
3	Socket 5	PGA320
4	Socket 7	PGA321
9	Socket 8	PGA387
32	Socket 6	PGA235
41	EBGA	BGA368
42	NanoBGA2	BGA400
43	\N	PGA121
44	\N	PQFP68
45	\N	PGA183
46	\N	PGA463
47	Socket 499	PGA499
48	\N	PGA413
49	\N	PGA124
50	\N	BGA352
51	\N	PQFP216
52	\N	PQFP144
53	\N	PQFP208
54	\N	PQFP196
55	Socket AM2+	mPGA940
56	Socket AM3	mPGA941
2	\N	BGA516
8	\N	BGA474
57	\N	BGA399
58	\N	PGA144
59	\N	BGA686
\.


--
-- Data for Name: cpu_socket_processor_platform_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cpu_socket_processor_platform_type (cpu_socket_id, processor_platform_type_id) FROM stdin;
1	26
3	8
4	9
4	8
4	42
5	4
5	5
6	4
6	5
7	4
9	10
10	45
10	25
10	44
11	12
4	53
12	4
13	3
15	27
18	49
19	33
21	39
23	31
24	13
25	29
26	6
27	6
27	21
28	14
28	23
29	2
29	41
29	54
28	55
30	2
31	2
14	27
16	27
32	5
33	57
34	58
35	59
36	60
37	3
38	22
28	62
28	63
28	64
30	66
39	63
39	64
7	67
6	67
5	67
40	67
41	48
10	48
42	68
25	68
43	65
44	3
44	22
45	69
46	11
48	60
47	60
37	57
49	57
50	53
51	2
52	3
53	22
56	72
17	31
29	65
50	70
2	73
50	74
17	75
4	76
17	77
17	79
4	78
11	80
11	81
11	25
21	34
19	82
20	33
20	35
20	39
20	34
22	33
22	35
22	39
22	34
55	33
55	35
55	39
55	34
16	83
16	47
55	71
55	72
22	71
22	72
8	92
16	93
16	94
16	95
58	96
27	86
27	87
27	88
27	89
26	21
26	86
40	4
59	97
\.


--
-- Data for Name: cpu_speed; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cpu_speed (id, value) FROM stdin;
1	10
2	100
3	110
4	12
5	12.5
6	120
7	125
8	130
9	133
10	14
11	15
12	150
13	16
14	160
15	166
16	180
17	187
18	188
19	20
20	200
21	210
22	22
23	225
24	233
25	235
26	24
27	240
28	25
29	250
30	266
31	270
32	275
33	28
34	283
35	30
36	300
37	325
38	33
39	333
40	35
41	350
42	366
43	380
44	4
45	4.77
46	40
47	400
48	433
49	450
50	466
51	5
52	50
53	500
54	533
55	55
56	550
57	566
58	6
59	60
60	600
61	63
62	633
63	650
64	66
66	7
67	7.16
68	7.33
69	700
70	75
71	8
72	80
73	83
74	9.54
75	9.83
76	90
77	475
78	262
79	290
80	733
81	766
82	800
83	850
84	866
85	900
86	933
87	950
88	1000
89	1100
90	1133
91	750
92	1200
93	1266
94	1300
95	1333
96	1400
97	1467
98	1500
99	1533
100	1600
101	1667
102	1700
103	1583
104	1733
105	1750
106	1800
107	1833
109	1900
110	1917
111	2000
112	2083
113	2133
114	2100
115	2166
116	2200
117	2250
118	2300
119	2333
121	2400
122	2500
123	2533
124	2600
126	2700
127	2800
128	2933
129	2900
130	3000
131	3066
132	3167
133	3200
134	3333
135	3400
137	3600
138	3733
139	3800
140	3100
141	1066
142	95
143	97
144	96.2
65	667
145	116
146	105
147	570
148	2833
149	3700
150	3500
151	3300
108	1867
120	2267
136	3467
125	2667
152	2.5
153	1
154	16.67
155	37.5
156	42
157	46.5
158	51
159	55.5
160	84
161	93
162	102
163	111
164	70
165	207
166	285
167	112
168	3666
169	115
170	122
171	124
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20211027215426	2021-10-30 20:18:44	454
DoctrineMigrations\\Version20220120221449	2022-01-31 19:42:04	489
DoctrineMigrations\\Version20220131194330	2022-01-31 19:44:18	32
DoctrineMigrations\\Version20220202112114	2022-02-02 23:28:38	44
DoctrineMigrations\\Version20220202232913	2022-02-02 23:30:45	229
DoctrineMigrations\\Version20220202233503	2022-02-02 23:36:50	98
\.


--
-- Data for Name: dram_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dram_type (id, name) FROM stdin;
1	BEDO
4	SDRAM
5	30-pin SIMM
6	30-pin SIPP
3	72-pin FPM
7	168-pin EDO
2	72-pin EDO
8	DDR SDRAM
9	DDR2 SDRAM
10	RDRAM
11	VCM SDRAM
12	144-pin SDRAM
13	DDR3 SDRAM
14	DDR2 FB-DIMM
\.


--
-- Data for Name: dump_quality_flag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dump_quality_flag (id, name, tag_name) FROM stdin;
1	Undetermined Conformity	undetermined
2	Broken Copy	broken
3	Functional Copy	functional
4	Restored Copy	restored
5	Perfect Copy	perfect
\.


--
-- Data for Name: expansion_connector; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.expansion_connector (id, name) FROM stdin;
\.


--
-- Data for Name: expansion_slot; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.expansion_slot (id, name, hidden_search) FROM stdin;
1	32-bit PCI	f
2	64-bit PCI	f
3	3.3V AGP	f
4	32-bit VLB	f
5	8-bit ISA	f
6	16-bit ISA	f
7	32-bit EISA	f
10	PISA	f
11	32-bit MCA	f
12	16-bit MCA	f
13	1.5V AGP	f
14	Universal AGP	f
15	AMR	f
16	CNR	f
17	ACR	f
18	3.3V AGP Pro	f
19	Universal AGP Pro	f
20	1.5V AGP Pro	f
8	Asus MediaBus 2.0	f
9	Asus MediaBus	f
21	AGP (add-on card)	f
23	64-bit PCI-X	f
26	PCIe x16	f
27	PCIe x4	f
28	PCIe x1	f
29	PCIe x16 @ x4	f
35	32-bit mini-PCI	f
36	OPTi Local Bus	f
25	ASRock Future CPU Port	t
31	EPoX AGX	t
32	ECS AGP Express	t
41	QDI XGP	t
37	ASUS WiFi Slot	t
34	RAID Port	t
24	ASRock AGI	t
30	Biostar XGP	t
33	ASRock HDMR	t
42	PTI (Panel TV Out)	t
38	HP/Compaq Multibay	t
45	Ether-SCSI	t
43	ECS Local Bus	t
46	Intel AT-32	t
44	32-bit CompactPCI	t
39	16-bit PCMCIA	t
40	32-bit PCMCIA	f
47	TV-Out/LCD Riser	t
48	Mini-PCIe	f
49	ASUS SupremeFX slot	f
50	Gigabyte G.E.A.R.	t
51	DFI GPA	t
22	[to be reused]	t
\.


--
-- Data for Name: form_factor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.form_factor (id, name) FROM stdin;
1	XT
2	AT
3	LPX
4	ATX
5	Baby AT
7	microATX
6	Single Board Computer
9	PC/104
10	BookPC
11	NLX
13	FlexATX
8	mini-ITX
12	OEM / Proprietary
14	PC (IBM)
15	microATX w/ATX add-on
17	SSI
18	Extended ATX
19	WTX
20	picoBTX
\.


--
-- Data for Name: id_redirection; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.id_redirection (id, source, source_type, dtype) FROM stdin;
1	30001	th99	motherboardidredirection
2	30002	th99	motherboardidredirection
3	30003	th99	motherboardidredirection
4	30005	th99	motherboardidredirection
5	30006	th99	motherboardidredirection
6	30007	th99	motherboardidredirection
7	30008	th99	motherboardidredirection
8	30009	th99	motherboardidredirection
9	30010	th99	motherboardidredirection
10	30011	th99	motherboardidredirection
11	30012	th99	motherboardidredirection
12	30013	th99	motherboardidredirection
13	30014	th99	motherboardidredirection
14	30015	th99	motherboardidredirection
15	30016	th99	motherboardidredirection
16	30017	th99	motherboardidredirection
17	30018	th99	motherboardidredirection
18	30019	th99	motherboardidredirection
19	30020	th99	motherboardidredirection
20	30021	th99	motherboardidredirection
21	30022	th99	motherboardidredirection
22	30024	th99	motherboardidredirection
23	30025	th99	motherboardidredirection
24	30026	th99	motherboardidredirection
25	30027	th99	motherboardidredirection
26	30028	th99	motherboardidredirection
27	30029	th99	motherboardidredirection
28	30030	th99	motherboardidredirection
29	30031	th99	motherboardidredirection
30	30032	th99	motherboardidredirection
31	30033	th99	motherboardidredirection
32	30034	th99	motherboardidredirection
33	30035	th99	motherboardidredirection
34	30036	th99	motherboardidredirection
35	30038	th99	motherboardidredirection
36	30039	th99	motherboardidredirection
37	30040	th99	motherboardidredirection
38	30041	th99	motherboardidredirection
39	30042	th99	motherboardidredirection
40	30043	th99	motherboardidredirection
41	30044	th99	motherboardidredirection
42	30045	th99	motherboardidredirection
43	30046	th99	motherboardidredirection
44	30047	th99	motherboardidredirection
45	30048	th99	motherboardidredirection
46	30049	th99	motherboardidredirection
47	30050	th99	motherboardidredirection
48	30051	th99	motherboardidredirection
49	30052	th99	motherboardidredirection
50	30053	th99	motherboardidredirection
51	30054	th99	motherboardidredirection
52	30055	th99	motherboardidredirection
53	30056	th99	motherboardidredirection
54	30057	th99	motherboardidredirection
55	30058	th99	motherboardidredirection
56	30059	th99	motherboardidredirection
57	30060	th99	motherboardidredirection
58	30062	th99	motherboardidredirection
59	30064	th99	motherboardidredirection
60	30067	th99	motherboardidredirection
61	30068	th99	motherboardidredirection
62	30069	th99	motherboardidredirection
63	30070	th99	motherboardidredirection
64	30071	th99	motherboardidredirection
65	30072	th99	motherboardidredirection
66	30073	th99	motherboardidredirection
67	30074	th99	motherboardidredirection
68	30075	th99	motherboardidredirection
69	30076	th99	motherboardidredirection
70	30077	th99	motherboardidredirection
71	30078	th99	motherboardidredirection
72	30079	th99	motherboardidredirection
73	30080	th99	motherboardidredirection
74	30081	th99	motherboardidredirection
75	30082	th99	motherboardidredirection
76	30083	th99	motherboardidredirection
77	30084	th99	motherboardidredirection
78	30085	th99	motherboardidredirection
79	30086	th99	motherboardidredirection
80	30087	th99	motherboardidredirection
81	30088	th99	motherboardidredirection
82	30089	th99	motherboardidredirection
83	30090	th99	motherboardidredirection
84	30091	th99	motherboardidredirection
85	30092	th99	motherboardidredirection
86	30093	th99	motherboardidredirection
87	30099	th99	motherboardidredirection
88	30100	th99	motherboardidredirection
89	30101	th99	motherboardidredirection
90	30102	th99	motherboardidredirection
91	30103	th99	motherboardidredirection
92	30104	th99	motherboardidredirection
93	30105	th99	motherboardidredirection
94	30106	th99	motherboardidredirection
95	30107	th99	motherboardidredirection
96	30108	th99	motherboardidredirection
97	30109	th99	motherboardidredirection
98	30110	th99	motherboardidredirection
99	30111	th99	motherboardidredirection
100	30112	th99	motherboardidredirection
101	30113	th99	motherboardidredirection
102	30114	th99	motherboardidredirection
103	30115	th99	motherboardidredirection
104	30117	th99	motherboardidredirection
105	30118	th99	motherboardidredirection
106	30119	th99	motherboardidredirection
107	30121	th99	motherboardidredirection
108	30122	th99	motherboardidredirection
109	30123	th99	motherboardidredirection
110	30125	th99	motherboardidredirection
111	30126	th99	motherboardidredirection
112	30127	th99	motherboardidredirection
113	30128	th99	motherboardidredirection
114	30129	th99	motherboardidredirection
115	30130	th99	motherboardidredirection
116	30131	th99	motherboardidredirection
117	30132	th99	motherboardidredirection
118	30133	th99	motherboardidredirection
119	30134	th99	motherboardidredirection
120	30135	th99	motherboardidredirection
121	30136	th99	motherboardidredirection
122	30137	th99	motherboardidredirection
123	30138	th99	motherboardidredirection
124	30139	th99	motherboardidredirection
125	30140	th99	motherboardidredirection
126	30141	th99	motherboardidredirection
127	30142	th99	motherboardidredirection
128	30143	th99	motherboardidredirection
129	30144	th99	motherboardidredirection
130	30145	th99	motherboardidredirection
131	30146	th99	motherboardidredirection
132	30147	th99	motherboardidredirection
133	30148	th99	motherboardidredirection
134	30149	th99	motherboardidredirection
135	30150	th99	motherboardidredirection
136	30151	th99	motherboardidredirection
137	30152	th99	motherboardidredirection
138	30153	th99	motherboardidredirection
139	30154	th99	motherboardidredirection
140	30155	th99	motherboardidredirection
141	30156	th99	motherboardidredirection
142	30157	th99	motherboardidredirection
143	30158	th99	motherboardidredirection
144	30159	th99	motherboardidredirection
145	30160	th99	motherboardidredirection
146	30161	th99	motherboardidredirection
147	30162	th99	motherboardidredirection
148	30163	th99	motherboardidredirection
149	30164	th99	motherboardidredirection
150	30165	th99	motherboardidredirection
151	30166	th99	motherboardidredirection
152	30167	th99	motherboardidredirection
153	30168	th99	motherboardidredirection
154	30169	th99	motherboardidredirection
155	30170	th99	motherboardidredirection
156	30171	th99	motherboardidredirection
157	30172	th99	motherboardidredirection
158	30173	th99	motherboardidredirection
159	30174	th99	motherboardidredirection
160	30175	th99	motherboardidredirection
161	30176	th99	motherboardidredirection
162	30177	th99	motherboardidredirection
163	30178	th99	motherboardidredirection
164	30179	th99	motherboardidredirection
165	30180	th99	motherboardidredirection
166	30181	th99	motherboardidredirection
167	30182	th99	motherboardidredirection
168	30183	th99	motherboardidredirection
169	30184	th99	motherboardidredirection
170	30185	th99	motherboardidredirection
171	30187	th99	motherboardidredirection
172	30188	th99	motherboardidredirection
173	30189	th99	motherboardidredirection
174	30190	th99	motherboardidredirection
175	30191	th99	motherboardidredirection
176	30192	th99	motherboardidredirection
177	30193	th99	motherboardidredirection
178	30194	th99	motherboardidredirection
179	30195	th99	motherboardidredirection
180	30196	th99	motherboardidredirection
181	30197	th99	motherboardidredirection
182	30198	th99	motherboardidredirection
183	30200	th99	motherboardidredirection
184	30201	th99	motherboardidredirection
185	30202	th99	motherboardidredirection
186	30203	th99	motherboardidredirection
187	30205	th99	motherboardidredirection
188	30206	th99	motherboardidredirection
189	30207	th99	motherboardidredirection
190	30208	th99	motherboardidredirection
191	30209	th99	motherboardidredirection
192	30210	th99	motherboardidredirection
193	30211	th99	motherboardidredirection
194	30212	th99	motherboardidredirection
195	30213	th99	motherboardidredirection
196	30214	th99	motherboardidredirection
197	30216	th99	motherboardidredirection
198	30217	th99	motherboardidredirection
199	30218	th99	motherboardidredirection
200	30219	th99	motherboardidredirection
201	30220	th99	motherboardidredirection
202	30221	th99	motherboardidredirection
203	30222	th99	motherboardidredirection
204	30224	th99	motherboardidredirection
205	30227	th99	motherboardidredirection
206	30228	th99	motherboardidredirection
207	30229	th99	motherboardidredirection
208	30230	th99	motherboardidredirection
209	30231	th99	motherboardidredirection
210	30232	th99	motherboardidredirection
211	30234	th99	motherboardidredirection
212	30235	th99	motherboardidredirection
213	30236	th99	motherboardidredirection
214	30237	th99	motherboardidredirection
215	30238	th99	motherboardidredirection
216	30239	th99	motherboardidredirection
217	30240	th99	motherboardidredirection
218	30241	th99	motherboardidredirection
219	30242	th99	motherboardidredirection
220	30243	th99	motherboardidredirection
221	30244	th99	motherboardidredirection
222	30245	th99	motherboardidredirection
224	30247	th99	motherboardidredirection
225	30248	th99	motherboardidredirection
226	30249	th99	motherboardidredirection
227	30250	th99	motherboardidredirection
228	30251	th99	motherboardidredirection
229	30252	th99	motherboardidredirection
230	30253	th99	motherboardidredirection
231	30255	th99	motherboardidredirection
232	30256	th99	motherboardidredirection
233	30257	th99	motherboardidredirection
234	30258	th99	motherboardidredirection
235	30259	th99	motherboardidredirection
236	30260	th99	motherboardidredirection
237	30261	th99	motherboardidredirection
238	30262	th99	motherboardidredirection
239	30263	th99	motherboardidredirection
240	30264	th99	motherboardidredirection
241	30265	th99	motherboardidredirection
242	30266	th99	motherboardidredirection
243	30267	th99	motherboardidredirection
244	30268	th99	motherboardidredirection
245	30269	th99	motherboardidredirection
246	30271	th99	motherboardidredirection
247	30272	th99	motherboardidredirection
248	30273	th99	motherboardidredirection
249	30274	th99	motherboardidredirection
250	30275	th99	motherboardidredirection
251	30276	th99	motherboardidredirection
252	30277	th99	motherboardidredirection
253	30278	th99	motherboardidredirection
254	30279	th99	motherboardidredirection
255	30280	th99	motherboardidredirection
256	30281	th99	motherboardidredirection
257	30282	th99	motherboardidredirection
258	30283	th99	motherboardidredirection
259	30284	th99	motherboardidredirection
260	30285	th99	motherboardidredirection
261	30286	th99	motherboardidredirection
262	30287	th99	motherboardidredirection
263	30288	th99	motherboardidredirection
264	30289	th99	motherboardidredirection
265	30291	th99	motherboardidredirection
266	30292	th99	motherboardidredirection
267	30293	th99	motherboardidredirection
268	30294	th99	motherboardidredirection
269	30295	th99	motherboardidredirection
270	30296	th99	motherboardidredirection
271	30297	th99	motherboardidredirection
272	30298	th99	motherboardidredirection
273	30299	th99	motherboardidredirection
274	30300	th99	motherboardidredirection
275	30301	th99	motherboardidredirection
276	30304	th99	motherboardidredirection
277	30305	th99	motherboardidredirection
278	30306	th99	motherboardidredirection
279	30307	th99	motherboardidredirection
280	30308	th99	motherboardidredirection
281	30309	th99	motherboardidredirection
282	30310	th99	motherboardidredirection
283	30311	th99	motherboardidredirection
284	30312	th99	motherboardidredirection
285	30313	th99	motherboardidredirection
286	30314	th99	motherboardidredirection
287	30315	th99	motherboardidredirection
288	30316	th99	motherboardidredirection
289	30318	th99	motherboardidredirection
290	30319	th99	motherboardidredirection
291	30320	th99	motherboardidredirection
292	30321	th99	motherboardidredirection
293	30322	th99	motherboardidredirection
294	30323	th99	motherboardidredirection
295	30324	th99	motherboardidredirection
296	30325	th99	motherboardidredirection
297	30326	th99	motherboardidredirection
298	30327	th99	motherboardidredirection
299	30328	th99	motherboardidredirection
300	30329	th99	motherboardidredirection
301	30330	th99	motherboardidredirection
302	30331	th99	motherboardidredirection
303	30332	th99	motherboardidredirection
304	30333	th99	motherboardidredirection
305	30334	th99	motherboardidredirection
306	30336	th99	motherboardidredirection
307	30337	th99	motherboardidredirection
308	30338	th99	motherboardidredirection
309	30339	th99	motherboardidredirection
310	30340	th99	motherboardidredirection
311	30341	th99	motherboardidredirection
312	30342	th99	motherboardidredirection
313	30343	th99	motherboardidredirection
314	30344	th99	motherboardidredirection
315	30345	th99	motherboardidredirection
316	30346	th99	motherboardidredirection
317	30347	th99	motherboardidredirection
318	30348	th99	motherboardidredirection
319	30349	th99	motherboardidredirection
320	30350	th99	motherboardidredirection
321	30351	th99	motherboardidredirection
322	30352	th99	motherboardidredirection
323	30353	th99	motherboardidredirection
324	30354	th99	motherboardidredirection
325	30355	th99	motherboardidredirection
326	30356	th99	motherboardidredirection
327	30357	th99	motherboardidredirection
328	30358	th99	motherboardidredirection
329	30359	th99	motherboardidredirection
330	30360	th99	motherboardidredirection
331	30361	th99	motherboardidredirection
332	30362	th99	motherboardidredirection
333	30363	th99	motherboardidredirection
334	30364	th99	motherboardidredirection
335	30365	th99	motherboardidredirection
336	30366	th99	motherboardidredirection
337	30367	th99	motherboardidredirection
338	30368	th99	motherboardidredirection
339	30369	th99	motherboardidredirection
340	30370	th99	motherboardidredirection
341	30371	th99	motherboardidredirection
342	30372	th99	motherboardidredirection
343	30373	th99	motherboardidredirection
344	30375	th99	motherboardidredirection
345	30376	th99	motherboardidredirection
346	30377	th99	motherboardidredirection
347	30378	th99	motherboardidredirection
348	30379	th99	motherboardidredirection
349	30380	th99	motherboardidredirection
350	30381	th99	motherboardidredirection
351	30382	th99	motherboardidredirection
352	30383	th99	motherboardidredirection
353	30384	th99	motherboardidredirection
354	30385	th99	motherboardidredirection
355	30386	th99	motherboardidredirection
356	30387	th99	motherboardidredirection
357	30388	th99	motherboardidredirection
358	30389	th99	motherboardidredirection
359	30391	th99	motherboardidredirection
360	30393	th99	motherboardidredirection
361	30394	th99	motherboardidredirection
362	30395	th99	motherboardidredirection
363	30396	th99	motherboardidredirection
364	30397	th99	motherboardidredirection
365	30398	th99	motherboardidredirection
366	30399	th99	motherboardidredirection
367	30400	th99	motherboardidredirection
368	30401	th99	motherboardidredirection
369	30402	th99	motherboardidredirection
370	30403	th99	motherboardidredirection
371	30404	th99	motherboardidredirection
372	30405	th99	motherboardidredirection
373	30406	th99	motherboardidredirection
374	30407	th99	motherboardidredirection
375	30411	th99	motherboardidredirection
376	30412	th99	motherboardidredirection
377	30413	th99	motherboardidredirection
378	30414	th99	motherboardidredirection
379	30415	th99	motherboardidredirection
380	30416	th99	motherboardidredirection
381	30417	th99	motherboardidredirection
382	30418	th99	motherboardidredirection
383	30419	th99	motherboardidredirection
384	30420	th99	motherboardidredirection
385	30421	th99	motherboardidredirection
386	30422	th99	motherboardidredirection
387	30423	th99	motherboardidredirection
388	30424	th99	motherboardidredirection
389	30425	th99	motherboardidredirection
390	30426	th99	motherboardidredirection
391	30427	th99	motherboardidredirection
392	30428	th99	motherboardidredirection
393	30429	th99	motherboardidredirection
394	30430	th99	motherboardidredirection
395	30431	th99	motherboardidredirection
396	30432	th99	motherboardidredirection
397	30433	th99	motherboardidredirection
398	30434	th99	motherboardidredirection
399	30435	th99	motherboardidredirection
400	30436	th99	motherboardidredirection
401	30437	th99	motherboardidredirection
402	30438	th99	motherboardidredirection
403	30439	th99	motherboardidredirection
404	30440	th99	motherboardidredirection
405	30441	th99	motherboardidredirection
406	30443	th99	motherboardidredirection
407	30444	th99	motherboardidredirection
408	30445	th99	motherboardidredirection
409	30446	th99	motherboardidredirection
410	30447	th99	motherboardidredirection
411	30448	th99	motherboardidredirection
412	30449	th99	motherboardidredirection
413	30450	th99	motherboardidredirection
414	30451	th99	motherboardidredirection
415	30452	th99	motherboardidredirection
416	30453	th99	motherboardidredirection
417	30454	th99	motherboardidredirection
418	30455	th99	motherboardidredirection
419	30456	th99	motherboardidredirection
420	30457	th99	motherboardidredirection
421	30458	th99	motherboardidredirection
422	30459	th99	motherboardidredirection
423	30460	th99	motherboardidredirection
424	30461	th99	motherboardidredirection
425	30462	th99	motherboardidredirection
426	30463	th99	motherboardidredirection
427	30464	th99	motherboardidredirection
428	30467	th99	motherboardidredirection
429	30468	th99	motherboardidredirection
430	30469	th99	motherboardidredirection
431	30470	th99	motherboardidredirection
432	30471	th99	motherboardidredirection
433	30472	th99	motherboardidredirection
434	30473	th99	motherboardidredirection
435	30474	th99	motherboardidredirection
436	30475	th99	motherboardidredirection
437	30476	th99	motherboardidredirection
438	30477	th99	motherboardidredirection
439	30478	th99	motherboardidredirection
440	30479	th99	motherboardidredirection
441	30480	th99	motherboardidredirection
442	30481	th99	motherboardidredirection
443	30482	th99	motherboardidredirection
444	30483	th99	motherboardidredirection
445	30484	th99	motherboardidredirection
446	30485	th99	motherboardidredirection
447	30486	th99	motherboardidredirection
448	30487	th99	motherboardidredirection
449	30488	th99	motherboardidredirection
450	30489	th99	motherboardidredirection
451	30490	th99	motherboardidredirection
452	30491	th99	motherboardidredirection
453	30492	th99	motherboardidredirection
454	30493	th99	motherboardidredirection
455	30494	th99	motherboardidredirection
456	30495	th99	motherboardidredirection
457	30496	th99	motherboardidredirection
458	30497	th99	motherboardidredirection
459	30498	th99	motherboardidredirection
460	30499	th99	motherboardidredirection
461	30500	th99	motherboardidredirection
462	30501	th99	motherboardidredirection
463	30502	th99	motherboardidredirection
464	30503	th99	motherboardidredirection
465	30505	th99	motherboardidredirection
466	30506	th99	motherboardidredirection
467	30507	th99	motherboardidredirection
468	30508	th99	motherboardidredirection
469	30509	th99	motherboardidredirection
470	30510	th99	motherboardidredirection
471	30511	th99	motherboardidredirection
472	30512	th99	motherboardidredirection
473	30514	th99	motherboardidredirection
474	30516	th99	motherboardidredirection
475	30517	th99	motherboardidredirection
476	30518	th99	motherboardidredirection
477	30519	th99	motherboardidredirection
478	30520	th99	motherboardidredirection
479	30521	th99	motherboardidredirection
480	30522	th99	motherboardidredirection
481	30523	th99	motherboardidredirection
482	30524	th99	motherboardidredirection
483	30525	th99	motherboardidredirection
484	30526	th99	motherboardidredirection
485	30527	th99	motherboardidredirection
486	30528	th99	motherboardidredirection
487	30529	th99	motherboardidredirection
488	30530	th99	motherboardidredirection
489	30531	th99	motherboardidredirection
490	30532	th99	motherboardidredirection
491	30533	th99	motherboardidredirection
492	30534	th99	motherboardidredirection
493	30536	th99	motherboardidredirection
494	30537	th99	motherboardidredirection
495	30538	th99	motherboardidredirection
496	30539	th99	motherboardidredirection
497	30541	th99	motherboardidredirection
498	30542	th99	motherboardidredirection
499	30543	th99	motherboardidredirection
500	30544	th99	motherboardidredirection
501	30545	th99	motherboardidredirection
502	30546	th99	motherboardidredirection
503	30547	th99	motherboardidredirection
504	30548	th99	motherboardidredirection
505	30549	th99	motherboardidredirection
506	30550	th99	motherboardidredirection
507	30551	th99	motherboardidredirection
508	30552	th99	motherboardidredirection
509	30553	th99	motherboardidredirection
510	30554	th99	motherboardidredirection
511	30555	th99	motherboardidredirection
512	30558	th99	motherboardidredirection
513	30559	th99	motherboardidredirection
514	30561	th99	motherboardidredirection
515	30562	th99	motherboardidredirection
516	30563	th99	motherboardidredirection
517	30564	th99	motherboardidredirection
518	30565	th99	motherboardidredirection
519	30566	th99	motherboardidredirection
520	30567	th99	motherboardidredirection
521	30568	th99	motherboardidredirection
522	30569	th99	motherboardidredirection
523	30571	th99	motherboardidredirection
524	30572	th99	motherboardidredirection
525	30573	th99	motherboardidredirection
526	30574	th99	motherboardidredirection
527	30575	th99	motherboardidredirection
528	30576	th99	motherboardidredirection
529	30577	th99	motherboardidredirection
530	30578	th99	motherboardidredirection
531	30579	th99	motherboardidredirection
532	30580	th99	motherboardidredirection
533	30581	th99	motherboardidredirection
534	30582	th99	motherboardidredirection
535	30583	th99	motherboardidredirection
536	30584	th99	motherboardidredirection
537	30585	th99	motherboardidredirection
538	30586	th99	motherboardidredirection
539	30587	th99	motherboardidredirection
540	30588	th99	motherboardidredirection
541	30589	th99	motherboardidredirection
542	30590	th99	motherboardidredirection
543	30592	th99	motherboardidredirection
544	30593	th99	motherboardidredirection
545	30594	th99	motherboardidredirection
546	30595	th99	motherboardidredirection
547	30596	th99	motherboardidredirection
548	30597	th99	motherboardidredirection
549	30598	th99	motherboardidredirection
550	30599	th99	motherboardidredirection
551	30600	th99	motherboardidredirection
552	30601	th99	motherboardidredirection
553	30602	th99	motherboardidredirection
554	30603	th99	motherboardidredirection
555	30604	th99	motherboardidredirection
556	30605	th99	motherboardidredirection
557	30606	th99	motherboardidredirection
558	30607	th99	motherboardidredirection
559	30608	th99	motherboardidredirection
560	30609	th99	motherboardidredirection
561	30610	th99	motherboardidredirection
562	30611	th99	motherboardidredirection
563	30612	th99	motherboardidredirection
564	30613	th99	motherboardidredirection
565	30614	th99	motherboardidredirection
566	30615	th99	motherboardidredirection
567	30616	th99	motherboardidredirection
568	30617	th99	motherboardidredirection
569	30618	th99	motherboardidredirection
570	30619	th99	motherboardidredirection
571	30620	th99	motherboardidredirection
572	30621	th99	motherboardidredirection
573	30622	th99	motherboardidredirection
574	30623	th99	motherboardidredirection
575	30624	th99	motherboardidredirection
576	30625	th99	motherboardidredirection
577	30626	th99	motherboardidredirection
578	30627	th99	motherboardidredirection
579	30628	th99	motherboardidredirection
580	30629	th99	motherboardidredirection
581	30630	th99	motherboardidredirection
582	30631	th99	motherboardidredirection
583	30632	th99	motherboardidredirection
584	30633	th99	motherboardidredirection
585	30634	th99	motherboardidredirection
586	30635	th99	motherboardidredirection
587	30636	th99	motherboardidredirection
588	30637	th99	motherboardidredirection
589	30638	th99	motherboardidredirection
590	30639	th99	motherboardidredirection
591	30640	th99	motherboardidredirection
592	30641	th99	motherboardidredirection
593	30642	th99	motherboardidredirection
594	30643	th99	motherboardidredirection
595	30644	th99	motherboardidredirection
596	30645	th99	motherboardidredirection
597	30646	th99	motherboardidredirection
598	30647	th99	motherboardidredirection
599	30648	th99	motherboardidredirection
600	30649	th99	motherboardidredirection
601	30650	th99	motherboardidredirection
602	30651	th99	motherboardidredirection
603	30652	th99	motherboardidredirection
604	30653	th99	motherboardidredirection
605	30654	th99	motherboardidredirection
606	30655	th99	motherboardidredirection
607	30656	th99	motherboardidredirection
608	30657	th99	motherboardidredirection
609	30658	th99	motherboardidredirection
610	30659	th99	motherboardidredirection
611	30660	th99	motherboardidredirection
612	30661	th99	motherboardidredirection
613	30662	th99	motherboardidredirection
614	30663	th99	motherboardidredirection
615	30664	th99	motherboardidredirection
616	30665	th99	motherboardidredirection
617	30666	th99	motherboardidredirection
618	30668	th99	motherboardidredirection
619	30669	th99	motherboardidredirection
620	30670	th99	motherboardidredirection
621	30671	th99	motherboardidredirection
622	30672	th99	motherboardidredirection
623	30673	th99	motherboardidredirection
624	30674	th99	motherboardidredirection
625	30675	th99	motherboardidredirection
626	30676	th99	motherboardidredirection
627	30677	th99	motherboardidredirection
628	30678	th99	motherboardidredirection
629	30679	th99	motherboardidredirection
630	30680	th99	motherboardidredirection
631	30681	th99	motherboardidredirection
632	30682	th99	motherboardidredirection
633	30683	th99	motherboardidredirection
634	30684	th99	motherboardidredirection
635	30685	th99	motherboardidredirection
636	30686	th99	motherboardidredirection
637	30687	th99	motherboardidredirection
638	30688	th99	motherboardidredirection
639	30689	th99	motherboardidredirection
640	30690	th99	motherboardidredirection
641	30691	th99	motherboardidredirection
642	30692	th99	motherboardidredirection
643	30693	th99	motherboardidredirection
644	30694	th99	motherboardidredirection
645	30695	th99	motherboardidredirection
646	30696	th99	motherboardidredirection
647	30697	th99	motherboardidredirection
648	30698	th99	motherboardidredirection
649	30699	th99	motherboardidredirection
650	30700	th99	motherboardidredirection
651	30701	th99	motherboardidredirection
652	30703	th99	motherboardidredirection
653	30704	th99	motherboardidredirection
654	30705	th99	motherboardidredirection
655	30706	th99	motherboardidredirection
656	30707	th99	motherboardidredirection
657	30708	th99	motherboardidredirection
658	30709	th99	motherboardidredirection
659	30710	th99	motherboardidredirection
660	30711	th99	motherboardidredirection
661	30712	th99	motherboardidredirection
662	30713	th99	motherboardidredirection
663	30714	th99	motherboardidredirection
664	30715	th99	motherboardidredirection
665	30716	th99	motherboardidredirection
666	30717	th99	motherboardidredirection
667	30718	th99	motherboardidredirection
668	30719	th99	motherboardidredirection
669	30720	th99	motherboardidredirection
670	30721	th99	motherboardidredirection
671	30722	th99	motherboardidredirection
672	30723	th99	motherboardidredirection
673	30724	th99	motherboardidredirection
674	30726	th99	motherboardidredirection
675	30727	th99	motherboardidredirection
676	30729	th99	motherboardidredirection
677	30731	th99	motherboardidredirection
678	30732	th99	motherboardidredirection
679	30733	th99	motherboardidredirection
680	30734	th99	motherboardidredirection
681	30735	th99	motherboardidredirection
682	30736	th99	motherboardidredirection
683	30737	th99	motherboardidredirection
684	30738	th99	motherboardidredirection
685	30739	th99	motherboardidredirection
686	30740	th99	motherboardidredirection
687	30741	th99	motherboardidredirection
688	30742	th99	motherboardidredirection
689	30743	th99	motherboardidredirection
690	30744	th99	motherboardidredirection
691	30745	th99	motherboardidredirection
692	30746	th99	motherboardidredirection
693	30747	th99	motherboardidredirection
694	30748	th99	motherboardidredirection
695	30749	th99	motherboardidredirection
696	30750	th99	motherboardidredirection
697	30751	th99	motherboardidredirection
698	30752	th99	motherboardidredirection
699	30753	th99	motherboardidredirection
700	30754	th99	motherboardidredirection
701	30755	th99	motherboardidredirection
702	30756	th99	motherboardidredirection
703	30757	th99	motherboardidredirection
704	30758	th99	motherboardidredirection
705	30759	th99	motherboardidredirection
706	30761	th99	motherboardidredirection
707	30762	th99	motherboardidredirection
708	30764	th99	motherboardidredirection
709	30765	th99	motherboardidredirection
710	30766	th99	motherboardidredirection
711	30767	th99	motherboardidredirection
712	30768	th99	motherboardidredirection
713	30769	th99	motherboardidredirection
714	30770	th99	motherboardidredirection
715	30771	th99	motherboardidredirection
716	30772	th99	motherboardidredirection
717	30773	th99	motherboardidredirection
718	30774	th99	motherboardidredirection
719	30775	th99	motherboardidredirection
720	30776	th99	motherboardidredirection
721	30777	th99	motherboardidredirection
722	30778	th99	motherboardidredirection
723	30779	th99	motherboardidredirection
724	30780	th99	motherboardidredirection
725	30781	th99	motherboardidredirection
726	30782	th99	motherboardidredirection
727	30783	th99	motherboardidredirection
728	30784	th99	motherboardidredirection
729	30785	th99	motherboardidredirection
730	30786	th99	motherboardidredirection
731	30787	th99	motherboardidredirection
732	30788	th99	motherboardidredirection
733	30789	th99	motherboardidredirection
734	30790	th99	motherboardidredirection
735	30791	th99	motherboardidredirection
736	30793	th99	motherboardidredirection
737	30797	th99	motherboardidredirection
738	30798	th99	motherboardidredirection
739	30799	th99	motherboardidredirection
740	30800	th99	motherboardidredirection
741	30801	th99	motherboardidredirection
742	30802	th99	motherboardidredirection
743	30803	th99	motherboardidredirection
744	30804	th99	motherboardidredirection
745	30805	th99	motherboardidredirection
746	30806	th99	motherboardidredirection
747	30807	th99	motherboardidredirection
748	30808	th99	motherboardidredirection
749	30809	th99	motherboardidredirection
750	30811	th99	motherboardidredirection
751	30812	th99	motherboardidredirection
752	30813	th99	motherboardidredirection
753	30814	th99	motherboardidredirection
754	30815	th99	motherboardidredirection
755	30816	th99	motherboardidredirection
756	30817	th99	motherboardidredirection
757	30818	th99	motherboardidredirection
758	30819	th99	motherboardidredirection
759	30820	th99	motherboardidredirection
760	30821	th99	motherboardidredirection
761	30822	th99	motherboardidredirection
762	30823	th99	motherboardidredirection
763	30824	th99	motherboardidredirection
764	30825	th99	motherboardidredirection
765	30827	th99	motherboardidredirection
766	30828	th99	motherboardidredirection
767	30829	th99	motherboardidredirection
768	30830	th99	motherboardidredirection
769	30831	th99	motherboardidredirection
770	30832	th99	motherboardidredirection
771	30833	th99	motherboardidredirection
772	30834	th99	motherboardidredirection
773	30835	th99	motherboardidredirection
774	30836	th99	motherboardidredirection
775	30838	th99	motherboardidredirection
776	30839	th99	motherboardidredirection
777	30840	th99	motherboardidredirection
778	30841	th99	motherboardidredirection
779	30842	th99	motherboardidredirection
780	30843	th99	motherboardidredirection
781	30844	th99	motherboardidredirection
782	30845	th99	motherboardidredirection
783	30846	th99	motherboardidredirection
784	30847	th99	motherboardidredirection
785	30848	th99	motherboardidredirection
786	30849	th99	motherboardidredirection
787	30850	th99	motherboardidredirection
788	30851	th99	motherboardidredirection
789	30852	th99	motherboardidredirection
790	30853	th99	motherboardidredirection
791	30855	th99	motherboardidredirection
792	30856	th99	motherboardidredirection
793	30857	th99	motherboardidredirection
794	30858	th99	motherboardidredirection
795	30859	th99	motherboardidredirection
796	30860	th99	motherboardidredirection
797	30861	th99	motherboardidredirection
798	30862	th99	motherboardidredirection
799	30863	th99	motherboardidredirection
800	30864	th99	motherboardidredirection
801	30865	th99	motherboardidredirection
802	30866	th99	motherboardidredirection
803	30867	th99	motherboardidredirection
804	30868	th99	motherboardidredirection
805	30869	th99	motherboardidredirection
806	30871	th99	motherboardidredirection
807	30872	th99	motherboardidredirection
808	30873	th99	motherboardidredirection
809	30874	th99	motherboardidredirection
810	30875	th99	motherboardidredirection
811	30876	th99	motherboardidredirection
812	30877	th99	motherboardidredirection
813	30878	th99	motherboardidredirection
814	30879	th99	motherboardidredirection
815	30880	th99	motherboardidredirection
816	30881	th99	motherboardidredirection
817	30882	th99	motherboardidredirection
818	30883	th99	motherboardidredirection
819	30884	th99	motherboardidredirection
820	30885	th99	motherboardidredirection
821	30886	th99	motherboardidredirection
822	30887	th99	motherboardidredirection
823	30888	th99	motherboardidredirection
824	30889	th99	motherboardidredirection
825	30890	th99	motherboardidredirection
826	30891	th99	motherboardidredirection
827	30892	th99	motherboardidredirection
828	30893	th99	motherboardidredirection
829	30894	th99	motherboardidredirection
830	30895	th99	motherboardidredirection
831	30896	th99	motherboardidredirection
832	30897	th99	motherboardidredirection
833	30898	th99	motherboardidredirection
834	30899	th99	motherboardidredirection
835	30900	th99	motherboardidredirection
836	30901	th99	motherboardidredirection
837	30902	th99	motherboardidredirection
838	30903	th99	motherboardidredirection
839	30904	th99	motherboardidredirection
840	30905	th99	motherboardidredirection
841	30906	th99	motherboardidredirection
842	30907	th99	motherboardidredirection
843	30908	th99	motherboardidredirection
844	30909	th99	motherboardidredirection
845	30910	th99	motherboardidredirection
846	30911	th99	motherboardidredirection
847	30913	th99	motherboardidredirection
848	30914	th99	motherboardidredirection
849	30915	th99	motherboardidredirection
850	30916	th99	motherboardidredirection
851	30917	th99	motherboardidredirection
852	30918	th99	motherboardidredirection
853	30919	th99	motherboardidredirection
854	30920	th99	motherboardidredirection
855	30921	th99	motherboardidredirection
856	30922	th99	motherboardidredirection
857	30923	th99	motherboardidredirection
858	30924	th99	motherboardidredirection
859	30925	th99	motherboardidredirection
860	30926	th99	motherboardidredirection
861	30927	th99	motherboardidredirection
862	30928	th99	motherboardidredirection
863	30929	th99	motherboardidredirection
864	30930	th99	motherboardidredirection
865	30931	th99	motherboardidredirection
866	30932	th99	motherboardidredirection
867	30933	th99	motherboardidredirection
868	30934	th99	motherboardidredirection
869	30935	th99	motherboardidredirection
870	30936	th99	motherboardidredirection
871	30937	th99	motherboardidredirection
872	30938	th99	motherboardidredirection
873	30939	th99	motherboardidredirection
874	30940	th99	motherboardidredirection
875	30941	th99	motherboardidredirection
876	30943	th99	motherboardidredirection
877	30944	th99	motherboardidredirection
878	30945	th99	motherboardidredirection
879	30946	th99	motherboardidredirection
880	30947	th99	motherboardidredirection
881	30948	th99	motherboardidredirection
882	30949	th99	motherboardidredirection
883	30950	th99	motherboardidredirection
884	30951	th99	motherboardidredirection
885	30952	th99	motherboardidredirection
886	30953	th99	motherboardidredirection
887	30954	th99	motherboardidredirection
888	30955	th99	motherboardidredirection
889	30956	th99	motherboardidredirection
890	30957	th99	motherboardidredirection
891	30958	th99	motherboardidredirection
892	30959	th99	motherboardidredirection
893	30960	th99	motherboardidredirection
894	30961	th99	motherboardidredirection
895	30962	th99	motherboardidredirection
896	30963	th99	motherboardidredirection
897	30964	th99	motherboardidredirection
898	30965	th99	motherboardidredirection
899	30966	th99	motherboardidredirection
900	30967	th99	motherboardidredirection
901	30968	th99	motherboardidredirection
902	30969	th99	motherboardidredirection
903	30970	th99	motherboardidredirection
904	30972	th99	motherboardidredirection
905	30973	th99	motherboardidredirection
906	30974	th99	motherboardidredirection
907	30975	th99	motherboardidredirection
908	30976	th99	motherboardidredirection
909	30977	th99	motherboardidredirection
910	30978	th99	motherboardidredirection
911	30979	th99	motherboardidredirection
912	30980	th99	motherboardidredirection
913	30981	th99	motherboardidredirection
914	30982	th99	motherboardidredirection
915	30983	th99	motherboardidredirection
916	30984	th99	motherboardidredirection
917	30985	th99	motherboardidredirection
918	30986	th99	motherboardidredirection
919	30987	th99	motherboardidredirection
921	30991	th99	motherboardidredirection
922	30992	th99	motherboardidredirection
923	30993	th99	motherboardidredirection
924	30994	th99	motherboardidredirection
925	30995	th99	motherboardidredirection
926	30997	th99	motherboardidredirection
927	30998	th99	motherboardidredirection
928	30999	th99	motherboardidredirection
929	31000	th99	motherboardidredirection
930	31001	th99	motherboardidredirection
931	31002	th99	motherboardidredirection
932	31003	th99	motherboardidredirection
933	31004	th99	motherboardidredirection
934	31005	th99	motherboardidredirection
935	31006	th99	motherboardidredirection
936	31007	th99	motherboardidredirection
937	31008	th99	motherboardidredirection
938	31009	th99	motherboardidredirection
939	31010	th99	motherboardidredirection
940	31011	th99	motherboardidredirection
941	31012	th99	motherboardidredirection
942	31014	th99	motherboardidredirection
943	31015	th99	motherboardidredirection
944	31016	th99	motherboardidredirection
945	31017	th99	motherboardidredirection
946	31018	th99	motherboardidredirection
947	31020	th99	motherboardidredirection
948	31021	th99	motherboardidredirection
949	31022	th99	motherboardidredirection
950	31023	th99	motherboardidredirection
951	31024	th99	motherboardidredirection
952	31025	th99	motherboardidredirection
953	31026	th99	motherboardidredirection
954	31027	th99	motherboardidredirection
955	31028	th99	motherboardidredirection
956	31029	th99	motherboardidredirection
957	31030	th99	motherboardidredirection
958	31035	th99	motherboardidredirection
959	31036	th99	motherboardidredirection
960	31037	th99	motherboardidredirection
961	31038	th99	motherboardidredirection
962	31039	th99	motherboardidredirection
963	31040	th99	motherboardidredirection
964	31041	th99	motherboardidredirection
965	31043	th99	motherboardidredirection
966	31044	th99	motherboardidredirection
967	31045	th99	motherboardidredirection
968	31047	th99	motherboardidredirection
969	31049	th99	motherboardidredirection
970	31050	th99	motherboardidredirection
971	31051	th99	motherboardidredirection
972	31052	th99	motherboardidredirection
973	31053	th99	motherboardidredirection
974	31054	th99	motherboardidredirection
975	31055	th99	motherboardidredirection
976	31056	th99	motherboardidredirection
977	31057	th99	motherboardidredirection
978	31058	th99	motherboardidredirection
979	31059	th99	motherboardidredirection
980	31060	th99	motherboardidredirection
981	31061	th99	motherboardidredirection
982	31062	th99	motherboardidredirection
983	31063	th99	motherboardidredirection
984	31064	th99	motherboardidredirection
985	31065	th99	motherboardidredirection
986	31066	th99	motherboardidredirection
987	31067	th99	motherboardidredirection
988	31068	th99	motherboardidredirection
989	31069	th99	motherboardidredirection
990	31070	th99	motherboardidredirection
991	31071	th99	motherboardidredirection
992	31072	th99	motherboardidredirection
993	31073	th99	motherboardidredirection
994	31074	th99	motherboardidredirection
995	31075	th99	motherboardidredirection
996	31076	th99	motherboardidredirection
997	31077	th99	motherboardidredirection
998	31078	th99	motherboardidredirection
999	31079	th99	motherboardidredirection
1000	31080	th99	motherboardidredirection
1001	31081	th99	motherboardidredirection
1002	31082	th99	motherboardidredirection
1003	31083	th99	motherboardidredirection
1004	31085	th99	motherboardidredirection
1005	31086	th99	motherboardidredirection
1006	31087	th99	motherboardidredirection
1007	31088	th99	motherboardidredirection
1008	31089	th99	motherboardidredirection
1009	31090	th99	motherboardidredirection
1010	31091	th99	motherboardidredirection
1011	31092	th99	motherboardidredirection
1012	31093	th99	motherboardidredirection
1013	31094	th99	motherboardidredirection
1014	31095	th99	motherboardidredirection
1015	31096	th99	motherboardidredirection
1016	31097	th99	motherboardidredirection
1017	31098	th99	motherboardidredirection
1018	31099	th99	motherboardidredirection
1019	31100	th99	motherboardidredirection
1020	31101	th99	motherboardidredirection
1021	31102	th99	motherboardidredirection
1022	31103	th99	motherboardidredirection
1023	31104	th99	motherboardidredirection
1024	31105	th99	motherboardidredirection
1025	31106	th99	motherboardidredirection
1026	31107	th99	motherboardidredirection
1027	31108	th99	motherboardidredirection
1028	31109	th99	motherboardidredirection
1029	31110	th99	motherboardidredirection
1030	31111	th99	motherboardidredirection
1031	31112	th99	motherboardidredirection
1032	31113	th99	motherboardidredirection
1033	31114	th99	motherboardidredirection
1034	31115	th99	motherboardidredirection
1035	31116	th99	motherboardidredirection
1036	31117	th99	motherboardidredirection
1037	31118	th99	motherboardidredirection
1038	31119	th99	motherboardidredirection
1039	31120	th99	motherboardidredirection
1040	31121	th99	motherboardidredirection
1041	31122	th99	motherboardidredirection
1042	31123	th99	motherboardidredirection
1043	31124	th99	motherboardidredirection
1044	31125	th99	motherboardidredirection
1045	31126	th99	motherboardidredirection
1046	31127	th99	motherboardidredirection
1047	31128	th99	motherboardidredirection
1048	31129	th99	motherboardidredirection
1049	31130	th99	motherboardidredirection
1050	31131	th99	motherboardidredirection
1051	31132	th99	motherboardidredirection
1052	31133	th99	motherboardidredirection
1053	31134	th99	motherboardidredirection
1054	31135	th99	motherboardidredirection
1055	31136	th99	motherboardidredirection
1056	31137	th99	motherboardidredirection
1057	31138	th99	motherboardidredirection
1058	31139	th99	motherboardidredirection
1059	31140	th99	motherboardidredirection
1060	31141	th99	motherboardidredirection
1061	31142	th99	motherboardidredirection
1062	31143	th99	motherboardidredirection
1063	31144	th99	motherboardidredirection
1064	31145	th99	motherboardidredirection
1065	31146	th99	motherboardidredirection
1066	31147	th99	motherboardidredirection
1067	31148	th99	motherboardidredirection
1068	31149	th99	motherboardidredirection
1069	31150	th99	motherboardidredirection
1070	31151	th99	motherboardidredirection
1071	31152	th99	motherboardidredirection
1072	31153	th99	motherboardidredirection
1073	31154	th99	motherboardidredirection
1074	31156	th99	motherboardidredirection
1075	31157	th99	motherboardidredirection
1076	31158	th99	motherboardidredirection
1077	31161	th99	motherboardidredirection
1078	31162	th99	motherboardidredirection
1079	31164	th99	motherboardidredirection
1080	31165	th99	motherboardidredirection
1081	31166	th99	motherboardidredirection
1082	31167	th99	motherboardidredirection
1083	31168	th99	motherboardidredirection
1084	31169	th99	motherboardidredirection
1085	31170	th99	motherboardidredirection
1086	31171	th99	motherboardidredirection
1087	31172	th99	motherboardidredirection
1088	31173	th99	motherboardidredirection
1089	31174	th99	motherboardidredirection
1090	31175	th99	motherboardidredirection
1091	31176	th99	motherboardidredirection
1092	31177	th99	motherboardidredirection
1093	31178	th99	motherboardidredirection
1094	31179	th99	motherboardidredirection
1095	31180	th99	motherboardidredirection
1096	31182	th99	motherboardidredirection
1097	31185	th99	motherboardidredirection
1098	31186	th99	motherboardidredirection
1099	31187	th99	motherboardidredirection
1100	31188	th99	motherboardidredirection
1101	31190	th99	motherboardidredirection
1102	31191	th99	motherboardidredirection
1103	31192	th99	motherboardidredirection
1104	31193	th99	motherboardidredirection
1105	31194	th99	motherboardidredirection
1106	31197	th99	motherboardidredirection
1107	31198	th99	motherboardidredirection
1108	31199	th99	motherboardidredirection
1109	31201	th99	motherboardidredirection
1110	31202	th99	motherboardidredirection
1111	31203	th99	motherboardidredirection
1112	31204	th99	motherboardidredirection
1113	31205	th99	motherboardidredirection
1114	31206	th99	motherboardidredirection
1115	31207	th99	motherboardidredirection
1116	31208	th99	motherboardidredirection
1117	31209	th99	motherboardidredirection
1118	31210	th99	motherboardidredirection
1119	31211	th99	motherboardidredirection
1120	31212	th99	motherboardidredirection
1121	31213	th99	motherboardidredirection
1122	31214	th99	motherboardidredirection
1123	31215	th99	motherboardidredirection
1124	31216	th99	motherboardidredirection
1125	31217	th99	motherboardidredirection
1126	31218	th99	motherboardidredirection
1127	31219	th99	motherboardidredirection
1128	31220	th99	motherboardidredirection
1129	31221	th99	motherboardidredirection
1130	31222	th99	motherboardidredirection
1131	31223	th99	motherboardidredirection
1132	31224	th99	motherboardidredirection
1133	31225	th99	motherboardidredirection
1134	31226	th99	motherboardidredirection
1135	31227	th99	motherboardidredirection
1136	31228	th99	motherboardidredirection
1137	31229	th99	motherboardidredirection
1138	31230	th99	motherboardidredirection
1139	31231	th99	motherboardidredirection
1140	31232	th99	motherboardidredirection
1141	31233	th99	motherboardidredirection
1142	31234	th99	motherboardidredirection
1143	31235	th99	motherboardidredirection
1144	31237	th99	motherboardidredirection
1145	31238	th99	motherboardidredirection
1146	31239	th99	motherboardidredirection
1147	31240	th99	motherboardidredirection
1148	31241	th99	motherboardidredirection
1149	31242	th99	motherboardidredirection
1150	31244	th99	motherboardidredirection
1151	31245	th99	motherboardidredirection
1152	31246	th99	motherboardidredirection
1153	31247	th99	motherboardidredirection
1154	31248	th99	motherboardidredirection
1155	31249	th99	motherboardidredirection
1156	31250	th99	motherboardidredirection
1157	31252	th99	motherboardidredirection
1158	31253	th99	motherboardidredirection
1159	31254	th99	motherboardidredirection
1160	31255	th99	motherboardidredirection
1161	31256	th99	motherboardidredirection
1162	31258	th99	motherboardidredirection
1163	31259	th99	motherboardidredirection
1164	31260	th99	motherboardidredirection
1165	31261	th99	motherboardidredirection
1166	31262	th99	motherboardidredirection
1167	31263	th99	motherboardidredirection
1168	31264	th99	motherboardidredirection
1169	31265	th99	motherboardidredirection
1170	31266	th99	motherboardidredirection
1171	31267	th99	motherboardidredirection
1172	31269	th99	motherboardidredirection
1173	31270	th99	motherboardidredirection
1174	31271	th99	motherboardidredirection
1175	31272	th99	motherboardidredirection
1176	31273	th99	motherboardidredirection
1177	31274	th99	motherboardidredirection
1178	31276	th99	motherboardidredirection
1179	31277	th99	motherboardidredirection
1180	31278	th99	motherboardidredirection
1181	31279	th99	motherboardidredirection
1182	31280	th99	motherboardidredirection
1183	31281	th99	motherboardidredirection
1185	31283	th99	motherboardidredirection
1186	31284	th99	motherboardidredirection
1187	31285	th99	motherboardidredirection
1188	31286	th99	motherboardidredirection
1189	31288	th99	motherboardidredirection
1190	31289	th99	motherboardidredirection
1191	31290	th99	motherboardidredirection
1192	31291	th99	motherboardidredirection
1193	31292	th99	motherboardidredirection
1194	31293	th99	motherboardidredirection
1195	31294	th99	motherboardidredirection
1196	31295	th99	motherboardidredirection
1197	31296	th99	motherboardidredirection
1198	31297	th99	motherboardidredirection
1199	31298	th99	motherboardidredirection
1200	31299	th99	motherboardidredirection
1201	31300	th99	motherboardidredirection
1202	31301	th99	motherboardidredirection
1203	31302	th99	motherboardidredirection
1204	31303	th99	motherboardidredirection
1205	31304	th99	motherboardidredirection
1206	31305	th99	motherboardidredirection
1207	31306	th99	motherboardidredirection
1208	31307	th99	motherboardidredirection
1209	31308	th99	motherboardidredirection
1210	31309	th99	motherboardidredirection
1211	31310	th99	motherboardidredirection
1212	31311	th99	motherboardidredirection
1213	31312	th99	motherboardidredirection
1214	31313	th99	motherboardidredirection
1215	31314	th99	motherboardidredirection
1216	31315	th99	motherboardidredirection
1217	31316	th99	motherboardidredirection
1218	31318	th99	motherboardidredirection
1219	31319	th99	motherboardidredirection
1220	31321	th99	motherboardidredirection
1221	31322	th99	motherboardidredirection
1222	31324	th99	motherboardidredirection
1223	31326	th99	motherboardidredirection
1224	31327	th99	motherboardidredirection
1225	31328	th99	motherboardidredirection
1226	31329	th99	motherboardidredirection
1227	31330	th99	motherboardidredirection
1228	31331	th99	motherboardidredirection
1229	31332	th99	motherboardidredirection
1230	31335	th99	motherboardidredirection
1231	31336	th99	motherboardidredirection
1232	31337	th99	motherboardidredirection
1233	31338	th99	motherboardidredirection
1234	31339	th99	motherboardidredirection
1235	31340	th99	motherboardidredirection
1236	31341	th99	motherboardidredirection
1237	31342	th99	motherboardidredirection
1238	31343	th99	motherboardidredirection
1239	31344	th99	motherboardidredirection
1240	31345	th99	motherboardidredirection
1241	31346	th99	motherboardidredirection
1242	31347	th99	motherboardidredirection
1243	31348	th99	motherboardidredirection
1244	31349	th99	motherboardidredirection
1245	31351	th99	motherboardidredirection
1246	31352	th99	motherboardidredirection
1247	31353	th99	motherboardidredirection
1248	31354	th99	motherboardidredirection
1249	31356	th99	motherboardidredirection
1250	31357	th99	motherboardidredirection
1251	31358	th99	motherboardidredirection
1252	31359	th99	motherboardidredirection
1253	31361	th99	motherboardidredirection
1254	31362	th99	motherboardidredirection
1255	31363	th99	motherboardidredirection
1256	31364	th99	motherboardidredirection
1257	31365	th99	motherboardidredirection
1258	31366	th99	motherboardidredirection
1259	31367	th99	motherboardidredirection
1260	31368	th99	motherboardidredirection
1261	31369	th99	motherboardidredirection
1262	31370	th99	motherboardidredirection
1263	31371	th99	motherboardidredirection
1264	31372	th99	motherboardidredirection
1265	31373	th99	motherboardidredirection
1266	31374	th99	motherboardidredirection
1267	31375	th99	motherboardidredirection
1268	31376	th99	motherboardidredirection
1269	31377	th99	motherboardidredirection
1270	31378	th99	motherboardidredirection
1271	31379	th99	motherboardidredirection
1272	31381	th99	motherboardidredirection
1273	31382	th99	motherboardidredirection
1274	31383	th99	motherboardidredirection
1275	31384	th99	motherboardidredirection
1276	31386	th99	motherboardidredirection
1277	31387	th99	motherboardidredirection
1278	31389	th99	motherboardidredirection
1279	31390	th99	motherboardidredirection
1280	31391	th99	motherboardidredirection
1281	31392	th99	motherboardidredirection
1282	31393	th99	motherboardidredirection
1283	31394	th99	motherboardidredirection
1284	31395	th99	motherboardidredirection
1285	31396	th99	motherboardidredirection
1286	31397	th99	motherboardidredirection
1287	31398	th99	motherboardidredirection
1288	31399	th99	motherboardidredirection
1289	31400	th99	motherboardidredirection
1290	31401	th99	motherboardidredirection
1291	31402	th99	motherboardidredirection
1292	31403	th99	motherboardidredirection
1293	31404	th99	motherboardidredirection
1294	31405	th99	motherboardidredirection
1295	31406	th99	motherboardidredirection
1296	31407	th99	motherboardidredirection
1297	31408	th99	motherboardidredirection
1298	31409	th99	motherboardidredirection
1299	31410	th99	motherboardidredirection
1300	31411	th99	motherboardidredirection
1301	31412	th99	motherboardidredirection
1302	31413	th99	motherboardidredirection
1303	31414	th99	motherboardidredirection
1304	31415	th99	motherboardidredirection
1305	31416	th99	motherboardidredirection
1306	31417	th99	motherboardidredirection
1307	31418	th99	motherboardidredirection
1308	31419	th99	motherboardidredirection
1309	31420	th99	motherboardidredirection
1310	31422	th99	motherboardidredirection
1311	31423	th99	motherboardidredirection
1312	31424	th99	motherboardidredirection
1313	31425	th99	motherboardidredirection
1314	31426	th99	motherboardidredirection
1315	31427	th99	motherboardidredirection
1316	31428	th99	motherboardidredirection
1317	31429	th99	motherboardidredirection
1318	31430	th99	motherboardidredirection
1319	31431	th99	motherboardidredirection
1320	31432	th99	motherboardidredirection
1321	31433	th99	motherboardidredirection
1322	31434	th99	motherboardidredirection
1323	31435	th99	motherboardidredirection
1324	31436	th99	motherboardidredirection
1325	31437	th99	motherboardidredirection
1326	31438	th99	motherboardidredirection
1327	31439	th99	motherboardidredirection
1328	31440	th99	motherboardidredirection
1329	31441	th99	motherboardidredirection
1330	31442	th99	motherboardidredirection
1331	31443	th99	motherboardidredirection
1332	31444	th99	motherboardidredirection
1333	31445	th99	motherboardidredirection
1334	31446	th99	motherboardidredirection
1335	31447	th99	motherboardidredirection
1336	31448	th99	motherboardidredirection
1337	31450	th99	motherboardidredirection
1338	31451	th99	motherboardidredirection
1339	31452	th99	motherboardidredirection
1340	31453	th99	motherboardidredirection
1341	31454	th99	motherboardidredirection
1342	31455	th99	motherboardidredirection
1343	31456	th99	motherboardidredirection
1344	31457	th99	motherboardidredirection
1345	31458	th99	motherboardidredirection
1346	31459	th99	motherboardidredirection
1347	31460	th99	motherboardidredirection
1348	31462	th99	motherboardidredirection
1349	31463	th99	motherboardidredirection
1350	31464	th99	motherboardidredirection
1351	31465	th99	motherboardidredirection
1352	31466	th99	motherboardidredirection
1353	31467	th99	motherboardidredirection
1354	31468	th99	motherboardidredirection
1355	31469	th99	motherboardidredirection
1356	31471	th99	motherboardidredirection
1357	31472	th99	motherboardidredirection
1358	31473	th99	motherboardidredirection
1359	31474	th99	motherboardidredirection
1360	31475	th99	motherboardidredirection
1361	31476	th99	motherboardidredirection
1362	31477	th99	motherboardidredirection
1363	31478	th99	motherboardidredirection
1364	31479	th99	motherboardidredirection
1365	31480	th99	motherboardidredirection
1366	31482	th99	motherboardidredirection
1367	31484	th99	motherboardidredirection
1368	31485	th99	motherboardidredirection
1369	31486	th99	motherboardidredirection
1370	31487	th99	motherboardidredirection
1371	31488	th99	motherboardidredirection
1372	31489	th99	motherboardidredirection
1373	31490	th99	motherboardidredirection
1374	31491	th99	motherboardidredirection
1375	31492	th99	motherboardidredirection
1376	31493	th99	motherboardidredirection
1377	31494	th99	motherboardidredirection
1378	31495	th99	motherboardidredirection
1379	31496	th99	motherboardidredirection
1380	31497	th99	motherboardidredirection
1381	31498	th99	motherboardidredirection
1382	31499	th99	motherboardidredirection
1383	31500	th99	motherboardidredirection
1384	31501	th99	motherboardidredirection
1385	31502	th99	motherboardidredirection
1386	31503	th99	motherboardidredirection
1387	31504	th99	motherboardidredirection
1388	31505	th99	motherboardidredirection
1389	31506	th99	motherboardidredirection
1390	31507	th99	motherboardidredirection
1391	31508	th99	motherboardidredirection
1392	31509	th99	motherboardidredirection
1393	31510	th99	motherboardidredirection
1394	31511	th99	motherboardidredirection
1395	31513	th99	motherboardidredirection
1396	31514	th99	motherboardidredirection
1397	31515	th99	motherboardidredirection
1398	31516	th99	motherboardidredirection
1399	31517	th99	motherboardidredirection
1400	31518	th99	motherboardidredirection
1401	31519	th99	motherboardidredirection
1402	31520	th99	motherboardidredirection
1403	31521	th99	motherboardidredirection
1404	31522	th99	motherboardidredirection
1405	31523	th99	motherboardidredirection
1406	31524	th99	motherboardidredirection
1407	31525	th99	motherboardidredirection
1408	31526	th99	motherboardidredirection
1409	31527	th99	motherboardidredirection
1410	31528	th99	motherboardidredirection
1411	31529	th99	motherboardidredirection
1412	31530	th99	motherboardidredirection
1413	31531	th99	motherboardidredirection
1414	31532	th99	motherboardidredirection
1415	31533	th99	motherboardidredirection
1416	31534	th99	motherboardidredirection
1417	31535	th99	motherboardidredirection
1418	31536	th99	motherboardidredirection
1419	31537	th99	motherboardidredirection
1420	31538	th99	motherboardidredirection
1421	31539	th99	motherboardidredirection
1422	31540	th99	motherboardidredirection
1423	31541	th99	motherboardidredirection
1424	31542	th99	motherboardidredirection
1425	31543	th99	motherboardidredirection
1426	31544	th99	motherboardidredirection
1427	31545	th99	motherboardidredirection
1428	31546	th99	motherboardidredirection
1429	31547	th99	motherboardidredirection
1430	31548	th99	motherboardidredirection
1431	31549	th99	motherboardidredirection
1432	31550	th99	motherboardidredirection
1433	31551	th99	motherboardidredirection
1434	31552	th99	motherboardidredirection
1435	31553	th99	motherboardidredirection
1436	31554	th99	motherboardidredirection
1437	31555	th99	motherboardidredirection
1438	31556	th99	motherboardidredirection
1439	31557	th99	motherboardidredirection
1440	31558	th99	motherboardidredirection
1441	31559	th99	motherboardidredirection
1442	31560	th99	motherboardidredirection
1443	31561	th99	motherboardidredirection
1444	31562	th99	motherboardidredirection
1445	31563	th99	motherboardidredirection
1446	31564	th99	motherboardidredirection
1447	31565	th99	motherboardidredirection
1448	31566	th99	motherboardidredirection
1449	31567	th99	motherboardidredirection
1450	31568	th99	motherboardidredirection
1451	31569	th99	motherboardidredirection
1452	31570	th99	motherboardidredirection
1453	31571	th99	motherboardidredirection
1454	31572	th99	motherboardidredirection
1455	31573	th99	motherboardidredirection
1456	31574	th99	motherboardidredirection
1457	31575	th99	motherboardidredirection
1458	31576	th99	motherboardidredirection
1459	31577	th99	motherboardidredirection
1460	31578	th99	motherboardidredirection
1461	31579	th99	motherboardidredirection
1462	31580	th99	motherboardidredirection
1463	31581	th99	motherboardidredirection
1464	31582	th99	motherboardidredirection
1465	31583	th99	motherboardidredirection
1466	31584	th99	motherboardidredirection
1467	31585	th99	motherboardidredirection
1468	31586	th99	motherboardidredirection
1469	31587	th99	motherboardidredirection
1470	31588	th99	motherboardidredirection
1471	31589	th99	motherboardidredirection
1472	31590	th99	motherboardidredirection
1473	31591	th99	motherboardidredirection
1474	31592	th99	motherboardidredirection
1475	31593	th99	motherboardidredirection
1476	31594	th99	motherboardidredirection
1477	31595	th99	motherboardidredirection
1478	31596	th99	motherboardidredirection
1479	31598	th99	motherboardidredirection
1480	31599	th99	motherboardidredirection
1481	31600	th99	motherboardidredirection
1482	31601	th99	motherboardidredirection
1483	31602	th99	motherboardidredirection
1484	31603	th99	motherboardidredirection
1485	31604	th99	motherboardidredirection
1486	31605	th99	motherboardidredirection
1487	31606	th99	motherboardidredirection
1488	31607	th99	motherboardidredirection
1489	31608	th99	motherboardidredirection
1490	31609	th99	motherboardidredirection
1491	31610	th99	motherboardidredirection
1492	31611	th99	motherboardidredirection
1493	31612	th99	motherboardidredirection
1494	31613	th99	motherboardidredirection
1495	31614	th99	motherboardidredirection
1496	31615	th99	motherboardidredirection
1497	31616	th99	motherboardidredirection
1498	31617	th99	motherboardidredirection
1499	31618	th99	motherboardidredirection
1500	31619	th99	motherboardidredirection
1501	31620	th99	motherboardidredirection
1502	31621	th99	motherboardidredirection
1503	31622	th99	motherboardidredirection
1504	31623	th99	motherboardidredirection
1505	31624	th99	motherboardidredirection
1506	31626	th99	motherboardidredirection
1507	31627	th99	motherboardidredirection
1508	31629	th99	motherboardidredirection
1509	31631	th99	motherboardidredirection
1510	31632	th99	motherboardidredirection
1511	31633	th99	motherboardidredirection
1512	31634	th99	motherboardidredirection
1513	31635	th99	motherboardidredirection
1514	31636	th99	motherboardidredirection
1515	31637	th99	motherboardidredirection
1516	31638	th99	motherboardidredirection
1517	31639	th99	motherboardidredirection
1518	31640	th99	motherboardidredirection
1519	31641	th99	motherboardidredirection
1520	31643	th99	motherboardidredirection
1521	31645	th99	motherboardidredirection
1522	31646	th99	motherboardidredirection
1523	31647	th99	motherboardidredirection
1524	31648	th99	motherboardidredirection
1525	31649	th99	motherboardidredirection
1526	31650	th99	motherboardidredirection
1527	31651	th99	motherboardidredirection
1528	31652	th99	motherboardidredirection
1529	31654	th99	motherboardidredirection
1530	31655	th99	motherboardidredirection
1531	31656	th99	motherboardidredirection
1532	31657	th99	motherboardidredirection
1533	31658	th99	motherboardidredirection
1534	31659	th99	motherboardidredirection
1535	31660	th99	motherboardidredirection
1536	31661	th99	motherboardidredirection
1537	31662	th99	motherboardidredirection
1539	31664	th99	motherboardidredirection
1540	31665	th99	motherboardidredirection
1541	31666	th99	motherboardidredirection
1542	31667	th99	motherboardidredirection
1543	31668	th99	motherboardidredirection
1544	31669	th99	motherboardidredirection
1545	31670	th99	motherboardidredirection
1546	31671	th99	motherboardidredirection
1547	31672	th99	motherboardidredirection
1548	31673	th99	motherboardidredirection
1549	31674	th99	motherboardidredirection
1550	31675	th99	motherboardidredirection
1551	31676	th99	motherboardidredirection
1552	31677	th99	motherboardidredirection
1553	31678	th99	motherboardidredirection
1554	31679	th99	motherboardidredirection
1555	31680	th99	motherboardidredirection
1556	31681	th99	motherboardidredirection
1557	31682	th99	motherboardidredirection
1558	31683	th99	motherboardidredirection
1559	31684	th99	motherboardidredirection
1560	31686	th99	motherboardidredirection
1561	31687	th99	motherboardidredirection
1562	31688	th99	motherboardidredirection
1563	31689	th99	motherboardidredirection
1564	31690	th99	motherboardidredirection
1565	31691	th99	motherboardidredirection
1566	31692	th99	motherboardidredirection
1567	31693	th99	motherboardidredirection
1568	31694	th99	motherboardidredirection
1569	31695	th99	motherboardidredirection
1570	31696	th99	motherboardidredirection
1571	31697	th99	motherboardidredirection
1572	31698	th99	motherboardidredirection
1573	31700	th99	motherboardidredirection
1574	31701	th99	motherboardidredirection
1575	31703	th99	motherboardidredirection
1576	31704	th99	motherboardidredirection
1577	31705	th99	motherboardidredirection
1578	31707	th99	motherboardidredirection
1579	31708	th99	motherboardidredirection
1580	31709	th99	motherboardidredirection
1581	31710	th99	motherboardidredirection
1582	31711	th99	motherboardidredirection
1583	31712	th99	motherboardidredirection
1584	31713	th99	motherboardidredirection
1585	31714	th99	motherboardidredirection
1586	31715	th99	motherboardidredirection
1587	31716	th99	motherboardidredirection
1588	31717	th99	motherboardidredirection
1589	31718	th99	motherboardidredirection
1590	31719	th99	motherboardidredirection
1591	31720	th99	motherboardidredirection
1592	31721	th99	motherboardidredirection
1593	31722	th99	motherboardidredirection
1594	31723	th99	motherboardidredirection
1595	31724	th99	motherboardidredirection
1596	31725	th99	motherboardidredirection
1597	31726	th99	motherboardidredirection
1598	31727	th99	motherboardidredirection
1599	31728	th99	motherboardidredirection
1600	31729	th99	motherboardidredirection
1601	31730	th99	motherboardidredirection
1602	31731	th99	motherboardidredirection
1603	31732	th99	motherboardidredirection
1604	31733	th99	motherboardidredirection
1605	31734	th99	motherboardidredirection
1606	31735	th99	motherboardidredirection
1607	31736	th99	motherboardidredirection
1608	31737	th99	motherboardidredirection
1609	31738	th99	motherboardidredirection
1610	31739	th99	motherboardidredirection
1611	31740	th99	motherboardidredirection
1612	31741	th99	motherboardidredirection
1613	31742	th99	motherboardidredirection
1614	31743	th99	motherboardidredirection
1615	31744	th99	motherboardidredirection
1616	31745	th99	motherboardidredirection
1617	31746	th99	motherboardidredirection
1618	31747	th99	motherboardidredirection
1619	31748	th99	motherboardidredirection
1620	31749	th99	motherboardidredirection
1621	31751	th99	motherboardidredirection
1622	31753	th99	motherboardidredirection
1623	31754	th99	motherboardidredirection
1624	31756	th99	motherboardidredirection
1625	31757	th99	motherboardidredirection
1626	31758	th99	motherboardidredirection
1627	31761	th99	motherboardidredirection
1628	31763	th99	motherboardidredirection
1629	31764	th99	motherboardidredirection
1630	31765	th99	motherboardidredirection
1631	31766	th99	motherboardidredirection
1632	31767	th99	motherboardidredirection
1633	31768	th99	motherboardidredirection
1634	31769	th99	motherboardidredirection
1635	31770	th99	motherboardidredirection
1636	31771	th99	motherboardidredirection
1637	31773	th99	motherboardidredirection
1638	31774	th99	motherboardidredirection
1639	31775	th99	motherboardidredirection
1640	31776	th99	motherboardidredirection
1641	31777	th99	motherboardidredirection
1642	31778	th99	motherboardidredirection
1643	31779	th99	motherboardidredirection
1644	31780	th99	motherboardidredirection
1645	31781	th99	motherboardidredirection
1646	31782	th99	motherboardidredirection
1647	31783	th99	motherboardidredirection
1648	31784	th99	motherboardidredirection
1649	31785	th99	motherboardidredirection
1650	31786	th99	motherboardidredirection
1651	31787	th99	motherboardidredirection
1652	31788	th99	motherboardidredirection
1653	31789	th99	motherboardidredirection
1654	31790	th99	motherboardidredirection
1655	31791	th99	motherboardidredirection
1656	31792	th99	motherboardidredirection
1657	31793	th99	motherboardidredirection
1658	31794	th99	motherboardidredirection
1659	31795	th99	motherboardidredirection
1660	31796	th99	motherboardidredirection
1661	31797	th99	motherboardidredirection
1662	31799	th99	motherboardidredirection
1663	31801	th99	motherboardidredirection
1664	31802	th99	motherboardidredirection
1665	31803	th99	motherboardidredirection
1666	31804	th99	motherboardidredirection
1667	31805	th99	motherboardidredirection
1668	31806	th99	motherboardidredirection
1669	31807	th99	motherboardidredirection
1670	31808	th99	motherboardidredirection
1671	31809	th99	motherboardidredirection
1672	31810	th99	motherboardidredirection
1673	31811	th99	motherboardidredirection
1674	31812	th99	motherboardidredirection
1675	31813	th99	motherboardidredirection
1676	31814	th99	motherboardidredirection
1677	31816	th99	motherboardidredirection
1678	31817	th99	motherboardidredirection
1679	31819	th99	motherboardidredirection
1680	31820	th99	motherboardidredirection
1681	31821	th99	motherboardidredirection
1682	31822	th99	motherboardidredirection
1683	31823	th99	motherboardidredirection
1684	31824	th99	motherboardidredirection
1685	31825	th99	motherboardidredirection
1686	31826	th99	motherboardidredirection
1687	31827	th99	motherboardidredirection
1688	31828	th99	motherboardidredirection
1689	31829	th99	motherboardidredirection
1690	31830	th99	motherboardidredirection
1691	31831	th99	motherboardidredirection
1692	31832	th99	motherboardidredirection
1693	31833	th99	motherboardidredirection
1694	31836	th99	motherboardidredirection
1695	31838	th99	motherboardidredirection
1697	31840	th99	motherboardidredirection
1698	31841	th99	motherboardidredirection
1699	31843	th99	motherboardidredirection
1700	31844	th99	motherboardidredirection
1701	31846	th99	motherboardidredirection
1702	31847	th99	motherboardidredirection
1703	31848	th99	motherboardidredirection
1704	31849	th99	motherboardidredirection
1705	31850	th99	motherboardidredirection
1706	31851	th99	motherboardidredirection
1707	31852	th99	motherboardidredirection
1708	31853	th99	motherboardidredirection
1709	31854	th99	motherboardidredirection
1710	31855	th99	motherboardidredirection
1711	31856	th99	motherboardidredirection
1712	31857	th99	motherboardidredirection
1713	31858	th99	motherboardidredirection
1714	31859	th99	motherboardidredirection
1715	31860	th99	motherboardidredirection
1716	31861	th99	motherboardidredirection
1717	31862	th99	motherboardidredirection
1718	31863	th99	motherboardidredirection
1719	31864	th99	motherboardidredirection
1720	31865	th99	motherboardidredirection
1721	31866	th99	motherboardidredirection
1722	31869	th99	motherboardidredirection
1723	31870	th99	motherboardidredirection
1724	31871	th99	motherboardidredirection
1725	31872	th99	motherboardidredirection
1726	31874	th99	motherboardidredirection
1727	31875	th99	motherboardidredirection
1728	31877	th99	motherboardidredirection
1729	31878	th99	motherboardidredirection
1730	31880	th99	motherboardidredirection
1731	31881	th99	motherboardidredirection
1732	31882	th99	motherboardidredirection
1733	31883	th99	motherboardidredirection
1734	31884	th99	motherboardidredirection
1735	31885	th99	motherboardidredirection
1736	31886	th99	motherboardidredirection
1737	31887	th99	motherboardidredirection
1738	31888	th99	motherboardidredirection
1739	31889	th99	motherboardidredirection
1740	31890	th99	motherboardidredirection
1741	31891	th99	motherboardidredirection
1742	31892	th99	motherboardidredirection
1743	31893	th99	motherboardidredirection
1744	31894	th99	motherboardidredirection
1745	31895	th99	motherboardidredirection
1746	31896	th99	motherboardidredirection
1747	31897	th99	motherboardidredirection
1748	31898	th99	motherboardidredirection
1749	31899	th99	motherboardidredirection
1750	31900	th99	motherboardidredirection
1751	31901	th99	motherboardidredirection
1752	31902	th99	motherboardidredirection
1753	31903	th99	motherboardidredirection
1754	31904	th99	motherboardidredirection
1755	31905	th99	motherboardidredirection
1756	31906	th99	motherboardidredirection
1757	31908	th99	motherboardidredirection
1758	31909	th99	motherboardidredirection
1759	31910	th99	motherboardidredirection
1760	31911	th99	motherboardidredirection
1761	31913	th99	motherboardidredirection
1762	31914	th99	motherboardidredirection
1763	31915	th99	motherboardidredirection
1764	31916	th99	motherboardidredirection
1765	31917	th99	motherboardidredirection
1766	31920	th99	motherboardidredirection
1767	31922	th99	motherboardidredirection
1768	31923	th99	motherboardidredirection
1769	31924	th99	motherboardidredirection
1770	31925	th99	motherboardidredirection
1771	31926	th99	motherboardidredirection
1772	31927	th99	motherboardidredirection
1773	31928	th99	motherboardidredirection
1774	31929	th99	motherboardidredirection
1775	31930	th99	motherboardidredirection
1776	31931	th99	motherboardidredirection
1777	31932	th99	motherboardidredirection
1778	31933	th99	motherboardidredirection
1779	31934	th99	motherboardidredirection
1780	31935	th99	motherboardidredirection
1781	31936	th99	motherboardidredirection
1782	31937	th99	motherboardidredirection
1783	31941	th99	motherboardidredirection
1784	31942	th99	motherboardidredirection
1785	31943	th99	motherboardidredirection
1786	31944	th99	motherboardidredirection
1787	31945	th99	motherboardidredirection
1788	31946	th99	motherboardidredirection
1789	31947	th99	motherboardidredirection
1790	31948	th99	motherboardidredirection
1791	31949	th99	motherboardidredirection
1793	31951	th99	motherboardidredirection
1794	31952	th99	motherboardidredirection
1795	31953	th99	motherboardidredirection
1796	31954	th99	motherboardidredirection
1797	31955	th99	motherboardidredirection
1798	31956	th99	motherboardidredirection
1799	31958	th99	motherboardidredirection
1800	31959	th99	motherboardidredirection
1802	31961	th99	motherboardidredirection
1803	31962	th99	motherboardidredirection
1804	31963	th99	motherboardidredirection
1805	31964	th99	motherboardidredirection
1806	31965	th99	motherboardidredirection
1807	31966	th99	motherboardidredirection
1808	31967	th99	motherboardidredirection
1809	31970	th99	motherboardidredirection
1810	31971	th99	motherboardidredirection
1811	31972	th99	motherboardidredirection
1812	31974	th99	motherboardidredirection
1813	31975	th99	motherboardidredirection
1814	31976	th99	motherboardidredirection
1815	31977	th99	motherboardidredirection
1816	31978	th99	motherboardidredirection
1817	31979	th99	motherboardidredirection
1818	31980	th99	motherboardidredirection
1819	31981	th99	motherboardidredirection
1820	31982	th99	motherboardidredirection
1821	31983	th99	motherboardidredirection
1822	31984	th99	motherboardidredirection
1823	31985	th99	motherboardidredirection
1824	31986	th99	motherboardidredirection
1826	31988	th99	motherboardidredirection
1827	31990	th99	motherboardidredirection
1828	31991	th99	motherboardidredirection
1829	31993	th99	motherboardidredirection
1830	31994	th99	motherboardidredirection
1831	31995	th99	motherboardidredirection
1832	31996	th99	motherboardidredirection
1833	31997	th99	motherboardidredirection
1834	31999	th99	motherboardidredirection
1835	32000	th99	motherboardidredirection
1836	32001	th99	motherboardidredirection
1837	32002	th99	motherboardidredirection
1838	32003	th99	motherboardidredirection
1839	32004	th99	motherboardidredirection
1840	32005	th99	motherboardidredirection
1841	32006	th99	motherboardidredirection
1842	32007	th99	motherboardidredirection
1843	32008	th99	motherboardidredirection
1844	32009	th99	motherboardidredirection
1845	32010	th99	motherboardidredirection
1846	32011	th99	motherboardidredirection
1847	32012	th99	motherboardidredirection
1848	32013	th99	motherboardidredirection
1849	32014	th99	motherboardidredirection
1850	32015	th99	motherboardidredirection
1851	32016	th99	motherboardidredirection
1852	32017	th99	motherboardidredirection
1853	32018	th99	motherboardidredirection
1854	32019	th99	motherboardidredirection
1855	32020	th99	motherboardidredirection
1856	32021	th99	motherboardidredirection
1857	32022	th99	motherboardidredirection
1858	32023	th99	motherboardidredirection
1859	32024	th99	motherboardidredirection
1860	32025	th99	motherboardidredirection
1861	32026	th99	motherboardidredirection
1862	32027	th99	motherboardidredirection
1863	32028	th99	motherboardidredirection
1864	32029	th99	motherboardidredirection
1865	32031	th99	motherboardidredirection
1866	32032	th99	motherboardidredirection
1867	32033	th99	motherboardidredirection
1868	32036	th99	motherboardidredirection
1869	32037	th99	motherboardidredirection
1870	32038	th99	motherboardidredirection
1871	32039	th99	motherboardidredirection
1872	32040	th99	motherboardidredirection
1873	32041	th99	motherboardidredirection
1874	32042	th99	motherboardidredirection
1875	32043	th99	motherboardidredirection
1876	32044	th99	motherboardidredirection
1877	32045	th99	motherboardidredirection
1878	32046	th99	motherboardidredirection
1879	32047	th99	motherboardidredirection
1880	32048	th99	motherboardidredirection
1881	32050	th99	motherboardidredirection
1882	32051	th99	motherboardidredirection
1884	32054	th99	motherboardidredirection
1886	32056	th99	motherboardidredirection
1887	32057	th99	motherboardidredirection
1888	32058	th99	motherboardidredirection
1889	32059	th99	motherboardidredirection
1890	32060	th99	motherboardidredirection
1891	32061	th99	motherboardidredirection
1892	32062	th99	motherboardidredirection
1893	32063	th99	motherboardidredirection
1894	32065	th99	motherboardidredirection
1895	32066	th99	motherboardidredirection
1896	32067	th99	motherboardidredirection
1897	32068	th99	motherboardidredirection
1898	32069	th99	motherboardidredirection
1899	32070	th99	motherboardidredirection
1900	32071	th99	motherboardidredirection
1901	32073	th99	motherboardidredirection
1902	32074	th99	motherboardidredirection
1903	32076	th99	motherboardidredirection
1904	32077	th99	motherboardidredirection
1905	32078	th99	motherboardidredirection
1906	32079	th99	motherboardidredirection
1907	32080	th99	motherboardidredirection
1908	32081	th99	motherboardidredirection
1909	32082	th99	motherboardidredirection
1910	32083	th99	motherboardidredirection
1911	32084	th99	motherboardidredirection
1912	32085	th99	motherboardidredirection
1913	32086	th99	motherboardidredirection
1914	32087	th99	motherboardidredirection
1915	32088	th99	motherboardidredirection
1916	32089	th99	motherboardidredirection
1917	32090	th99	motherboardidredirection
1918	32091	th99	motherboardidredirection
1919	32092	th99	motherboardidredirection
1920	32093	th99	motherboardidredirection
1921	32094	th99	motherboardidredirection
1922	32095	th99	motherboardidredirection
1923	32096	th99	motherboardidredirection
1924	32097	th99	motherboardidredirection
1925	32098	th99	motherboardidredirection
1926	32099	th99	motherboardidredirection
1927	32100	th99	motherboardidredirection
1928	32101	th99	motherboardidredirection
1929	32102	th99	motherboardidredirection
1930	32104	th99	motherboardidredirection
1932	32106	th99	motherboardidredirection
1933	32107	th99	motherboardidredirection
1934	32109	th99	motherboardidredirection
1935	32110	th99	motherboardidredirection
1936	32111	th99	motherboardidredirection
1937	32112	th99	motherboardidredirection
1938	32113	th99	motherboardidredirection
1939	32114	th99	motherboardidredirection
1940	32115	th99	motherboardidredirection
1941	32116	th99	motherboardidredirection
1942	32117	th99	motherboardidredirection
1943	32118	th99	motherboardidredirection
1944	32119	th99	motherboardidredirection
1945	32120	th99	motherboardidredirection
1946	32121	th99	motherboardidredirection
1947	32122	th99	motherboardidredirection
1948	32123	th99	motherboardidredirection
1949	32124	th99	motherboardidredirection
1950	32125	th99	motherboardidredirection
1951	32126	th99	motherboardidredirection
1952	32127	th99	motherboardidredirection
1953	32128	th99	motherboardidredirection
1954	32129	th99	motherboardidredirection
1955	32130	th99	motherboardidredirection
1956	32131	th99	motherboardidredirection
1957	32132	th99	motherboardidredirection
1958	32133	th99	motherboardidredirection
1959	32134	th99	motherboardidredirection
1960	32135	th99	motherboardidredirection
1961	32136	th99	motherboardidredirection
1962	32137	th99	motherboardidredirection
1963	32138	th99	motherboardidredirection
1964	32139	th99	motherboardidredirection
1965	32140	th99	motherboardidredirection
1966	32141	th99	motherboardidredirection
1967	32142	th99	motherboardidredirection
1968	32143	th99	motherboardidredirection
1969	32145	th99	motherboardidredirection
1970	32146	th99	motherboardidredirection
1971	32148	th99	motherboardidredirection
1972	32149	th99	motherboardidredirection
1973	32150	th99	motherboardidredirection
1974	32151	th99	motherboardidredirection
1975	32152	th99	motherboardidredirection
1976	32153	th99	motherboardidredirection
1977	32154	th99	motherboardidredirection
1978	32155	th99	motherboardidredirection
1979	32156	th99	motherboardidredirection
1980	32157	th99	motherboardidredirection
1981	32158	th99	motherboardidredirection
1982	32160	th99	motherboardidredirection
1983	32161	th99	motherboardidredirection
1984	32162	th99	motherboardidredirection
1985	32164	th99	motherboardidredirection
1986	32165	th99	motherboardidredirection
1987	32166	th99	motherboardidredirection
1988	32167	th99	motherboardidredirection
1989	32170	th99	motherboardidredirection
1990	32171	th99	motherboardidredirection
1991	32173	th99	motherboardidredirection
1992	32175	th99	motherboardidredirection
1993	32176	th99	motherboardidredirection
1994	32177	th99	motherboardidredirection
1995	32178	th99	motherboardidredirection
1996	32179	th99	motherboardidredirection
1997	32180	th99	motherboardidredirection
1998	32181	th99	motherboardidredirection
1999	32182	th99	motherboardidredirection
2000	32183	th99	motherboardidredirection
2001	32184	th99	motherboardidredirection
2002	32185	th99	motherboardidredirection
2003	32186	th99	motherboardidredirection
2004	32187	th99	motherboardidredirection
2005	32188	th99	motherboardidredirection
2006	32189	th99	motherboardidredirection
2007	32190	th99	motherboardidredirection
2008	32191	th99	motherboardidredirection
2009	32192	th99	motherboardidredirection
2010	32193	th99	motherboardidredirection
2011	32194	th99	motherboardidredirection
2012	32195	th99	motherboardidredirection
2013	32196	th99	motherboardidredirection
2014	32197	th99	motherboardidredirection
2015	32198	th99	motherboardidredirection
2016	32199	th99	motherboardidredirection
2017	32200	th99	motherboardidredirection
2018	32201	th99	motherboardidredirection
2019	32202	th99	motherboardidredirection
2020	32203	th99	motherboardidredirection
2021	32204	th99	motherboardidredirection
2022	32205	th99	motherboardidredirection
2023	32206	th99	motherboardidredirection
2024	32207	th99	motherboardidredirection
2025	32208	th99	motherboardidredirection
2026	32209	th99	motherboardidredirection
2027	32211	th99	motherboardidredirection
2028	32212	th99	motherboardidredirection
2029	32213	th99	motherboardidredirection
2030	32214	th99	motherboardidredirection
2031	32215	th99	motherboardidredirection
2032	32216	th99	motherboardidredirection
2033	32217	th99	motherboardidredirection
2034	32218	th99	motherboardidredirection
2035	32219	th99	motherboardidredirection
2036	32221	th99	motherboardidredirection
2037	32223	th99	motherboardidredirection
2038	32224	th99	motherboardidredirection
2039	32225	th99	motherboardidredirection
2040	32226	th99	motherboardidredirection
2041	32228	th99	motherboardidredirection
2042	32229	th99	motherboardidredirection
2043	32230	th99	motherboardidredirection
2044	32231	th99	motherboardidredirection
2045	32232	th99	motherboardidredirection
2046	32239	th99	motherboardidredirection
2047	32240	th99	motherboardidredirection
2048	32241	th99	motherboardidredirection
2049	32243	th99	motherboardidredirection
2050	32244	th99	motherboardidredirection
2051	32245	th99	motherboardidredirection
2052	32246	th99	motherboardidredirection
2053	32247	th99	motherboardidredirection
2054	32248	th99	motherboardidredirection
2055	32249	th99	motherboardidredirection
2056	32250	th99	motherboardidredirection
2057	32251	th99	motherboardidredirection
2058	32252	th99	motherboardidredirection
2059	32253	th99	motherboardidredirection
2060	32254	th99	motherboardidredirection
2061	32255	th99	motherboardidredirection
2062	32257	th99	motherboardidredirection
2063	32258	th99	motherboardidredirection
2064	32259	th99	motherboardidredirection
2065	32260	th99	motherboardidredirection
2066	32263	th99	motherboardidredirection
2067	32264	th99	motherboardidredirection
2068	32265	th99	motherboardidredirection
2069	32266	th99	motherboardidredirection
2070	32267	th99	motherboardidredirection
2071	32272	th99	motherboardidredirection
2072	32273	th99	motherboardidredirection
2073	32274	th99	motherboardidredirection
2074	32275	th99	motherboardidredirection
2075	32276	th99	motherboardidredirection
2076	32278	th99	motherboardidredirection
2077	32279	th99	motherboardidredirection
2078	32280	th99	motherboardidredirection
2079	32281	th99	motherboardidredirection
2080	32282	th99	motherboardidredirection
2081	32283	th99	motherboardidredirection
2082	32284	th99	motherboardidredirection
2083	32285	th99	motherboardidredirection
2084	32288	th99	motherboardidredirection
2085	32289	th99	motherboardidredirection
2086	32290	th99	motherboardidredirection
2087	32291	th99	motherboardidredirection
2088	32292	th99	motherboardidredirection
2089	32293	th99	motherboardidredirection
2090	32294	th99	motherboardidredirection
2091	32295	th99	motherboardidredirection
2092	32296	th99	motherboardidredirection
2093	32297	th99	motherboardidredirection
2094	32298	th99	motherboardidredirection
2095	32299	th99	motherboardidredirection
2096	32300	th99	motherboardidredirection
2097	32301	th99	motherboardidredirection
2098	32304	th99	motherboardidredirection
2099	32305	th99	motherboardidredirection
2100	32306	th99	motherboardidredirection
2101	32307	th99	motherboardidredirection
2102	32308	th99	motherboardidredirection
2103	32309	th99	motherboardidredirection
2104	32310	th99	motherboardidredirection
2105	32311	th99	motherboardidredirection
2106	32312	th99	motherboardidredirection
2107	32313	th99	motherboardidredirection
2108	32314	th99	motherboardidredirection
2109	32315	th99	motherboardidredirection
2110	32316	th99	motherboardidredirection
2111	32317	th99	motherboardidredirection
2112	32318	th99	motherboardidredirection
2113	32319	th99	motherboardidredirection
2114	32320	th99	motherboardidredirection
2115	32321	th99	motherboardidredirection
2116	32322	th99	motherboardidredirection
2117	32323	th99	motherboardidredirection
2118	32324	th99	motherboardidredirection
2119	32325	th99	motherboardidredirection
2120	32326	th99	motherboardidredirection
2121	32327	th99	motherboardidredirection
2122	32328	th99	motherboardidredirection
2123	32329	th99	motherboardidredirection
2124	32330	th99	motherboardidredirection
2125	32331	th99	motherboardidredirection
2126	32332	th99	motherboardidredirection
2127	32333	th99	motherboardidredirection
2128	32334	th99	motherboardidredirection
2129	32336	th99	motherboardidredirection
2130	32337	th99	motherboardidredirection
2131	32338	th99	motherboardidredirection
2132	32339	th99	motherboardidredirection
2133	32341	th99	motherboardidredirection
2134	32342	th99	motherboardidredirection
2135	32343	th99	motherboardidredirection
2136	32344	th99	motherboardidredirection
2137	32345	th99	motherboardidredirection
2138	32346	th99	motherboardidredirection
2139	32347	th99	motherboardidredirection
2140	32348	th99	motherboardidredirection
2141	32349	th99	motherboardidredirection
2142	32350	th99	motherboardidredirection
2143	32351	th99	motherboardidredirection
2144	32352	th99	motherboardidredirection
2145	32354	th99	motherboardidredirection
2146	32355	th99	motherboardidredirection
2147	32356	th99	motherboardidredirection
2148	32357	th99	motherboardidredirection
2149	32358	th99	motherboardidredirection
2150	32359	th99	motherboardidredirection
2151	32360	th99	motherboardidredirection
2152	32361	th99	motherboardidredirection
2153	32362	th99	motherboardidredirection
2154	32363	th99	motherboardidredirection
2155	32364	th99	motherboardidredirection
2156	32365	th99	motherboardidredirection
2157	32366	th99	motherboardidredirection
2158	32367	th99	motherboardidredirection
2159	32368	th99	motherboardidredirection
2160	32369	th99	motherboardidredirection
2161	32370	th99	motherboardidredirection
2162	32372	th99	motherboardidredirection
2163	32374	th99	motherboardidredirection
2164	32375	th99	motherboardidredirection
2165	32376	th99	motherboardidredirection
2166	32377	th99	motherboardidredirection
2167	32378	th99	motherboardidredirection
2168	32379	th99	motherboardidredirection
2169	32380	th99	motherboardidredirection
2170	32381	th99	motherboardidredirection
2171	32382	th99	motherboardidredirection
2172	32383	th99	motherboardidredirection
2173	32384	th99	motherboardidredirection
2174	32385	th99	motherboardidredirection
2175	32386	th99	motherboardidredirection
2176	32390	th99	motherboardidredirection
2177	32392	th99	motherboardidredirection
2178	32393	th99	motherboardidredirection
2179	32394	th99	motherboardidredirection
2180	32395	th99	motherboardidredirection
2181	32396	th99	motherboardidredirection
2182	32397	th99	motherboardidredirection
2183	32401	th99	motherboardidredirection
2184	32402	th99	motherboardidredirection
2185	32403	th99	motherboardidredirection
2186	32404	th99	motherboardidredirection
2187	32405	th99	motherboardidredirection
2188	32406	th99	motherboardidredirection
2189	32408	th99	motherboardidredirection
2190	32409	th99	motherboardidredirection
2191	32410	th99	motherboardidredirection
2192	32411	th99	motherboardidredirection
2193	32412	th99	motherboardidredirection
2194	32413	th99	motherboardidredirection
2195	32414	th99	motherboardidredirection
2196	32415	th99	motherboardidredirection
2197	32417	th99	motherboardidredirection
2198	32418	th99	motherboardidredirection
2199	32419	th99	motherboardidredirection
2200	32420	th99	motherboardidredirection
2201	32421	th99	motherboardidredirection
2202	32422	th99	motherboardidredirection
2203	32423	th99	motherboardidredirection
2204	32424	th99	motherboardidredirection
2205	32425	th99	motherboardidredirection
2206	32426	th99	motherboardidredirection
2207	32427	th99	motherboardidredirection
2208	32428	th99	motherboardidredirection
2209	32429	th99	motherboardidredirection
2210	32430	th99	motherboardidredirection
2211	32431	th99	motherboardidredirection
2212	32434	th99	motherboardidredirection
2213	32435	th99	motherboardidredirection
2214	32436	th99	motherboardidredirection
2215	32437	th99	motherboardidredirection
2216	32438	th99	motherboardidredirection
2217	32439	th99	motherboardidredirection
2218	32440	th99	motherboardidredirection
2219	32441	th99	motherboardidredirection
2220	32442	th99	motherboardidredirection
2221	32444	th99	motherboardidredirection
2222	32445	th99	motherboardidredirection
2223	32446	th99	motherboardidredirection
2224	32447	th99	motherboardidredirection
2225	32448	th99	motherboardidredirection
2226	32449	th99	motherboardidredirection
2227	32450	th99	motherboardidredirection
2228	32451	th99	motherboardidredirection
2229	32452	th99	motherboardidredirection
2230	32453	th99	motherboardidredirection
2231	32454	th99	motherboardidredirection
2232	32455	th99	motherboardidredirection
2233	32456	th99	motherboardidredirection
2234	32457	th99	motherboardidredirection
2235	32458	th99	motherboardidredirection
2236	32459	th99	motherboardidredirection
2237	32460	th99	motherboardidredirection
2238	32461	th99	motherboardidredirection
2239	32462	th99	motherboardidredirection
2240	32463	th99	motherboardidredirection
2241	32464	th99	motherboardidredirection
2242	32465	th99	motherboardidredirection
2243	32466	th99	motherboardidredirection
2244	32468	th99	motherboardidredirection
2245	32469	th99	motherboardidredirection
2246	32470	th99	motherboardidredirection
2247	32471	th99	motherboardidredirection
2248	32472	th99	motherboardidredirection
2249	32473	th99	motherboardidredirection
2250	32474	th99	motherboardidredirection
2251	32475	th99	motherboardidredirection
2252	32476	th99	motherboardidredirection
2253	32477	th99	motherboardidredirection
2254	32478	th99	motherboardidredirection
2255	32479	th99	motherboardidredirection
2256	32480	th99	motherboardidredirection
2258	32482	th99	motherboardidredirection
2259	32483	th99	motherboardidredirection
2260	32484	th99	motherboardidredirection
2261	32485	th99	motherboardidredirection
2262	32486	th99	motherboardidredirection
2263	32487	th99	motherboardidredirection
2264	32488	th99	motherboardidredirection
2265	32489	th99	motherboardidredirection
2266	32490	th99	motherboardidredirection
2267	32491	th99	motherboardidredirection
2268	32492	th99	motherboardidredirection
2269	32493	th99	motherboardidredirection
2270	32494	th99	motherboardidredirection
2271	32495	th99	motherboardidredirection
2272	32496	th99	motherboardidredirection
2273	32497	th99	motherboardidredirection
2274	32498	th99	motherboardidredirection
2275	32499	th99	motherboardidredirection
2276	32500	th99	motherboardidredirection
2277	32501	th99	motherboardidredirection
2278	32502	th99	motherboardidredirection
2279	32503	th99	motherboardidredirection
2280	32504	th99	motherboardidredirection
2281	32505	th99	motherboardidredirection
2282	32507	th99	motherboardidredirection
2283	32508	th99	motherboardidredirection
2284	32509	th99	motherboardidredirection
2285	32510	th99	motherboardidredirection
2286	32511	th99	motherboardidredirection
2287	32512	th99	motherboardidredirection
2289	32515	th99	motherboardidredirection
2290	32516	th99	motherboardidredirection
2291	32517	th99	motherboardidredirection
2292	32518	th99	motherboardidredirection
2293	32519	th99	motherboardidredirection
2294	32520	th99	motherboardidredirection
2295	32521	th99	motherboardidredirection
2296	32522	th99	motherboardidredirection
2297	32523	th99	motherboardidredirection
2298	32525	th99	motherboardidredirection
2299	32526	th99	motherboardidredirection
2300	32527	th99	motherboardidredirection
2301	32528	th99	motherboardidredirection
2302	32529	th99	motherboardidredirection
2303	32530	th99	motherboardidredirection
2304	32531	th99	motherboardidredirection
2305	32532	th99	motherboardidredirection
2306	32533	th99	motherboardidredirection
2307	32534	th99	motherboardidredirection
2308	32535	th99	motherboardidredirection
2309	32537	th99	motherboardidredirection
2310	32538	th99	motherboardidredirection
2311	32540	th99	motherboardidredirection
2312	32541	th99	motherboardidredirection
2313	32542	th99	motherboardidredirection
2314	32543	th99	motherboardidredirection
2315	32544	th99	motherboardidredirection
2316	32545	th99	motherboardidredirection
2317	32546	th99	motherboardidredirection
2318	32547	th99	motherboardidredirection
2319	32548	th99	motherboardidredirection
2320	32549	th99	motherboardidredirection
2321	32550	th99	motherboardidredirection
2322	32551	th99	motherboardidredirection
2323	32553	th99	motherboardidredirection
2324	32554	th99	motherboardidredirection
2325	32555	th99	motherboardidredirection
2327	32557	th99	motherboardidredirection
2328	32558	th99	motherboardidredirection
2329	32559	th99	motherboardidredirection
2330	32560	th99	motherboardidredirection
2331	32561	th99	motherboardidredirection
2332	32562	th99	motherboardidredirection
2333	32563	th99	motherboardidredirection
2334	32564	th99	motherboardidredirection
2335	32565	th99	motherboardidredirection
2336	32566	th99	motherboardidredirection
2337	32567	th99	motherboardidredirection
2338	32568	th99	motherboardidredirection
2339	32570	th99	motherboardidredirection
2340	32571	th99	motherboardidredirection
2341	32572	th99	motherboardidredirection
2342	32573	th99	motherboardidredirection
2343	32574	th99	motherboardidredirection
2344	32575	th99	motherboardidredirection
2345	32576	th99	motherboardidredirection
2346	32577	th99	motherboardidredirection
2347	32578	th99	motherboardidredirection
2348	32579	th99	motherboardidredirection
2349	32580	th99	motherboardidredirection
2350	32581	th99	motherboardidredirection
2351	32582	th99	motherboardidredirection
2352	32583	th99	motherboardidredirection
2353	32584	th99	motherboardidredirection
2354	32585	th99	motherboardidredirection
2355	32586	th99	motherboardidredirection
2356	32587	th99	motherboardidredirection
2357	32588	th99	motherboardidredirection
2358	32589	th99	motherboardidredirection
2359	32590	th99	motherboardidredirection
2360	32591	th99	motherboardidredirection
2362	32593	th99	motherboardidredirection
2363	32594	th99	motherboardidredirection
2364	32595	th99	motherboardidredirection
2365	32596	th99	motherboardidredirection
2366	32597	th99	motherboardidredirection
2367	32598	th99	motherboardidredirection
2368	32599	th99	motherboardidredirection
2369	32600	th99	motherboardidredirection
2370	32601	th99	motherboardidredirection
2371	32602	th99	motherboardidredirection
2372	32603	th99	motherboardidredirection
2373	32605	th99	motherboardidredirection
2374	32606	th99	motherboardidredirection
2375	32607	th99	motherboardidredirection
2376	32608	th99	motherboardidredirection
2377	32609	th99	motherboardidredirection
2378	32610	th99	motherboardidredirection
2379	32611	th99	motherboardidredirection
2380	32612	th99	motherboardidredirection
2381	32613	th99	motherboardidredirection
2382	32614	th99	motherboardidredirection
2383	32615	th99	motherboardidredirection
2384	32616	th99	motherboardidredirection
2385	32618	th99	motherboardidredirection
2386	32619	th99	motherboardidredirection
2387	32620	th99	motherboardidredirection
2388	32621	th99	motherboardidredirection
2389	32622	th99	motherboardidredirection
2390	32623	th99	motherboardidredirection
2391	32624	th99	motherboardidredirection
2392	32625	th99	motherboardidredirection
2393	32626	th99	motherboardidredirection
2394	32627	th99	motherboardidredirection
2395	32628	th99	motherboardidredirection
2396	32629	th99	motherboardidredirection
2397	32630	th99	motherboardidredirection
2398	32631	th99	motherboardidredirection
2399	32632	th99	motherboardidredirection
2400	32633	th99	motherboardidredirection
2401	32634	th99	motherboardidredirection
2402	32635	th99	motherboardidredirection
2403	32636	th99	motherboardidredirection
2404	32637	th99	motherboardidredirection
2405	32638	th99	motherboardidredirection
2406	32639	th99	motherboardidredirection
2407	32640	th99	motherboardidredirection
2408	32641	th99	motherboardidredirection
2409	32644	th99	motherboardidredirection
2410	32645	th99	motherboardidredirection
2411	32648	th99	motherboardidredirection
2412	32650	th99	motherboardidredirection
2413	32651	th99	motherboardidredirection
2414	32652	th99	motherboardidredirection
2415	32653	th99	motherboardidredirection
2416	32654	th99	motherboardidredirection
2417	32655	th99	motherboardidredirection
2418	32656	th99	motherboardidredirection
2419	32657	th99	motherboardidredirection
2420	32658	th99	motherboardidredirection
2421	32659	th99	motherboardidredirection
2422	32660	th99	motherboardidredirection
2423	32661	th99	motherboardidredirection
2424	32662	th99	motherboardidredirection
2425	32663	th99	motherboardidredirection
2426	32664	th99	motherboardidredirection
2427	32665	th99	motherboardidredirection
2428	32666	th99	motherboardidredirection
2429	32667	th99	motherboardidredirection
2430	32668	th99	motherboardidredirection
2431	32669	th99	motherboardidredirection
2432	32670	th99	motherboardidredirection
2433	32672	th99	motherboardidredirection
2434	32673	th99	motherboardidredirection
2435	32674	th99	motherboardidredirection
2436	32675	th99	motherboardidredirection
2437	32676	th99	motherboardidredirection
2438	32677	th99	motherboardidredirection
2439	32678	th99	motherboardidredirection
2440	32679	th99	motherboardidredirection
2441	32680	th99	motherboardidredirection
2442	32681	th99	motherboardidredirection
2443	32682	th99	motherboardidredirection
2444	32685	th99	motherboardidredirection
2445	32687	th99	motherboardidredirection
2446	32688	th99	motherboardidredirection
2447	32689	th99	motherboardidredirection
2448	32691	th99	motherboardidredirection
2449	32692	th99	motherboardidredirection
2450	32693	th99	motherboardidredirection
2451	32694	th99	motherboardidredirection
2452	32695	th99	motherboardidredirection
2453	32696	th99	motherboardidredirection
2454	32697	th99	motherboardidredirection
2455	32698	th99	motherboardidredirection
2456	32699	th99	motherboardidredirection
2457	32700	th99	motherboardidredirection
2458	32701	th99	motherboardidredirection
2459	32702	th99	motherboardidredirection
2460	32703	th99	motherboardidredirection
2461	32704	th99	motherboardidredirection
2462	32705	th99	motherboardidredirection
2463	32706	th99	motherboardidredirection
2464	32707	th99	motherboardidredirection
2465	32708	th99	motherboardidredirection
2466	32709	th99	motherboardidredirection
2467	32710	th99	motherboardidredirection
2468	32711	th99	motherboardidredirection
2469	32712	th99	motherboardidredirection
2470	32713	th99	motherboardidredirection
2471	32714	th99	motherboardidredirection
2472	32715	th99	motherboardidredirection
2473	32716	th99	motherboardidredirection
2474	32717	th99	motherboardidredirection
2475	32718	th99	motherboardidredirection
2476	32720	th99	motherboardidredirection
2477	32722	th99	motherboardidredirection
2478	32723	th99	motherboardidredirection
2479	32724	th99	motherboardidredirection
2480	32725	th99	motherboardidredirection
2481	32726	th99	motherboardidredirection
2482	32729	th99	motherboardidredirection
2483	32730	th99	motherboardidredirection
2484	32731	th99	motherboardidredirection
2485	32732	th99	motherboardidredirection
2486	32733	th99	motherboardidredirection
2487	32734	th99	motherboardidredirection
2488	32735	th99	motherboardidredirection
2489	32736	th99	motherboardidredirection
2490	32737	th99	motherboardidredirection
2491	32738	th99	motherboardidredirection
2492	32739	th99	motherboardidredirection
2493	32740	th99	motherboardidredirection
2494	32741	th99	motherboardidredirection
2495	32742	th99	motherboardidredirection
2496	32743	th99	motherboardidredirection
2497	32744	th99	motherboardidredirection
2499	32746	th99	motherboardidredirection
2500	32750	th99	motherboardidredirection
2501	32752	th99	motherboardidredirection
2502	32753	th99	motherboardidredirection
2503	32754	th99	motherboardidredirection
2504	32755	th99	motherboardidredirection
2505	32756	th99	motherboardidredirection
2506	32757	th99	motherboardidredirection
2507	32758	th99	motherboardidredirection
2508	32759	th99	motherboardidredirection
2509	32760	th99	motherboardidredirection
2510	32761	th99	motherboardidredirection
2511	32763	th99	motherboardidredirection
2512	32764	th99	motherboardidredirection
2513	32765	th99	motherboardidredirection
2514	32766	th99	motherboardidredirection
2515	32767	th99	motherboardidredirection
2516	32768	th99	motherboardidredirection
2517	32769	th99	motherboardidredirection
2518	32770	th99	motherboardidredirection
2519	32772	th99	motherboardidredirection
2520	32773	th99	motherboardidredirection
2521	32774	th99	motherboardidredirection
2522	32775	th99	motherboardidredirection
2523	32776	th99	motherboardidredirection
2524	32777	th99	motherboardidredirection
2525	32778	th99	motherboardidredirection
2526	32779	th99	motherboardidredirection
2527	32780	th99	motherboardidredirection
2528	32781	th99	motherboardidredirection
2529	32782	th99	motherboardidredirection
2530	32783	th99	motherboardidredirection
2531	32784	th99	motherboardidredirection
2532	32785	th99	motherboardidredirection
2533	32786	th99	motherboardidredirection
2534	32787	th99	motherboardidredirection
2535	32787	th99	motherboardidredirection
2536	32788	th99	motherboardidredirection
2537	32789	th99	motherboardidredirection
2538	32790	th99	motherboardidredirection
2539	32791	th99	motherboardidredirection
2540	32792	th99	motherboardidredirection
2541	32793	th99	motherboardidredirection
2542	32794	th99	motherboardidredirection
2543	32795	th99	motherboardidredirection
2544	32796	th99	motherboardidredirection
2545	32797	th99	motherboardidredirection
2546	32799	th99	motherboardidredirection
2547	32800	th99	motherboardidredirection
2548	32801	th99	motherboardidredirection
2549	32802	th99	motherboardidredirection
2550	32803	th99	motherboardidredirection
2551	32804	th99	motherboardidredirection
2552	32805	th99	motherboardidredirection
2553	32806	th99	motherboardidredirection
2554	32807	th99	motherboardidredirection
2555	32808	th99	motherboardidredirection
2556	32809	th99	motherboardidredirection
2557	32810	th99	motherboardidredirection
2558	32812	th99	motherboardidredirection
2559	32813	th99	motherboardidredirection
2560	32814	th99	motherboardidredirection
2561	32815	th99	motherboardidredirection
2562	32816	th99	motherboardidredirection
2563	32817	th99	motherboardidredirection
2564	32818	th99	motherboardidredirection
2565	32819	th99	motherboardidredirection
2566	32820	th99	motherboardidredirection
2567	32821	th99	motherboardidredirection
2568	32822	th99	motherboardidredirection
2569	32823	th99	motherboardidredirection
2570	32824	th99	motherboardidredirection
2571	32825	th99	motherboardidredirection
2572	32826	th99	motherboardidredirection
2573	32827	th99	motherboardidredirection
2574	32828	th99	motherboardidredirection
2575	32829	th99	motherboardidredirection
2576	32830	th99	motherboardidredirection
2577	32831	th99	motherboardidredirection
2578	32832	th99	motherboardidredirection
2579	32833	th99	motherboardidredirection
2580	32834	th99	motherboardidredirection
2581	32835	th99	motherboardidredirection
2582	32836	th99	motherboardidredirection
2583	32837	th99	motherboardidredirection
2584	32838	th99	motherboardidredirection
2585	32839	th99	motherboardidredirection
2586	32840	th99	motherboardidredirection
2587	32841	th99	motherboardidredirection
2588	32842	th99	motherboardidredirection
2589	32843	th99	motherboardidredirection
2590	32844	th99	motherboardidredirection
2591	32845	th99	motherboardidredirection
2592	32846	th99	motherboardidredirection
2593	32847	th99	motherboardidredirection
2594	32848	th99	motherboardidredirection
2595	32849	th99	motherboardidredirection
2596	32850	th99	motherboardidredirection
2597	32851	th99	motherboardidredirection
2598	32852	th99	motherboardidredirection
2599	32853	th99	motherboardidredirection
2600	32854	th99	motherboardidredirection
2601	32855	th99	motherboardidredirection
2602	32856	th99	motherboardidredirection
2603	32857	th99	motherboardidredirection
2604	32858	th99	motherboardidredirection
2605	32859	th99	motherboardidredirection
2606	32860	th99	motherboardidredirection
2607	32862	th99	motherboardidredirection
2608	32863	th99	motherboardidredirection
2609	32865	th99	motherboardidredirection
2610	32866	th99	motherboardidredirection
2611	32867	th99	motherboardidredirection
2612	32868	th99	motherboardidredirection
2613	32869	th99	motherboardidredirection
2614	32870	th99	motherboardidredirection
2616	32872	th99	motherboardidredirection
2617	32873	th99	motherboardidredirection
2618	32874	th99	motherboardidredirection
2619	32875	th99	motherboardidredirection
2620	32876	th99	motherboardidredirection
2621	32878	th99	motherboardidredirection
2622	32879	th99	motherboardidredirection
2623	32880	th99	motherboardidredirection
2624	32881	th99	motherboardidredirection
2625	32882	th99	motherboardidredirection
2626	32883	th99	motherboardidredirection
2627	32884	th99	motherboardidredirection
2628	32885	th99	motherboardidredirection
2629	32886	th99	motherboardidredirection
2630	32887	th99	motherboardidredirection
2631	32888	th99	motherboardidredirection
2632	32889	th99	motherboardidredirection
2633	32890	th99	motherboardidredirection
2634	32891	th99	motherboardidredirection
2635	32892	th99	motherboardidredirection
2636	32893	th99	motherboardidredirection
2637	32894	th99	motherboardidredirection
2638	32895	th99	motherboardidredirection
2639	32896	th99	motherboardidredirection
2640	32897	th99	motherboardidredirection
2641	32898	th99	motherboardidredirection
2642	32899	th99	motherboardidredirection
2643	32900	th99	motherboardidredirection
2644	32901	th99	motherboardidredirection
2645	32902	th99	motherboardidredirection
2646	32903	th99	motherboardidredirection
2647	32904	th99	motherboardidredirection
2648	32905	th99	motherboardidredirection
2649	32906	th99	motherboardidredirection
2650	32907	th99	motherboardidredirection
2651	32908	th99	motherboardidredirection
2652	32909	th99	motherboardidredirection
2653	32911	th99	motherboardidredirection
2654	32912	th99	motherboardidredirection
2655	32913	th99	motherboardidredirection
2656	32914	th99	motherboardidredirection
2657	32915	th99	motherboardidredirection
2658	32917	th99	motherboardidredirection
2659	32918	th99	motherboardidredirection
2660	32919	th99	motherboardidredirection
2661	32920	th99	motherboardidredirection
2662	32921	th99	motherboardidredirection
2663	32922	th99	motherboardidredirection
2664	32923	th99	motherboardidredirection
2665	32924	th99	motherboardidredirection
2666	32925	th99	motherboardidredirection
2667	32927	th99	motherboardidredirection
2668	32928	th99	motherboardidredirection
2669	32929	th99	motherboardidredirection
2670	32930	th99	motherboardidredirection
2671	32931	th99	motherboardidredirection
2672	32932	th99	motherboardidredirection
2673	32933	th99	motherboardidredirection
2674	32934	th99	motherboardidredirection
2675	32935	th99	motherboardidredirection
2676	32936	th99	motherboardidredirection
2677	32937	th99	motherboardidredirection
2678	32938	th99	motherboardidredirection
2679	32939	th99	motherboardidredirection
2680	32940	th99	motherboardidredirection
2681	32941	th99	motherboardidredirection
2682	32942	th99	motherboardidredirection
2683	32943	th99	motherboardidredirection
2684	32944	th99	motherboardidredirection
2685	32945	th99	motherboardidredirection
2686	32946	th99	motherboardidredirection
2687	32947	th99	motherboardidredirection
2689	32949	th99	motherboardidredirection
2690	32950	th99	motherboardidredirection
2691	32951	th99	motherboardidredirection
2692	32952	th99	motherboardidredirection
2693	32953	th99	motherboardidredirection
2694	32954	th99	motherboardidredirection
2695	32955	th99	motherboardidredirection
2696	32956	th99	motherboardidredirection
2697	32957	th99	motherboardidredirection
2698	32958	th99	motherboardidredirection
2699	32959	th99	motherboardidredirection
2700	32960	th99	motherboardidredirection
2701	32961	th99	motherboardidredirection
2702	32962	th99	motherboardidredirection
2703	32963	th99	motherboardidredirection
2704	32964	th99	motherboardidredirection
2705	32965	th99	motherboardidredirection
2706	32966	th99	motherboardidredirection
2707	32968	th99	motherboardidredirection
2708	32969	th99	motherboardidredirection
2709	32970	th99	motherboardidredirection
2710	32971	th99	motherboardidredirection
2711	32972	th99	motherboardidredirection
2712	32973	th99	motherboardidredirection
2713	32974	th99	motherboardidredirection
2714	32975	th99	motherboardidredirection
2715	32976	th99	motherboardidredirection
2716	32979	th99	motherboardidredirection
2717	32980	th99	motherboardidredirection
2718	32981	th99	motherboardidredirection
2719	32982	th99	motherboardidredirection
2720	32983	th99	motherboardidredirection
2721	32984	th99	motherboardidredirection
2722	32985	th99	motherboardidredirection
2723	32986	th99	motherboardidredirection
2724	32987	th99	motherboardidredirection
2725	32988	th99	motherboardidredirection
2726	32990	th99	motherboardidredirection
2727	32992	th99	motherboardidredirection
2728	32993	th99	motherboardidredirection
2729	32994	th99	motherboardidredirection
2730	32995	th99	motherboardidredirection
2731	32996	th99	motherboardidredirection
2732	32997	th99	motherboardidredirection
2733	32998	th99	motherboardidredirection
2734	32999	th99	motherboardidredirection
2735	33000	th99	motherboardidredirection
2736	33001	th99	motherboardidredirection
2737	33002	th99	motherboardidredirection
2738	33003	th99	motherboardidredirection
2739	33006	th99	motherboardidredirection
2740	33007	th99	motherboardidredirection
2742	33011	th99	motherboardidredirection
2743	33012	th99	motherboardidredirection
2744	33014	th99	motherboardidredirection
2745	33015	th99	motherboardidredirection
2746	33016	th99	motherboardidredirection
2747	33017	th99	motherboardidredirection
2748	33019	th99	motherboardidredirection
2749	33020	th99	motherboardidredirection
2750	33021	th99	motherboardidredirection
2751	33022	th99	motherboardidredirection
2753	33024	th99	motherboardidredirection
2754	33025	th99	motherboardidredirection
2755	33026	th99	motherboardidredirection
2756	33027	th99	motherboardidredirection
2757	33028	th99	motherboardidredirection
2758	33029	th99	motherboardidredirection
2759	33030	th99	motherboardidredirection
2760	33031	th99	motherboardidredirection
2761	33032	th99	motherboardidredirection
2763	33034	th99	motherboardidredirection
2764	33035	th99	motherboardidredirection
2765	33038	th99	motherboardidredirection
2766	33039	th99	motherboardidredirection
2767	33041	th99	motherboardidredirection
2768	33042	th99	motherboardidredirection
2769	33043	th99	motherboardidredirection
2770	33044	th99	motherboardidredirection
2771	33045	th99	motherboardidredirection
2772	33046	th99	motherboardidredirection
2773	33047	th99	motherboardidredirection
2774	33048	th99	motherboardidredirection
2775	33049	th99	motherboardidredirection
2776	33050	th99	motherboardidredirection
2777	33059	th99	motherboardidredirection
2778	33060	th99	motherboardidredirection
2779	33061	th99	motherboardidredirection
2780	33062	th99	motherboardidredirection
2781	33063	th99	motherboardidredirection
2782	33065	th99	motherboardidredirection
2783	33066	th99	motherboardidredirection
2784	33067	th99	motherboardidredirection
2785	33068	th99	motherboardidredirection
2786	33069	th99	motherboardidredirection
2787	33070	th99	motherboardidredirection
2788	33071	th99	motherboardidredirection
2789	33072	th99	motherboardidredirection
2790	33073	th99	motherboardidredirection
2791	33074	th99	motherboardidredirection
2792	33075	th99	motherboardidredirection
2793	33076	th99	motherboardidredirection
2794	33077	th99	motherboardidredirection
2795	33078	th99	motherboardidredirection
2796	33079	th99	motherboardidredirection
2797	33080	th99	motherboardidredirection
2798	33081	th99	motherboardidredirection
2799	33082	th99	motherboardidredirection
2800	33083	th99	motherboardidredirection
2801	33084	th99	motherboardidredirection
2802	33085	th99	motherboardidredirection
2803	33086	th99	motherboardidredirection
2804	33087	th99	motherboardidredirection
2805	33088	th99	motherboardidredirection
2806	33089	th99	motherboardidredirection
2807	33090	th99	motherboardidredirection
2808	33091	th99	motherboardidredirection
2809	33092	th99	motherboardidredirection
2810	33093	th99	motherboardidredirection
2811	33094	th99	motherboardidredirection
2812	33096	th99	motherboardidredirection
2813	33097	th99	motherboardidredirection
2814	33098	th99	motherboardidredirection
2815	33099	th99	motherboardidredirection
2816	33100	th99	motherboardidredirection
2817	33101	th99	motherboardidredirection
2818	33102	th99	motherboardidredirection
2819	33103	th99	motherboardidredirection
2820	33104	th99	motherboardidredirection
2821	33105	th99	motherboardidredirection
2822	33106	th99	motherboardidredirection
2823	33109	th99	motherboardidredirection
2824	33110	th99	motherboardidredirection
2825	33111	th99	motherboardidredirection
2826	33112	th99	motherboardidredirection
2827	33113	th99	motherboardidredirection
2828	33114	th99	motherboardidredirection
2829	33115	th99	motherboardidredirection
2830	33116	th99	motherboardidredirection
2831	33118	th99	motherboardidredirection
2832	33119	th99	motherboardidredirection
2833	33120	th99	motherboardidredirection
2834	33122	th99	motherboardidredirection
2835	33123	th99	motherboardidredirection
2836	33125	th99	motherboardidredirection
2837	33127	th99	motherboardidredirection
2838	33128	th99	motherboardidredirection
2839	33129	th99	motherboardidredirection
2840	33130	th99	motherboardidredirection
2841	33131	th99	motherboardidredirection
2842	33132	th99	motherboardidredirection
2843	33133	th99	motherboardidredirection
2844	33134	th99	motherboardidredirection
2845	33135	th99	motherboardidredirection
2846	33136	th99	motherboardidredirection
2847	33137	th99	motherboardidredirection
2848	33138	th99	motherboardidredirection
2849	33139	th99	motherboardidredirection
2850	33140	th99	motherboardidredirection
2851	33141	th99	motherboardidredirection
2852	33142	th99	motherboardidredirection
2853	33143	th99	motherboardidredirection
2854	33144	th99	motherboardidredirection
2855	33145	th99	motherboardidredirection
2856	33146	th99	motherboardidredirection
2857	33147	th99	motherboardidredirection
2858	33148	th99	motherboardidredirection
2859	33149	th99	motherboardidredirection
2860	33150	th99	motherboardidredirection
2861	33151	th99	motherboardidredirection
2862	33152	th99	motherboardidredirection
2863	33153	th99	motherboardidredirection
2864	33154	th99	motherboardidredirection
2865	33155	th99	motherboardidredirection
2866	33156	th99	motherboardidredirection
2867	33157	th99	motherboardidredirection
2868	33158	th99	motherboardidredirection
2869	33160	th99	motherboardidredirection
2870	33161	th99	motherboardidredirection
2871	33162	th99	motherboardidredirection
2872	33163	th99	motherboardidredirection
2873	33164	th99	motherboardidredirection
2874	33165	th99	motherboardidredirection
2875	33166	th99	motherboardidredirection
2876	33167	th99	motherboardidredirection
2877	33168	th99	motherboardidredirection
2878	33169	th99	motherboardidredirection
2879	33170	th99	motherboardidredirection
2880	33171	th99	motherboardidredirection
2881	33172	th99	motherboardidredirection
2882	33173	th99	motherboardidredirection
2883	33174	th99	motherboardidredirection
2884	33175	th99	motherboardidredirection
2885	33176	th99	motherboardidredirection
2886	33177	th99	motherboardidredirection
2887	33178	th99	motherboardidredirection
2888	33179	th99	motherboardidredirection
2889	33180	th99	motherboardidredirection
2890	33181	th99	motherboardidredirection
2891	33182	th99	motherboardidredirection
2892	33183	th99	motherboardidredirection
2893	33184	th99	motherboardidredirection
2894	33185	th99	motherboardidredirection
2895	33186	th99	motherboardidredirection
2896	33187	th99	motherboardidredirection
2897	33188	th99	motherboardidredirection
2898	33189	th99	motherboardidredirection
2899	33190	th99	motherboardidredirection
2900	33191	th99	motherboardidredirection
2901	33192	th99	motherboardidredirection
2902	33193	th99	motherboardidredirection
2903	33194	th99	motherboardidredirection
2904	33195	th99	motherboardidredirection
2905	33196	th99	motherboardidredirection
2906	33197	th99	motherboardidredirection
2907	33198	th99	motherboardidredirection
2908	33199	th99	motherboardidredirection
2909	33200	th99	motherboardidredirection
2910	33201	th99	motherboardidredirection
2911	33202	th99	motherboardidredirection
2912	33203	th99	motherboardidredirection
2913	33204	th99	motherboardidredirection
2914	33205	th99	motherboardidredirection
2915	33206	th99	motherboardidredirection
2916	33207	th99	motherboardidredirection
2917	33208	th99	motherboardidredirection
2918	33209	th99	motherboardidredirection
2919	33210	th99	motherboardidredirection
2920	33211	th99	motherboardidredirection
2921	33212	th99	motherboardidredirection
2922	33213	th99	motherboardidredirection
2923	33214	th99	motherboardidredirection
2924	33215	th99	motherboardidredirection
2925	33217	th99	motherboardidredirection
2926	33219	th99	motherboardidredirection
2927	33221	th99	motherboardidredirection
2928	33222	th99	motherboardidredirection
2929	33226	th99	motherboardidredirection
2930	33227	th99	motherboardidredirection
2931	33231	th99	motherboardidredirection
2932	33232	th99	motherboardidredirection
2933	33233	th99	motherboardidredirection
2934	33234	th99	motherboardidredirection
2935	33235	th99	motherboardidredirection
2936	33236	th99	motherboardidredirection
2937	33237	th99	motherboardidredirection
2938	33238	th99	motherboardidredirection
2939	33239	th99	motherboardidredirection
2940	33240	th99	motherboardidredirection
2941	33241	th99	motherboardidredirection
2942	33242	th99	motherboardidredirection
2943	33243	th99	motherboardidredirection
2944	33244	th99	motherboardidredirection
2945	33245	th99	motherboardidredirection
2946	33246	th99	motherboardidredirection
2947	33247	th99	motherboardidredirection
2948	33248	th99	motherboardidredirection
2949	33249	th99	motherboardidredirection
2950	33250	th99	motherboardidredirection
2951	33251	th99	motherboardidredirection
2952	33252	th99	motherboardidredirection
2953	33253	th99	motherboardidredirection
2954	33254	th99	motherboardidredirection
2955	33255	th99	motherboardidredirection
2956	33256	th99	motherboardidredirection
2957	33257	th99	motherboardidredirection
2958	33258	th99	motherboardidredirection
2959	33260	th99	motherboardidredirection
2960	33261	th99	motherboardidredirection
2961	33262	th99	motherboardidredirection
2962	33263	th99	motherboardidredirection
2963	33264	th99	motherboardidredirection
2964	33265	th99	motherboardidredirection
2965	33266	th99	motherboardidredirection
2966	33267	th99	motherboardidredirection
2967	33269	th99	motherboardidredirection
2968	33271	th99	motherboardidredirection
2969	33272	th99	motherboardidredirection
2970	33274	th99	motherboardidredirection
2971	33275	th99	motherboardidredirection
2972	33276	th99	motherboardidredirection
2973	33277	th99	motherboardidredirection
2974	33278	th99	motherboardidredirection
2975	33279	th99	motherboardidredirection
2976	33280	th99	motherboardidredirection
2977	33281	th99	motherboardidredirection
2978	33282	th99	motherboardidredirection
2979	33283	th99	motherboardidredirection
2980	33284	th99	motherboardidredirection
2981	33285	th99	motherboardidredirection
2982	33286	th99	motherboardidredirection
2983	33287	th99	motherboardidredirection
2984	33288	th99	motherboardidredirection
2985	33289	th99	motherboardidredirection
2986	33290	th99	motherboardidredirection
2987	33291	th99	motherboardidredirection
2988	33292	th99	motherboardidredirection
2989	33294	th99	motherboardidredirection
2990	33295	th99	motherboardidredirection
2991	33296	th99	motherboardidredirection
2992	33297	th99	motherboardidredirection
2993	33298	th99	motherboardidredirection
2994	33299	th99	motherboardidredirection
2995	33300	th99	motherboardidredirection
2996	33301	th99	motherboardidredirection
2997	33302	th99	motherboardidredirection
2998	33303	th99	motherboardidredirection
2999	33304	th99	motherboardidredirection
3000	33305	th99	motherboardidredirection
3001	33307	th99	motherboardidredirection
3002	33308	th99	motherboardidredirection
3003	33309	th99	motherboardidredirection
3004	33310	th99	motherboardidredirection
3005	33311	th99	motherboardidredirection
3006	33312	th99	motherboardidredirection
3007	33313	th99	motherboardidredirection
3008	33314	th99	motherboardidredirection
3009	33315	th99	motherboardidredirection
3010	33316	th99	motherboardidredirection
3011	33317	th99	motherboardidredirection
3012	33318	th99	motherboardidredirection
3013	33319	th99	motherboardidredirection
3014	33321	th99	motherboardidredirection
3015	33322	th99	motherboardidredirection
3016	33323	th99	motherboardidredirection
3017	33324	th99	motherboardidredirection
3018	33325	th99	motherboardidredirection
3019	33326	th99	motherboardidredirection
3020	33327	th99	motherboardidredirection
3021	33328	th99	motherboardidredirection
3022	33329	th99	motherboardidredirection
3023	33330	th99	motherboardidredirection
3024	33331	th99	motherboardidredirection
3025	33332	th99	motherboardidredirection
3026	33333	th99	motherboardidredirection
3027	33334	th99	motherboardidredirection
3028	33335	th99	motherboardidredirection
3029	33337	th99	motherboardidredirection
3030	33338	th99	motherboardidredirection
3031	33339	th99	motherboardidredirection
3032	33340	th99	motherboardidredirection
3033	33341	th99	motherboardidredirection
3034	33343	th99	motherboardidredirection
3035	33344	th99	motherboardidredirection
3036	33345	th99	motherboardidredirection
3037	33346	th99	motherboardidredirection
3038	33347	th99	motherboardidredirection
3039	33349	th99	motherboardidredirection
3040	33350	th99	motherboardidredirection
3041	33351	th99	motherboardidredirection
3042	33354	th99	motherboardidredirection
3043	33355	th99	motherboardidredirection
3044	33356	th99	motherboardidredirection
3045	33357	th99	motherboardidredirection
3046	33358	th99	motherboardidredirection
3047	33359	th99	motherboardidredirection
3048	33360	th99	motherboardidredirection
3049	33361	th99	motherboardidredirection
3050	33362	th99	motherboardidredirection
3051	33364	th99	motherboardidredirection
3052	33365	th99	motherboardidredirection
3053	33366	th99	motherboardidredirection
3054	33368	th99	motherboardidredirection
3055	33369	th99	motherboardidredirection
3056	33370	th99	motherboardidredirection
3057	33371	th99	motherboardidredirection
3058	33372	th99	motherboardidredirection
3059	33373	th99	motherboardidredirection
3060	33374	th99	motherboardidredirection
3061	33375	th99	motherboardidredirection
3062	33376	th99	motherboardidredirection
3063	33377	th99	motherboardidredirection
3064	33378	th99	motherboardidredirection
3065	33379	th99	motherboardidredirection
3066	33381	th99	motherboardidredirection
3067	33382	th99	motherboardidredirection
3068	33384	th99	motherboardidredirection
3069	33385	th99	motherboardidredirection
3070	33386	th99	motherboardidredirection
3071	33387	th99	motherboardidredirection
3072	33388	th99	motherboardidredirection
3073	33389	th99	motherboardidredirection
3074	33390	th99	motherboardidredirection
3075	33391	th99	motherboardidredirection
3076	33392	th99	motherboardidredirection
3077	33393	th99	motherboardidredirection
3078	33394	th99	motherboardidredirection
3079	33395	th99	motherboardidredirection
3080	33396	th99	motherboardidredirection
3081	33397	th99	motherboardidredirection
3082	33398	th99	motherboardidredirection
3083	33399	th99	motherboardidredirection
3084	33401	th99	motherboardidredirection
3085	33402	th99	motherboardidredirection
3086	33404	th99	motherboardidredirection
3087	33405	th99	motherboardidredirection
3088	33406	th99	motherboardidredirection
3089	33407	th99	motherboardidredirection
3090	33408	th99	motherboardidredirection
3091	33409	th99	motherboardidredirection
3092	33410	th99	motherboardidredirection
3093	33411	th99	motherboardidredirection
3094	33412	th99	motherboardidredirection
3095	33413	th99	motherboardidredirection
3096	33415	th99	motherboardidredirection
3097	33416	th99	motherboardidredirection
3098	33417	th99	motherboardidredirection
3099	33418	th99	motherboardidredirection
3100	33419	th99	motherboardidredirection
3101	33420	th99	motherboardidredirection
3102	33421	th99	motherboardidredirection
3103	33422	th99	motherboardidredirection
3104	33423	th99	motherboardidredirection
3105	33424	th99	motherboardidredirection
3106	33425	th99	motherboardidredirection
3107	33426	th99	motherboardidredirection
3108	33427	th99	motherboardidredirection
3109	33428	th99	motherboardidredirection
3110	33429	th99	motherboardidredirection
3111	33430	th99	motherboardidredirection
3112	33431	th99	motherboardidredirection
3113	33432	th99	motherboardidredirection
3114	33434	th99	motherboardidredirection
3115	33436	th99	motherboardidredirection
3116	33437	th99	motherboardidredirection
3117	33439	th99	motherboardidredirection
3118	33440	th99	motherboardidredirection
3119	33441	th99	motherboardidredirection
3120	33442	th99	motherboardidredirection
3121	33443	th99	motherboardidredirection
3122	33444	th99	motherboardidredirection
3123	33445	th99	motherboardidredirection
3124	33446	th99	motherboardidredirection
3125	33447	th99	motherboardidredirection
3126	33449	th99	motherboardidredirection
3127	33450	th99	motherboardidredirection
3128	33452	th99	motherboardidredirection
3129	33454	th99	motherboardidredirection
3130	33456	th99	motherboardidredirection
3131	33457	th99	motherboardidredirection
3132	33458	th99	motherboardidredirection
3133	33460	th99	motherboardidredirection
3134	33461	th99	motherboardidredirection
3135	33462	th99	motherboardidredirection
3136	33463	th99	motherboardidredirection
3137	33464	th99	motherboardidredirection
3138	33465	th99	motherboardidredirection
3139	33466	th99	motherboardidredirection
3140	33467	th99	motherboardidredirection
3141	33468	th99	motherboardidredirection
3142	33469	th99	motherboardidredirection
3143	33470	th99	motherboardidredirection
3144	33471	th99	motherboardidredirection
3145	33472	th99	motherboardidredirection
3146	33473	th99	motherboardidredirection
3147	33475	th99	motherboardidredirection
3148	33476	th99	motherboardidredirection
3149	33477	th99	motherboardidredirection
3150	33478	th99	motherboardidredirection
3151	33479	th99	motherboardidredirection
3152	33480	th99	motherboardidredirection
3153	33481	th99	motherboardidredirection
3154	33482	th99	motherboardidredirection
3155	33483	th99	motherboardidredirection
3156	33484	th99	motherboardidredirection
3157	33485	th99	motherboardidredirection
3158	33486	th99	motherboardidredirection
3159	33487	th99	motherboardidredirection
3160	33488	th99	motherboardidredirection
3161	33489	th99	motherboardidredirection
3162	33490	th99	motherboardidredirection
3163	33492	th99	motherboardidredirection
3164	33493	th99	motherboardidredirection
3165	33494	th99	motherboardidredirection
3166	33495	th99	motherboardidredirection
3167	33496	th99	motherboardidredirection
3168	33497	th99	motherboardidredirection
3169	33498	th99	motherboardidredirection
3170	33499	th99	motherboardidredirection
3171	33500	th99	motherboardidredirection
3172	33502	th99	motherboardidredirection
3173	33503	th99	motherboardidredirection
3174	33504	th99	motherboardidredirection
3175	33505	th99	motherboardidredirection
3176	33506	th99	motherboardidredirection
3177	33507	th99	motherboardidredirection
3178	33508	th99	motherboardidredirection
3179	33509	th99	motherboardidredirection
3180	33510	th99	motherboardidredirection
3181	33511	th99	motherboardidredirection
3182	33512	th99	motherboardidredirection
3183	33513	th99	motherboardidredirection
3184	33514	th99	motherboardidredirection
3185	33515	th99	motherboardidredirection
3186	33516	th99	motherboardidredirection
3187	33517	th99	motherboardidredirection
3188	33518	th99	motherboardidredirection
3189	33519	th99	motherboardidredirection
3190	33520	th99	motherboardidredirection
3191	33521	th99	motherboardidredirection
3192	33522	th99	motherboardidredirection
3193	33523	th99	motherboardidredirection
3194	33528	th99	motherboardidredirection
3195	33529	th99	motherboardidredirection
3196	33531	th99	motherboardidredirection
3197	33532	th99	motherboardidredirection
3198	33533	th99	motherboardidredirection
3199	33534	th99	motherboardidredirection
3200	33535	th99	motherboardidredirection
3201	33538	th99	motherboardidredirection
3202	33539	th99	motherboardidredirection
3203	33540	th99	motherboardidredirection
3204	33542	th99	motherboardidredirection
3205	33543	th99	motherboardidredirection
3206	33544	th99	motherboardidredirection
3207	33545	th99	motherboardidredirection
3208	33546	th99	motherboardidredirection
3209	33547	th99	motherboardidredirection
3210	33548	th99	motherboardidredirection
3211	33549	th99	motherboardidredirection
3212	33550	th99	motherboardidredirection
3213	33553	th99	motherboardidredirection
3214	33554	th99	motherboardidredirection
3215	33555	th99	motherboardidredirection
3216	33556	th99	motherboardidredirection
3217	33557	th99	motherboardidredirection
3218	33558	th99	motherboardidredirection
3219	33559	th99	motherboardidredirection
3220	33560	th99	motherboardidredirection
3221	33561	th99	motherboardidredirection
3223	33563	th99	motherboardidredirection
3224	33564	th99	motherboardidredirection
3225	33567	th99	motherboardidredirection
3226	33568	th99	motherboardidredirection
3227	33571	th99	motherboardidredirection
3228	33572	th99	motherboardidredirection
3230	33577	th99	motherboardidredirection
3231	33578	th99	motherboardidredirection
3232	33579	th99	motherboardidredirection
3233	33580	th99	motherboardidredirection
3234	33581	th99	motherboardidredirection
3235	33583	th99	motherboardidredirection
3236	33584	th99	motherboardidredirection
3238	33586	th99	motherboardidredirection
3239	33587	th99	motherboardidredirection
3240	33589	th99	motherboardidredirection
3241	33590	th99	motherboardidredirection
3242	33592	th99	motherboardidredirection
3243	33593	th99	motherboardidredirection
3244	33594	th99	motherboardidredirection
3245	33595	th99	motherboardidredirection
3246	33596	th99	motherboardidredirection
3247	33597	th99	motherboardidredirection
3248	33598	th99	motherboardidredirection
3249	33599	th99	motherboardidredirection
3250	33600	th99	motherboardidredirection
3251	33601	th99	motherboardidredirection
3252	33602	th99	motherboardidredirection
3253	33603	th99	motherboardidredirection
3254	33604	th99	motherboardidredirection
3255	33605	th99	motherboardidredirection
3256	33606	th99	motherboardidredirection
3257	33607	th99	motherboardidredirection
3258	33608	th99	motherboardidredirection
3259	33609	th99	motherboardidredirection
3260	33610	th99	motherboardidredirection
3261	33611	th99	motherboardidredirection
3262	33612	th99	motherboardidredirection
3263	33613	th99	motherboardidredirection
3264	33614	th99	motherboardidredirection
3265	33617	th99	motherboardidredirection
3266	33618	th99	motherboardidredirection
3267	33619	th99	motherboardidredirection
3268	33620	th99	motherboardidredirection
3269	33621	th99	motherboardidredirection
3270	33622	th99	motherboardidredirection
3271	33623	th99	motherboardidredirection
3272	33625	th99	motherboardidredirection
3273	33626	th99	motherboardidredirection
3274	33627	th99	motherboardidredirection
3275	33628	th99	motherboardidredirection
3276	33629	th99	motherboardidredirection
3277	33630	th99	motherboardidredirection
3278	33631	th99	motherboardidredirection
3279	33632	th99	motherboardidredirection
3280	33633	th99	motherboardidredirection
3281	33634	th99	motherboardidredirection
3282	33636	th99	motherboardidredirection
3283	33637	th99	motherboardidredirection
3284	33638	th99	motherboardidredirection
3285	33639	th99	motherboardidredirection
3286	33640	th99	motherboardidredirection
3287	33641	th99	motherboardidredirection
3288	33642	th99	motherboardidredirection
3289	33643	th99	motherboardidredirection
3290	33644	th99	motherboardidredirection
3291	33645	th99	motherboardidredirection
3292	33646	th99	motherboardidredirection
3293	33647	th99	motherboardidredirection
3294	33648	th99	motherboardidredirection
3295	33649	th99	motherboardidredirection
3296	33650	th99	motherboardidredirection
3297	33651	th99	motherboardidredirection
3298	33652	th99	motherboardidredirection
3299	33655	th99	motherboardidredirection
3300	33658	th99	motherboardidredirection
3301	33659	th99	motherboardidredirection
3302	33660	th99	motherboardidredirection
3303	33661	th99	motherboardidredirection
3304	33662	th99	motherboardidredirection
3305	33663	th99	motherboardidredirection
3306	33664	th99	motherboardidredirection
3307	33665	th99	motherboardidredirection
3308	33666	th99	motherboardidredirection
3309	33668	th99	motherboardidredirection
3310	33669	th99	motherboardidredirection
3311	33670	th99	motherboardidredirection
3312	33671	th99	motherboardidredirection
3313	33672	th99	motherboardidredirection
3314	33673	th99	motherboardidredirection
3315	33674	th99	motherboardidredirection
3316	33675	th99	motherboardidredirection
3317	33676	th99	motherboardidredirection
3318	33677	th99	motherboardidredirection
3319	33679	th99	motherboardidredirection
3320	33680	th99	motherboardidredirection
3321	33681	th99	motherboardidredirection
3322	33683	th99	motherboardidredirection
3323	33684	th99	motherboardidredirection
3324	33685	th99	motherboardidredirection
3325	33686	th99	motherboardidredirection
3326	33687	th99	motherboardidredirection
3327	33688	th99	motherboardidredirection
3328	33689	th99	motherboardidredirection
3329	33690	th99	motherboardidredirection
3330	33691	th99	motherboardidredirection
3331	33692	th99	motherboardidredirection
3332	33693	th99	motherboardidredirection
3333	33694	th99	motherboardidredirection
3334	33695	th99	motherboardidredirection
3335	33696	th99	motherboardidredirection
3336	33697	th99	motherboardidredirection
3337	33698	th99	motherboardidredirection
3338	33699	th99	motherboardidredirection
3339	33700	th99	motherboardidredirection
3340	33701	th99	motherboardidredirection
3341	33702	th99	motherboardidredirection
3342	33704	th99	motherboardidredirection
3343	33705	th99	motherboardidredirection
3344	33706	th99	motherboardidredirection
3345	33708	th99	motherboardidredirection
3346	33709	th99	motherboardidredirection
3347	33710	th99	motherboardidredirection
3348	33711	th99	motherboardidredirection
3349	33712	th99	motherboardidredirection
3350	33713	th99	motherboardidredirection
3351	33714	th99	motherboardidredirection
3352	33715	th99	motherboardidredirection
3353	33716	th99	motherboardidredirection
3355	33717	th99	motherboardidredirection
3356	33718	th99	motherboardidredirection
3357	33719	th99	motherboardidredirection
3358	33720	th99	motherboardidredirection
3359	33721	th99	motherboardidredirection
3360	33722	th99	motherboardidredirection
3361	33723	th99	motherboardidredirection
3362	33724	th99	motherboardidredirection
3363	33725	th99	motherboardidredirection
3364	33726	th99	motherboardidredirection
3365	33727	th99	motherboardidredirection
3366	33728	th99	motherboardidredirection
3367	33729	th99	motherboardidredirection
3368	33730	th99	motherboardidredirection
3369	33732	th99	motherboardidredirection
3370	33733	th99	motherboardidredirection
3371	33734	th99	motherboardidredirection
3372	33735	th99	motherboardidredirection
3373	33736	th99	motherboardidredirection
3374	33737	th99	motherboardidredirection
3375	33738	th99	motherboardidredirection
3376	33739	th99	motherboardidredirection
3377	33740	th99	motherboardidredirection
3378	33741	th99	motherboardidredirection
3379	33742	th99	motherboardidredirection
3380	33743	th99	motherboardidredirection
3381	33745	th99	motherboardidredirection
3382	33746	th99	motherboardidredirection
3383	33747	th99	motherboardidredirection
3384	33748	th99	motherboardidredirection
3385	33749	th99	motherboardidredirection
3386	33750	th99	motherboardidredirection
3387	33752	th99	motherboardidredirection
3388	33753	th99	motherboardidredirection
3389	33755	th99	motherboardidredirection
3390	33757	th99	motherboardidredirection
3391	33758	th99	motherboardidredirection
3392	33759	th99	motherboardidredirection
3393	33760	th99	motherboardidredirection
3394	33761	th99	motherboardidredirection
3395	33762	th99	motherboardidredirection
3396	33763	th99	motherboardidredirection
3397	33764	th99	motherboardidredirection
3398	33765	th99	motherboardidredirection
3399	33766	th99	motherboardidredirection
3400	33767	th99	motherboardidredirection
3401	33768	th99	motherboardidredirection
3402	33769	th99	motherboardidredirection
3403	33770	th99	motherboardidredirection
3404	33771	th99	motherboardidredirection
3405	33772	th99	motherboardidredirection
3406	33773	th99	motherboardidredirection
3407	33774	th99	motherboardidredirection
3408	33775	th99	motherboardidredirection
3409	33776	th99	motherboardidredirection
3410	33777	th99	motherboardidredirection
3411	33779	th99	motherboardidredirection
3412	33781	th99	motherboardidredirection
3413	33783	th99	motherboardidredirection
3414	33784	th99	motherboardidredirection
3415	33785	th99	motherboardidredirection
3416	33786	th99	motherboardidredirection
3417	33787	th99	motherboardidredirection
3418	33788	th99	motherboardidredirection
3419	33789	th99	motherboardidredirection
3420	33790	th99	motherboardidredirection
3421	33791	th99	motherboardidredirection
3422	33792	th99	motherboardidredirection
3423	33793	th99	motherboardidredirection
3424	33794	th99	motherboardidredirection
3425	33795	th99	motherboardidredirection
3426	33796	th99	motherboardidredirection
3427	33797	th99	motherboardidredirection
3428	33798	th99	motherboardidredirection
3429	33799	th99	motherboardidredirection
3430	33800	th99	motherboardidredirection
3431	33801	th99	motherboardidredirection
3432	33802	th99	motherboardidredirection
3433	33803	th99	motherboardidredirection
3434	33804	th99	motherboardidredirection
3435	33805	th99	motherboardidredirection
3436	33808	th99	motherboardidredirection
3437	33809	th99	motherboardidredirection
3438	33810	th99	motherboardidredirection
3439	33811	th99	motherboardidredirection
3440	33812	th99	motherboardidredirection
3441	33813	th99	motherboardidredirection
3442	33816	th99	motherboardidredirection
3443	33817	th99	motherboardidredirection
3444	33818	th99	motherboardidredirection
3445	33819	th99	motherboardidredirection
3446	33820	th99	motherboardidredirection
3447	33821	th99	motherboardidredirection
3448	33823	th99	motherboardidredirection
3449	33824	th99	motherboardidredirection
3450	33825	th99	motherboardidredirection
3451	33826	th99	motherboardidredirection
3452	33827	th99	motherboardidredirection
3453	33828	th99	motherboardidredirection
3454	33829	th99	motherboardidredirection
3455	33830	th99	motherboardidredirection
3456	33831	th99	motherboardidredirection
3457	33832	th99	motherboardidredirection
3458	33833	th99	motherboardidredirection
3459	33834	th99	motherboardidredirection
3460	33835	th99	motherboardidredirection
3461	33836	th99	motherboardidredirection
3462	33837	th99	motherboardidredirection
3463	33838	th99	motherboardidredirection
3464	33839	th99	motherboardidredirection
3465	33840	th99	motherboardidredirection
3466	33841	th99	motherboardidredirection
3467	33842	th99	motherboardidredirection
3468	33843	th99	motherboardidredirection
3469	33844	th99	motherboardidredirection
3470	33845	th99	motherboardidredirection
3471	33846	th99	motherboardidredirection
3472	33847	th99	motherboardidredirection
3473	33848	th99	motherboardidredirection
3474	33849	th99	motherboardidredirection
3475	33850	th99	motherboardidredirection
3476	33851	th99	motherboardidredirection
3477	33852	th99	motherboardidredirection
3478	33854	th99	motherboardidredirection
3479	33855	th99	motherboardidredirection
3480	33856	th99	motherboardidredirection
3481	33857	th99	motherboardidredirection
3482	33858	th99	motherboardidredirection
3483	33859	th99	motherboardidredirection
3484	33860	th99	motherboardidredirection
3485	33861	th99	motherboardidredirection
3486	33862	th99	motherboardidredirection
3487	33863	th99	motherboardidredirection
3488	33864	th99	motherboardidredirection
3489	33865	th99	motherboardidredirection
3490	33866	th99	motherboardidredirection
3491	33867	th99	motherboardidredirection
3492	33868	th99	motherboardidredirection
3493	33869	th99	motherboardidredirection
3494	33870	th99	motherboardidredirection
3495	33871	th99	motherboardidredirection
3496	33872	th99	motherboardidredirection
3497	33873	th99	motherboardidredirection
3498	33876	th99	motherboardidredirection
3499	33877	th99	motherboardidredirection
3500	33879	th99	motherboardidredirection
3501	33880	th99	motherboardidredirection
3502	33882	th99	motherboardidredirection
3503	33884	th99	motherboardidredirection
3504	33885	th99	motherboardidredirection
3505	33886	th99	motherboardidredirection
3506	33887	th99	motherboardidredirection
3507	33888	th99	motherboardidredirection
3508	33889	th99	motherboardidredirection
3509	33891	th99	motherboardidredirection
3510	33892	th99	motherboardidredirection
3511	33893	th99	motherboardidredirection
3512	33894	th99	motherboardidredirection
3513	33895	th99	motherboardidredirection
3514	33896	th99	motherboardidredirection
3515	33897	th99	motherboardidredirection
3516	33898	th99	motherboardidredirection
3517	33899	th99	motherboardidredirection
3518	33900	th99	motherboardidredirection
3519	33901	th99	motherboardidredirection
3520	33902	th99	motherboardidredirection
3521	33903	th99	motherboardidredirection
3522	33904	th99	motherboardidredirection
3523	33905	th99	motherboardidredirection
3524	33907	th99	motherboardidredirection
3525	33909	th99	motherboardidredirection
3526	33912	th99	motherboardidredirection
3527	33913	th99	motherboardidredirection
3528	33914	th99	motherboardidredirection
3529	33915	th99	motherboardidredirection
3530	33916	th99	motherboardidredirection
3531	33917	th99	motherboardidredirection
3532	33918	th99	motherboardidredirection
3533	33919	th99	motherboardidredirection
3534	33920	th99	motherboardidredirection
3535	33923	th99	motherboardidredirection
3536	33924	th99	motherboardidredirection
3537	33925	th99	motherboardidredirection
3538	33926	th99	motherboardidredirection
3539	33927	th99	motherboardidredirection
3540	33928	th99	motherboardidredirection
3541	33930	th99	motherboardidredirection
3542	33931	th99	motherboardidredirection
3543	33932	th99	motherboardidredirection
3544	33933	th99	motherboardidredirection
3545	33934	th99	motherboardidredirection
3546	33935	th99	motherboardidredirection
3547	33936	th99	motherboardidredirection
3548	33937	th99	motherboardidredirection
3549	33938	th99	motherboardidredirection
3550	33939	th99	motherboardidredirection
3551	33940	th99	motherboardidredirection
3552	33941	th99	motherboardidredirection
3553	33942	th99	motherboardidredirection
3554	33943	th99	motherboardidredirection
3555	33944	th99	motherboardidredirection
3556	33945	th99	motherboardidredirection
3557	33946	th99	motherboardidredirection
3558	33947	th99	motherboardidredirection
3559	33948	th99	motherboardidredirection
3560	33949	th99	motherboardidredirection
3561	33950	th99	motherboardidredirection
3562	33951	th99	motherboardidredirection
3563	33953	th99	motherboardidredirection
3564	33954	th99	motherboardidredirection
3565	33955	th99	motherboardidredirection
3566	33956	th99	motherboardidredirection
3567	33957	th99	motherboardidredirection
3568	33958	th99	motherboardidredirection
3569	33959	th99	motherboardidredirection
3570	33960	th99	motherboardidredirection
3571	33961	th99	motherboardidredirection
3572	33962	th99	motherboardidredirection
3573	33963	th99	motherboardidredirection
3574	33965	th99	motherboardidredirection
3575	33966	th99	motherboardidredirection
3576	33967	th99	motherboardidredirection
3577	33968	th99	motherboardidredirection
3578	33969	th99	motherboardidredirection
3579	33973	th99	motherboardidredirection
3580	33974	th99	motherboardidredirection
3581	33975	th99	motherboardidredirection
3582	33976	th99	motherboardidredirection
3583	33977	th99	motherboardidredirection
3584	33978	th99	motherboardidredirection
3585	33979	th99	motherboardidredirection
3586	33980	th99	motherboardidredirection
3587	33981	th99	motherboardidredirection
3588	33982	th99	motherboardidredirection
3589	33983	th99	motherboardidredirection
3590	33984	th99	motherboardidredirection
3591	33985	th99	motherboardidredirection
3592	33986	th99	motherboardidredirection
3593	33987	th99	motherboardidredirection
3594	33988	th99	motherboardidredirection
3595	33989	th99	motherboardidredirection
3596	33990	th99	motherboardidredirection
3597	33991	th99	motherboardidredirection
3598	33992	th99	motherboardidredirection
3599	33994	th99	motherboardidredirection
3600	33995	th99	motherboardidredirection
3601	33996	th99	motherboardidredirection
3602	33997	th99	motherboardidredirection
3603	33999	th99	motherboardidredirection
3604	34000	th99	motherboardidredirection
3605	34001	th99	motherboardidredirection
3606	34002	th99	motherboardidredirection
3607	34003	th99	motherboardidredirection
3608	34004	th99	motherboardidredirection
3609	34005	th99	motherboardidredirection
3610	34007	th99	motherboardidredirection
3611	34008	th99	motherboardidredirection
3612	34010	th99	motherboardidredirection
3613	34011	th99	motherboardidredirection
3614	34012	th99	motherboardidredirection
3615	34013	th99	motherboardidredirection
3616	34014	th99	motherboardidredirection
3617	34015	th99	motherboardidredirection
3618	34016	th99	motherboardidredirection
3619	34017	th99	motherboardidredirection
3620	34018	th99	motherboardidredirection
3621	34019	th99	motherboardidredirection
3622	34020	th99	motherboardidredirection
3623	34021	th99	motherboardidredirection
3624	34022	th99	motherboardidredirection
3625	34024	th99	motherboardidredirection
3626	34025	th99	motherboardidredirection
3627	34026	th99	motherboardidredirection
3628	34027	th99	motherboardidredirection
3629	34028	th99	motherboardidredirection
3630	34029	th99	motherboardidredirection
3631	34030	th99	motherboardidredirection
3632	34031	th99	motherboardidredirection
3633	34032	th99	motherboardidredirection
3634	34033	th99	motherboardidredirection
3635	34034	th99	motherboardidredirection
3636	34038	th99	motherboardidredirection
3637	34039	th99	motherboardidredirection
3638	34040	th99	motherboardidredirection
3639	34041	th99	motherboardidredirection
3640	34042	th99	motherboardidredirection
3641	34043	th99	motherboardidredirection
3642	34047	th99	motherboardidredirection
3643	34048	th99	motherboardidredirection
3644	34049	th99	motherboardidredirection
3645	34050	th99	motherboardidredirection
3646	34052	th99	motherboardidredirection
3647	34054	th99	motherboardidredirection
3648	34055	th99	motherboardidredirection
3649	34058	th99	motherboardidredirection
3650	34059	th99	motherboardidredirection
3651	34060	th99	motherboardidredirection
3652	34061	th99	motherboardidredirection
3653	34062	th99	motherboardidredirection
3654	34063	th99	motherboardidredirection
3655	34064	th99	motherboardidredirection
3656	34065	th99	motherboardidredirection
3657	34066	th99	motherboardidredirection
3658	34067	th99	motherboardidredirection
3659	34068	th99	motherboardidredirection
3660	34069	th99	motherboardidredirection
3661	34070	th99	motherboardidredirection
3662	34071	th99	motherboardidredirection
3663	34072	th99	motherboardidredirection
3664	34073	th99	motherboardidredirection
3665	34074	th99	motherboardidredirection
3666	34075	th99	motherboardidredirection
3667	34076	th99	motherboardidredirection
3668	34077	th99	motherboardidredirection
3669	34078	th99	motherboardidredirection
3670	34079	th99	motherboardidredirection
3671	34080	th99	motherboardidredirection
3672	34081	th99	motherboardidredirection
3673	34082	th99	motherboardidredirection
3674	34083	th99	motherboardidredirection
3675	34084	th99	motherboardidredirection
3676	34085	th99	motherboardidredirection
3677	34087	th99	motherboardidredirection
3678	34088	th99	motherboardidredirection
3679	34089	th99	motherboardidredirection
3680	34090	th99	motherboardidredirection
3681	34091	th99	motherboardidredirection
3682	34092	th99	motherboardidredirection
3683	34093	th99	motherboardidredirection
3685	34095	th99	motherboardidredirection
3686	34096	th99	motherboardidredirection
3687	34097	th99	motherboardidredirection
3688	34098	th99	motherboardidredirection
3689	34099	th99	motherboardidredirection
3690	34100	th99	motherboardidredirection
3691	34102	th99	motherboardidredirection
3692	34103	th99	motherboardidredirection
3693	34104	th99	motherboardidredirection
3694	34105	th99	motherboardidredirection
3695	34106	th99	motherboardidredirection
3696	34107	th99	motherboardidredirection
3697	34108	th99	motherboardidredirection
3698	34109	th99	motherboardidredirection
3699	34110	th99	motherboardidredirection
3700	34111	th99	motherboardidredirection
3702	34113	th99	motherboardidredirection
3703	34114	th99	motherboardidredirection
3704	34115	th99	motherboardidredirection
3705	34116	th99	motherboardidredirection
3706	34117	th99	motherboardidredirection
3707	34118	th99	motherboardidredirection
3708	34121	th99	motherboardidredirection
3709	34122	th99	motherboardidredirection
3710	34123	th99	motherboardidredirection
3711	34124	th99	motherboardidredirection
3712	34125	th99	motherboardidredirection
3713	34126	th99	motherboardidredirection
3714	34127	th99	motherboardidredirection
3715	34128	th99	motherboardidredirection
3716	34129	th99	motherboardidredirection
3717	34130	th99	motherboardidredirection
3718	34132	th99	motherboardidredirection
3719	34133	th99	motherboardidredirection
3720	34134	th99	motherboardidredirection
3721	34135	th99	motherboardidredirection
3722	34136	th99	motherboardidredirection
3723	34137	th99	motherboardidredirection
3724	34138	th99	motherboardidredirection
3725	34139	th99	motherboardidredirection
3727	34141	th99	motherboardidredirection
3728	34142	th99	motherboardidredirection
3729	34143	th99	motherboardidredirection
3730	34144	th99	motherboardidredirection
3731	34145	th99	motherboardidredirection
3732	34146	th99	motherboardidredirection
3733	34147	th99	motherboardidredirection
3734	34148	th99	motherboardidredirection
3735	34149	th99	motherboardidredirection
3736	34150	th99	motherboardidredirection
3737	34151	th99	motherboardidredirection
3738	34152	th99	motherboardidredirection
3739	34153	th99	motherboardidredirection
3740	34154	th99	motherboardidredirection
3741	34155	th99	motherboardidredirection
3742	34156	th99	motherboardidredirection
3743	34157	th99	motherboardidredirection
3744	34158	th99	motherboardidredirection
3745	34159	th99	motherboardidredirection
3746	34160	th99	motherboardidredirection
3747	34161	th99	motherboardidredirection
3748	34162	th99	motherboardidredirection
3749	34163	th99	motherboardidredirection
3750	34164	th99	motherboardidredirection
3751	34165	th99	motherboardidredirection
3752	34166	th99	motherboardidredirection
3753	34167	th99	motherboardidredirection
3754	34168	th99	motherboardidredirection
3755	34169	th99	motherboardidredirection
3756	34170	th99	motherboardidredirection
3757	34171	th99	motherboardidredirection
3758	34172	th99	motherboardidredirection
3759	34173	th99	motherboardidredirection
3760	34174	th99	motherboardidredirection
3761	34175	th99	motherboardidredirection
3762	34177	th99	motherboardidredirection
3763	34178	th99	motherboardidredirection
3764	34179	th99	motherboardidredirection
3765	34180	th99	motherboardidredirection
3766	34181	th99	motherboardidredirection
3767	34182	th99	motherboardidredirection
3768	34183	th99	motherboardidredirection
3769	34184	th99	motherboardidredirection
3770	34185	th99	motherboardidredirection
3771	34186	th99	motherboardidredirection
3772	34187	th99	motherboardidredirection
3773	34188	th99	motherboardidredirection
3774	34189	th99	motherboardidredirection
3775	34190	th99	motherboardidredirection
3776	34191	th99	motherboardidredirection
3777	34192	th99	motherboardidredirection
3778	34193	th99	motherboardidredirection
3779	34194	th99	motherboardidredirection
3780	34195	th99	motherboardidredirection
3781	34196	th99	motherboardidredirection
3782	34197	th99	motherboardidredirection
3783	34198	th99	motherboardidredirection
3784	34199	th99	motherboardidredirection
3785	34200	th99	motherboardidredirection
3787	34202	th99	motherboardidredirection
3788	34203	th99	motherboardidredirection
3789	34204	th99	motherboardidredirection
3790	34205	th99	motherboardidredirection
3791	34206	th99	motherboardidredirection
3792	34207	th99	motherboardidredirection
3793	34208	th99	motherboardidredirection
3794	34209	th99	motherboardidredirection
3795	34210	th99	motherboardidredirection
3796	34211	th99	motherboardidredirection
3797	34212	th99	motherboardidredirection
3798	34213	th99	motherboardidredirection
3799	34214	th99	motherboardidredirection
3800	34215	th99	motherboardidredirection
3801	34216	th99	motherboardidredirection
3802	34217	th99	motherboardidredirection
3803	34219	th99	motherboardidredirection
3804	34220	th99	motherboardidredirection
3805	34221	th99	motherboardidredirection
3806	34222	th99	motherboardidredirection
3807	34223	th99	motherboardidredirection
3808	34224	th99	motherboardidredirection
3809	34225	th99	motherboardidredirection
3810	34226	th99	motherboardidredirection
3811	34227	th99	motherboardidredirection
3812	34228	th99	motherboardidredirection
3813	34229	th99	motherboardidredirection
3814	34230	th99	motherboardidredirection
3815	34231	th99	motherboardidredirection
3816	34236	th99	motherboardidredirection
3817	34237	th99	motherboardidredirection
3818	34238	th99	motherboardidredirection
3819	34239	th99	motherboardidredirection
3820	34241	th99	motherboardidredirection
3821	34242	th99	motherboardidredirection
3822	34243	th99	motherboardidredirection
3823	34244	th99	motherboardidredirection
3824	34245	th99	motherboardidredirection
3825	34246	th99	motherboardidredirection
3826	34247	th99	motherboardidredirection
3827	34248	th99	motherboardidredirection
3828	34249	th99	motherboardidredirection
3829	34251	th99	motherboardidredirection
3830	34252	th99	motherboardidredirection
3831	34253	th99	motherboardidredirection
3832	34254	th99	motherboardidredirection
3833	34255	th99	motherboardidredirection
3834	34256	th99	motherboardidredirection
3835	34257	th99	motherboardidredirection
3836	34258	th99	motherboardidredirection
3837	34260	th99	motherboardidredirection
3838	34261	th99	motherboardidredirection
3839	34262	th99	motherboardidredirection
3840	34263	th99	motherboardidredirection
3841	34264	th99	motherboardidredirection
3842	34265	th99	motherboardidredirection
3843	34266	th99	motherboardidredirection
3844	34267	th99	motherboardidredirection
3845	34268	th99	motherboardidredirection
3846	34270	th99	motherboardidredirection
3847	34271	th99	motherboardidredirection
3848	34272	th99	motherboardidredirection
3849	34273	th99	motherboardidredirection
3850	34274	th99	motherboardidredirection
3851	34275	th99	motherboardidredirection
3852	34276	th99	motherboardidredirection
3853	34277	th99	motherboardidredirection
3854	34279	th99	motherboardidredirection
3855	34280	th99	motherboardidredirection
3856	34281	th99	motherboardidredirection
3857	34282	th99	motherboardidredirection
3858	34283	th99	motherboardidredirection
3859	34284	th99	motherboardidredirection
3860	34285	th99	motherboardidredirection
3861	34286	th99	motherboardidredirection
3862	34287	th99	motherboardidredirection
3863	34289	th99	motherboardidredirection
3864	34290	th99	motherboardidredirection
3865	34291	th99	motherboardidredirection
3866	34292	th99	motherboardidredirection
3867	34293	th99	motherboardidredirection
3868	34294	th99	motherboardidredirection
3869	34295	th99	motherboardidredirection
3870	34296	th99	motherboardidredirection
3871	34297	th99	motherboardidredirection
3872	34299	th99	motherboardidredirection
3873	34301	th99	motherboardidredirection
3874	34302	th99	motherboardidredirection
3875	34303	th99	motherboardidredirection
3876	34304	th99	motherboardidredirection
3877	34306	th99	motherboardidredirection
3878	34307	th99	motherboardidredirection
3879	34308	th99	motherboardidredirection
3880	34309	th99	motherboardidredirection
3881	34310	th99	motherboardidredirection
3882	34311	th99	motherboardidredirection
3883	34312	th99	motherboardidredirection
3884	34313	th99	motherboardidredirection
3885	34314	th99	motherboardidredirection
3886	34315	th99	motherboardidredirection
3887	34317	th99	motherboardidredirection
3888	34318	th99	motherboardidredirection
3889	34319	th99	motherboardidredirection
3890	34320	th99	motherboardidredirection
3891	34321	th99	motherboardidredirection
3892	34322	th99	motherboardidredirection
3893	34323	th99	motherboardidredirection
3894	34324	th99	motherboardidredirection
3895	34325	th99	motherboardidredirection
3896	34326	th99	motherboardidredirection
3897	34327	th99	motherboardidredirection
3898	34328	th99	motherboardidredirection
3899	34329	th99	motherboardidredirection
3900	34330	th99	motherboardidredirection
3901	34331	th99	motherboardidredirection
3902	34332	th99	motherboardidredirection
3903	34333	th99	motherboardidredirection
3905	34337	th99	motherboardidredirection
3906	34339	th99	motherboardidredirection
3907	34341	th99	motherboardidredirection
3908	34342	th99	motherboardidredirection
3909	34343	th99	motherboardidredirection
3910	34345	th99	motherboardidredirection
3911	34347	th99	motherboardidredirection
3912	34349	th99	motherboardidredirection
3913	34351	th99	motherboardidredirection
3914	34352	th99	motherboardidredirection
3915	34353	th99	motherboardidredirection
3916	34354	th99	motherboardidredirection
3917	34355	th99	motherboardidredirection
3918	34356	th99	motherboardidredirection
3919	34357	th99	motherboardidredirection
3920	34358	th99	motherboardidredirection
3921	34359	th99	motherboardidredirection
3922	34360	th99	motherboardidredirection
3923	34361	th99	motherboardidredirection
3924	34362	th99	motherboardidredirection
3925	34363	th99	motherboardidredirection
3926	34365	th99	motherboardidredirection
3927	34366	th99	motherboardidredirection
3928	34368	th99	motherboardidredirection
3929	34369	th99	motherboardidredirection
3930	34370	th99	motherboardidredirection
3931	34371	th99	motherboardidredirection
3932	34372	th99	motherboardidredirection
3933	34373	th99	motherboardidredirection
3934	34374	th99	motherboardidredirection
3935	34375	th99	motherboardidredirection
3936	34376	th99	motherboardidredirection
3937	34377	th99	motherboardidredirection
3938	34378	th99	motherboardidredirection
3939	34379	th99	motherboardidredirection
3940	34380	th99	motherboardidredirection
3941	34381	th99	motherboardidredirection
3942	34382	th99	motherboardidredirection
3943	34383	th99	motherboardidredirection
3944	34384	th99	motherboardidredirection
3945	34385	th99	motherboardidredirection
3946	34387	th99	motherboardidredirection
3947	34388	th99	motherboardidredirection
3948	34389	th99	motherboardidredirection
3949	34390	th99	motherboardidredirection
3950	34391	th99	motherboardidredirection
3951	34392	th99	motherboardidredirection
3952	34393	th99	motherboardidredirection
3953	34394	th99	motherboardidredirection
3954	34395	th99	motherboardidredirection
3955	34396	th99	motherboardidredirection
3956	34397	th99	motherboardidredirection
3957	34398	th99	motherboardidredirection
3958	34399	th99	motherboardidredirection
3959	34400	th99	motherboardidredirection
3960	34401	th99	motherboardidredirection
3961	34402	th99	motherboardidredirection
3962	34403	th99	motherboardidredirection
3963	34404	th99	motherboardidredirection
3964	34405	th99	motherboardidredirection
3965	34406	th99	motherboardidredirection
3966	34407	th99	motherboardidredirection
3967	34408	th99	motherboardidredirection
3968	34409	th99	motherboardidredirection
3969	34410	th99	motherboardidredirection
3970	34411	th99	motherboardidredirection
3971	34412	th99	motherboardidredirection
3972	34413	th99	motherboardidredirection
3973	34414	th99	motherboardidredirection
3974	34415	th99	motherboardidredirection
3975	34416	th99	motherboardidredirection
3976	34417	th99	motherboardidredirection
3977	34418	th99	motherboardidredirection
3978	34419	th99	motherboardidredirection
3979	34420	th99	motherboardidredirection
3980	34421	th99	motherboardidredirection
3981	34422	th99	motherboardidredirection
3982	34423	th99	motherboardidredirection
3983	34425	th99	motherboardidredirection
3984	34426	th99	motherboardidredirection
3986	34428	th99	motherboardidredirection
3987	34429	th99	motherboardidredirection
3988	34430	th99	motherboardidredirection
3989	34431	th99	motherboardidredirection
3990	34432	th99	motherboardidredirection
3991	34433	th99	motherboardidredirection
3992	34434	th99	motherboardidredirection
3993	34435	th99	motherboardidredirection
3994	34436	th99	motherboardidredirection
3995	34437	th99	motherboardidredirection
3996	34438	th99	motherboardidredirection
3997	34439	th99	motherboardidredirection
3998	34440	th99	motherboardidredirection
3999	34441	th99	motherboardidredirection
4000	34442	th99	motherboardidredirection
4001	34443	th99	motherboardidredirection
4002	34444	th99	motherboardidredirection
4003	34445	th99	motherboardidredirection
4004	34446	th99	motherboardidredirection
4005	34447	th99	motherboardidredirection
4006	34448	th99	motherboardidredirection
4007	34449	th99	motherboardidredirection
4008	34450	th99	motherboardidredirection
4009	34451	th99	motherboardidredirection
4010	34452	th99	motherboardidredirection
4011	34453	th99	motherboardidredirection
4012	34454	th99	motherboardidredirection
4013	34455	th99	motherboardidredirection
4015	34457	th99	motherboardidredirection
4016	34458	th99	motherboardidredirection
4018	34460	th99	motherboardidredirection
4019	34461	th99	motherboardidredirection
4020	34462	th99	motherboardidredirection
4021	34463	th99	motherboardidredirection
4022	34464	th99	motherboardidredirection
4023	34465	th99	motherboardidredirection
4024	34466	th99	motherboardidredirection
4025	34467	th99	motherboardidredirection
4026	34468	th99	motherboardidredirection
4027	34469	th99	motherboardidredirection
4028	34470	th99	motherboardidredirection
4029	34471	th99	motherboardidredirection
4030	34472	th99	motherboardidredirection
4031	34473	th99	motherboardidredirection
4032	34474	th99	motherboardidredirection
4033	34475	th99	motherboardidredirection
4034	34476	th99	motherboardidredirection
4035	34477	th99	motherboardidredirection
4036	34478	th99	motherboardidredirection
4037	34479	th99	motherboardidredirection
4038	34480	th99	motherboardidredirection
4039	34481	th99	motherboardidredirection
4040	34482	th99	motherboardidredirection
4041	34483	th99	motherboardidredirection
4042	34484	th99	motherboardidredirection
4043	34485	th99	motherboardidredirection
4044	34487	th99	motherboardidredirection
4045	34488	th99	motherboardidredirection
4046	34489	th99	motherboardidredirection
4047	34490	th99	motherboardidredirection
4048	34491	th99	motherboardidredirection
4049	34492	th99	motherboardidredirection
4050	34494	th99	motherboardidredirection
4051	34495	th99	motherboardidredirection
4052	34498	th99	motherboardidredirection
4053	34499	th99	motherboardidredirection
4054	34500	th99	motherboardidredirection
4055	34501	th99	motherboardidredirection
4056	34502	th99	motherboardidredirection
4057	34503	th99	motherboardidredirection
4058	34504	th99	motherboardidredirection
4059	34505	th99	motherboardidredirection
4060	34506	th99	motherboardidredirection
4061	34507	th99	motherboardidredirection
4062	34508	th99	motherboardidredirection
4063	34510	th99	motherboardidredirection
4064	34511	th99	motherboardidredirection
4065	34512	th99	motherboardidredirection
4066	34513	th99	motherboardidredirection
4067	34514	th99	motherboardidredirection
4068	34515	th99	motherboardidredirection
4069	34516	th99	motherboardidredirection
4070	34517	th99	motherboardidredirection
4071	34518	th99	motherboardidredirection
4072	34519	th99	motherboardidredirection
4073	34520	th99	motherboardidredirection
4074	34521	th99	motherboardidredirection
4075	34522	th99	motherboardidredirection
4076	34523	th99	motherboardidredirection
4077	34524	th99	motherboardidredirection
4078	34525	th99	motherboardidredirection
4079	34526	th99	motherboardidredirection
4080	34527	th99	motherboardidredirection
4081	34528	th99	motherboardidredirection
4082	34529	th99	motherboardidredirection
4083	34530	th99	motherboardidredirection
4084	34531	th99	motherboardidredirection
4085	34532	th99	motherboardidredirection
4086	34533	th99	motherboardidredirection
4087	34534	th99	motherboardidredirection
4088	34536	th99	motherboardidredirection
4089	34537	th99	motherboardidredirection
4090	34538	th99	motherboardidredirection
4091	34539	th99	motherboardidredirection
4092	34540	th99	motherboardidredirection
4093	34541	th99	motherboardidredirection
4094	34542	th99	motherboardidredirection
4095	34543	th99	motherboardidredirection
4096	34544	th99	motherboardidredirection
4097	34545	th99	motherboardidredirection
4098	34546	th99	motherboardidredirection
4099	34547	th99	motherboardidredirection
4100	34548	th99	motherboardidredirection
4101	34549	th99	motherboardidredirection
4102	34550	th99	motherboardidredirection
4103	34551	th99	motherboardidredirection
4104	34552	th99	motherboardidredirection
4105	34553	th99	motherboardidredirection
4106	34554	th99	motherboardidredirection
4107	34555	th99	motherboardidredirection
4108	34556	th99	motherboardidredirection
4109	34557	th99	motherboardidredirection
4110	34558	th99	motherboardidredirection
4111	34559	th99	motherboardidredirection
4112	34560	th99	motherboardidredirection
4113	34561	th99	motherboardidredirection
4114	34562	th99	motherboardidredirection
4115	34563	th99	motherboardidredirection
4116	34564	th99	motherboardidredirection
4117	34565	th99	motherboardidredirection
4118	34566	th99	motherboardidredirection
4119	34567	th99	motherboardidredirection
4120	34568	th99	motherboardidredirection
4121	34569	th99	motherboardidredirection
4122	34570	th99	motherboardidredirection
4123	34571	th99	motherboardidredirection
4124	34572	th99	motherboardidredirection
4125	34573	th99	motherboardidredirection
4126	34574	th99	motherboardidredirection
4127	34575	th99	motherboardidredirection
4128	34576	th99	motherboardidredirection
4129	34577	th99	motherboardidredirection
4130	34578	th99	motherboardidredirection
4131	34579	th99	motherboardidredirection
4132	34580	th99	motherboardidredirection
4133	34581	th99	motherboardidredirection
4134	34582	th99	motherboardidredirection
4135	34583	th99	motherboardidredirection
4136	34584	th99	motherboardidredirection
4137	34588	th99	motherboardidredirection
4138	34589	th99	motherboardidredirection
4139	34590	th99	motherboardidredirection
4140	34591	th99	motherboardidredirection
4141	34592	th99	motherboardidredirection
4142	34593	th99	motherboardidredirection
4143	34594	th99	motherboardidredirection
4144	34595	th99	motherboardidredirection
4145	34596	th99	motherboardidredirection
4146	34597	th99	motherboardidredirection
4147	34598	th99	motherboardidredirection
4148	34599	th99	motherboardidredirection
4149	34600	th99	motherboardidredirection
4150	34601	th99	motherboardidredirection
4151	34602	th99	motherboardidredirection
4152	34603	th99	motherboardidredirection
4153	34604	th99	motherboardidredirection
4154	34605	th99	motherboardidredirection
4155	34606	th99	motherboardidredirection
4156	34607	th99	motherboardidredirection
4157	34608	th99	motherboardidredirection
4158	34609	th99	motherboardidredirection
4159	34610	th99	motherboardidredirection
4160	34611	th99	motherboardidredirection
4161	34612	th99	motherboardidredirection
4162	34613	th99	motherboardidredirection
4163	34614	th99	motherboardidredirection
4164	34615	th99	motherboardidredirection
4165	34616	th99	motherboardidredirection
4166	34617	th99	motherboardidredirection
4167	34618	th99	motherboardidredirection
4168	34619	th99	motherboardidredirection
4169	34620	th99	motherboardidredirection
4170	34621	th99	motherboardidredirection
4171	34622	th99	motherboardidredirection
4172	34623	th99	motherboardidredirection
4173	34624	th99	motherboardidredirection
4174	34625	th99	motherboardidredirection
4175	34626	th99	motherboardidredirection
4176	34627	th99	motherboardidredirection
4177	34628	th99	motherboardidredirection
4178	34629	th99	motherboardidredirection
4179	34630	th99	motherboardidredirection
4180	34631	th99	motherboardidredirection
4181	34632	th99	motherboardidredirection
4182	34633	th99	motherboardidredirection
4183	34634	th99	motherboardidredirection
4184	34635	th99	motherboardidredirection
4185	34636	th99	motherboardidredirection
4186	34637	th99	motherboardidredirection
4187	34638	th99	motherboardidredirection
4188	34639	th99	motherboardidredirection
4189	34640	th99	motherboardidredirection
4190	34641	th99	motherboardidredirection
4191	34642	th99	motherboardidredirection
4192	34643	th99	motherboardidredirection
4193	34644	th99	motherboardidredirection
4194	34645	th99	motherboardidredirection
4195	34646	th99	motherboardidredirection
4196	34647	th99	motherboardidredirection
4197	34648	th99	motherboardidredirection
4198	34649	th99	motherboardidredirection
4199	34650	th99	motherboardidredirection
4200	34651	th99	motherboardidredirection
4201	34652	th99	motherboardidredirection
4202	34653	th99	motherboardidredirection
4203	34654	th99	motherboardidredirection
4204	34655	th99	motherboardidredirection
4205	34656	th99	motherboardidredirection
4206	34657	th99	motherboardidredirection
4207	34658	th99	motherboardidredirection
4208	34659	th99	motherboardidredirection
4209	34660	th99	motherboardidredirection
4210	34661	th99	motherboardidredirection
4211	34662	th99	motherboardidredirection
4212	34663	th99	motherboardidredirection
4213	34668	th99	motherboardidredirection
4214	34669	th99	motherboardidredirection
4215	34670	th99	motherboardidredirection
4216	34671	th99	motherboardidredirection
4217	34672	th99	motherboardidredirection
4218	34673	th99	motherboardidredirection
4219	34674	th99	motherboardidredirection
4220	34675	th99	motherboardidredirection
4221	34676	th99	motherboardidredirection
4222	34677	th99	motherboardidredirection
4223	34678	th99	motherboardidredirection
4224	34679	th99	motherboardidredirection
4225	34680	th99	motherboardidredirection
4226	34681	th99	motherboardidredirection
4227	34682	th99	motherboardidredirection
4228	34683	th99	motherboardidredirection
4229	34684	th99	motherboardidredirection
4230	34685	th99	motherboardidredirection
4231	34686	th99	motherboardidredirection
4232	34687	th99	motherboardidredirection
4233	34688	th99	motherboardidredirection
4234	34689	th99	motherboardidredirection
4235	34690	th99	motherboardidredirection
4236	34691	th99	motherboardidredirection
4237	34692	th99	motherboardidredirection
4238	34693	th99	motherboardidredirection
4239	34694	th99	motherboardidredirection
4240	34695	th99	motherboardidredirection
4241	34696	th99	motherboardidredirection
4242	34697	th99	motherboardidredirection
4243	34698	th99	motherboardidredirection
4244	34699	th99	motherboardidredirection
4245	34700	th99	motherboardidredirection
4246	34701	th99	motherboardidredirection
4247	34702	th99	motherboardidredirection
4248	34703	th99	motherboardidredirection
4249	34704	th99	motherboardidredirection
4250	34705	th99	motherboardidredirection
4251	34706	th99	motherboardidredirection
4252	34710	th99	motherboardidredirection
4253	34713	th99	motherboardidredirection
4254	34714	th99	motherboardidredirection
4255	34715	th99	motherboardidredirection
4256	34716	th99	motherboardidredirection
4257	34717	th99	motherboardidredirection
4258	34718	th99	motherboardidredirection
4259	34719	th99	motherboardidredirection
4260	34720	th99	motherboardidredirection
4261	34733	th99	motherboardidredirection
4262	34751	th99	motherboardidredirection
4263	34752	th99	motherboardidredirection
4264	34753	th99	motherboardidredirection
4265	34754	th99	motherboardidredirection
4266	34755	th99	motherboardidredirection
4267	34756	th99	motherboardidredirection
4268	34757	th99	motherboardidredirection
4269	34758	th99	motherboardidredirection
4270	34759	th99	motherboardidredirection
4271	34760	th99	motherboardidredirection
4272	34761	th99	motherboardidredirection
4273	34762	th99	motherboardidredirection
4274	34763	th99	motherboardidredirection
4275	34764	th99	motherboardidredirection
4276	34765	th99	motherboardidredirection
4277	34766	th99	motherboardidredirection
4278	34767	th99	motherboardidredirection
4279	34768	th99	motherboardidredirection
4280	34769	th99	motherboardidredirection
4281	34770	th99	motherboardidredirection
4282	34771	th99	motherboardidredirection
4283	34772	th99	motherboardidredirection
4284	34773	th99	motherboardidredirection
4285	34774	th99	motherboardidredirection
4286	34775	th99	motherboardidredirection
4287	34776	th99	motherboardidredirection
4288	34777	th99	motherboardidredirection
4289	34779	th99	motherboardidredirection
4290	34780	th99	motherboardidredirection
4291	34781	th99	motherboardidredirection
4292	34782	th99	motherboardidredirection
4293	34783	th99	motherboardidredirection
4294	34784	th99	motherboardidredirection
4295	34785	th99	motherboardidredirection
4296	34786	th99	motherboardidredirection
4298	34788	th99	motherboardidredirection
4299	34789	th99	motherboardidredirection
4300	34790	th99	motherboardidredirection
4301	34791	th99	motherboardidredirection
4302	34793	th99	motherboardidredirection
4303	34794	th99	motherboardidredirection
4304	34795	th99	motherboardidredirection
4305	34796	th99	motherboardidredirection
4306	34797	th99	motherboardidredirection
4309	34800	th99	motherboardidredirection
4310	34801	th99	motherboardidredirection
4311	34802	th99	motherboardidredirection
4312	34803	th99	motherboardidredirection
4313	34804	th99	motherboardidredirection
4314	34805	th99	motherboardidredirection
4315	34806	th99	motherboardidredirection
4316	34807	th99	motherboardidredirection
4317	34808	th99	motherboardidredirection
4318	34809	th99	motherboardidredirection
4319	34810	th99	motherboardidredirection
4320	34811	th99	motherboardidredirection
4321	34812	th99	motherboardidredirection
4322	34813	th99	motherboardidredirection
4323	34814	th99	motherboardidredirection
4324	34815	th99	motherboardidredirection
4325	34816	th99	motherboardidredirection
4326	34817	th99	motherboardidredirection
4327	34818	th99	motherboardidredirection
4328	34819	th99	motherboardidredirection
4329	34820	th99	motherboardidredirection
4330	34821	th99	motherboardidredirection
4331	34822	th99	motherboardidredirection
4332	34823	th99	motherboardidredirection
4333	34824	th99	motherboardidredirection
4334	34825	th99	motherboardidredirection
4335	34826	th99	motherboardidredirection
4336	34827	th99	motherboardidredirection
4337	34828	th99	motherboardidredirection
4338	34829	th99	motherboardidredirection
4339	34830	th99	motherboardidredirection
4340	34831	th99	motherboardidredirection
4341	34832	th99	motherboardidredirection
4342	34833	th99	motherboardidredirection
4343	34834	th99	motherboardidredirection
4344	34835	th99	motherboardidredirection
4345	34836	th99	motherboardidredirection
4346	34838	th99	motherboardidredirection
4347	34839	th99	motherboardidredirection
4348	34840	th99	motherboardidredirection
4350	34842	th99	motherboardidredirection
4351	34843	th99	motherboardidredirection
4352	34844	th99	motherboardidredirection
4353	34845	th99	motherboardidredirection
4354	34846	th99	motherboardidredirection
4355	34847	th99	motherboardidredirection
4356	34848	th99	motherboardidredirection
4357	34849	th99	motherboardidredirection
4358	34850	th99	motherboardidredirection
4361	34853	th99	motherboardidredirection
4362	34854	th99	motherboardidredirection
4363	34855	th99	motherboardidredirection
4364	34856	th99	motherboardidredirection
4365	34857	th99	motherboardidredirection
4366	34858	th99	motherboardidredirection
4367	34859	th99	motherboardidredirection
4368	34860	th99	motherboardidredirection
4369	34861	th99	motherboardidredirection
4370	34862	th99	motherboardidredirection
4371	34863	th99	motherboardidredirection
4372	34864	th99	motherboardidredirection
4373	34865	th99	motherboardidredirection
4374	34866	th99	motherboardidredirection
4375	34867	th99	motherboardidredirection
4376	34868	th99	motherboardidredirection
4377	34869	th99	motherboardidredirection
4378	34870	th99	motherboardidredirection
4379	34871	th99	motherboardidredirection
4380	34872	th99	motherboardidredirection
4381	34873	th99	motherboardidredirection
4382	34874	th99	motherboardidredirection
4383	34875	th99	motherboardidredirection
4384	34876	th99	motherboardidredirection
4385	34877	th99	motherboardidredirection
4386	34878	th99	motherboardidredirection
4387	34879	th99	motherboardidredirection
4388	34880	th99	motherboardidredirection
4389	34881	th99	motherboardidredirection
4390	34882	th99	motherboardidredirection
4391	34887	th99	motherboardidredirection
4393	34889	th99	motherboardidredirection
4394	34890	th99	motherboardidredirection
4395	34891	th99	motherboardidredirection
4396	34892	th99	motherboardidredirection
4397	34893	th99	motherboardidredirection
4398	34894	th99	motherboardidredirection
4399	34895	th99	motherboardidredirection
4400	34896	th99	motherboardidredirection
4401	34897	th99	motherboardidredirection
4402	34898	th99	motherboardidredirection
4403	34899	th99	motherboardidredirection
4404	34900	th99	motherboardidredirection
4405	34901	th99	motherboardidredirection
4406	34902	th99	motherboardidredirection
4407	34903	th99	motherboardidredirection
4408	34904	th99	motherboardidredirection
4409	34905	th99	motherboardidredirection
4410	34907	th99	motherboardidredirection
4411	34908	th99	motherboardidredirection
4412	34909	th99	motherboardidredirection
4413	34910	th99	motherboardidredirection
4414	34911	th99	motherboardidredirection
4415	34912	th99	motherboardidredirection
4416	34913	th99	motherboardidredirection
4417	34914	th99	motherboardidredirection
4418	34915	th99	motherboardidredirection
4419	34916	th99	motherboardidredirection
4420	34917	th99	motherboardidredirection
4421	34918	th99	motherboardidredirection
4422	34919	th99	motherboardidredirection
4423	34920	th99	motherboardidredirection
4424	34921	th99	motherboardidredirection
4425	34922	th99	motherboardidredirection
4426	34923	th99	motherboardidredirection
4427	34924	th99	motherboardidredirection
4428	34925	th99	motherboardidredirection
4429	34926	th99	motherboardidredirection
4430	34927	th99	motherboardidredirection
4431	34928	th99	motherboardidredirection
4432	34929	th99	motherboardidredirection
4433	34930	th99	motherboardidredirection
4434	34931	th99	motherboardidredirection
4435	34932	th99	motherboardidredirection
4436	34933	th99	motherboardidredirection
4437	34934	th99	motherboardidredirection
4438	34935	th99	motherboardidredirection
4439	34936	th99	motherboardidredirection
4440	34937	th99	motherboardidredirection
4441	34938	th99	motherboardidredirection
4442	34939	th99	motherboardidredirection
4443	34940	th99	motherboardidredirection
4444	34941	th99	motherboardidredirection
4445	34942	th99	motherboardidredirection
4446	34943	th99	motherboardidredirection
4447	34944	th99	motherboardidredirection
4448	34945	th99	motherboardidredirection
4449	34946	th99	motherboardidredirection
4450	34947	th99	motherboardidredirection
4451	34948	th99	motherboardidredirection
4452	34949	th99	motherboardidredirection
4453	34950	th99	motherboardidredirection
4454	34951	th99	motherboardidredirection
4455	34952	th99	motherboardidredirection
4456	34953	th99	motherboardidredirection
4457	34954	th99	motherboardidredirection
4458	34955	th99	motherboardidredirection
4459	34956	th99	motherboardidredirection
4460	34957	th99	motherboardidredirection
4461	34958	th99	motherboardidredirection
4462	34959	th99	motherboardidredirection
4463	34960	th99	motherboardidredirection
4464	34966	th99	motherboardidredirection
4466	34968	th99	motherboardidredirection
4467	34971	th99	motherboardidredirection
4468	34972	th99	motherboardidredirection
4469	34973	th99	motherboardidredirection
4470	34974	th99	motherboardidredirection
4471	34975	th99	motherboardidredirection
4472	34976	th99	motherboardidredirection
4473	34977	th99	motherboardidredirection
4474	34981	th99	motherboardidredirection
4475	34982	th99	motherboardidredirection
4476	34987	th99	motherboardidredirection
4477	34988	th99	motherboardidredirection
4478	34989	th99	motherboardidredirection
4479	34990	th99	motherboardidredirection
4480	35051	th99	motherboardidredirection
4481	35052	th99	motherboardidredirection
4482	35053	th99	motherboardidredirection
4483	35055	th99	motherboardidredirection
4484	35056	th99	motherboardidredirection
4485	35057	th99	motherboardidredirection
4486	35058	th99	motherboardidredirection
4487	35059	th99	motherboardidredirection
4488	35060	th99	motherboardidredirection
4489	35061	th99	motherboardidredirection
4490	35063	th99	motherboardidredirection
4491	35064	th99	motherboardidredirection
4492	35066	th99	motherboardidredirection
4493	35067	th99	motherboardidredirection
4494	35068	th99	motherboardidredirection
4495	35069	th99	motherboardidredirection
4496	35070	th99	motherboardidredirection
4497	35071	th99	motherboardidredirection
4498	35072	th99	motherboardidredirection
4499	35073	th99	motherboardidredirection
4500	35074	th99	motherboardidredirection
4501	35075	th99	motherboardidredirection
4502	35076	th99	motherboardidredirection
4503	35079	th99	motherboardidredirection
4504	35080	th99	motherboardidredirection
4505	35082	th99	motherboardidredirection
4506	35084	th99	motherboardidredirection
4507	35085	th99	motherboardidredirection
4508	35086	th99	motherboardidredirection
4509	35087	th99	motherboardidredirection
4510	35088	th99	motherboardidredirection
4511	35089	th99	motherboardidredirection
4512	35090	th99	motherboardidredirection
4513	35091	th99	motherboardidredirection
4514	35092	th99	motherboardidredirection
4515	35093	th99	motherboardidredirection
4516	35094	th99	motherboardidredirection
4517	35095	th99	motherboardidredirection
4518	35097	th99	motherboardidredirection
4519	35099	th99	motherboardidredirection
4520	35100	th99	motherboardidredirection
4521	35102	th99	motherboardidredirection
4522	35103	th99	motherboardidredirection
4523	35104	th99	motherboardidredirection
4524	35105	th99	motherboardidredirection
4525	35106	th99	motherboardidredirection
4526	35108	th99	motherboardidredirection
4527	35111	th99	motherboardidredirection
4528	35112	th99	motherboardidredirection
4529	35113	th99	motherboardidredirection
4530	35121	th99	motherboardidredirection
4531	35122	th99	motherboardidredirection
4532	35123	th99	motherboardidredirection
4533	35124	th99	motherboardidredirection
4535	35127	th99	motherboardidredirection
4536	35128	th99	motherboardidredirection
4537	35129	th99	motherboardidredirection
4538	35156	th99	motherboardidredirection
4539	35159	th99	motherboardidredirection
4540	35160	th99	motherboardidredirection
4541	35164	th99	motherboardidredirection
4542	35165	th99	motherboardidredirection
4543	35166	th99	motherboardidredirection
4544	35167	th99	motherboardidredirection
4545	35168	th99	motherboardidredirection
4546	35169	th99	motherboardidredirection
4547	35170	th99	motherboardidredirection
4548	35171	th99	motherboardidredirection
4549	35172	th99	motherboardidredirection
4550	35173	th99	motherboardidredirection
4551	35174	th99	motherboardidredirection
4552	35175	th99	motherboardidredirection
4553	35176	th99	motherboardidredirection
4554	35177	th99	motherboardidredirection
4555	35178	th99	motherboardidredirection
4556	35179	th99	motherboardidredirection
4557	35180	th99	motherboardidredirection
4558	35181	th99	motherboardidredirection
4559	35182	th99	motherboardidredirection
4560	35183	th99	motherboardidredirection
4534	4187	uh19	motherboardidredirection
4561	35185	th99	motherboardidredirection
4562	35186	th99	motherboardidredirection
4563	35187	th99	motherboardidredirection
4564	35188	th99	motherboardidredirection
4565	35189	th99	motherboardidredirection
4566	35190	th99	motherboardidredirection
4567	35191	th99	motherboardidredirection
4568	35192	th99	motherboardidredirection
4569	35193	th99	motherboardidredirection
4570	35194	th99	motherboardidredirection
4571	35195	th99	motherboardidredirection
4572	35196	th99	motherboardidredirection
4573	35197	th99	motherboardidredirection
4574	35198	th99	motherboardidredirection
4575	35199	th99	motherboardidredirection
4576	35200	th99	motherboardidredirection
4577	35201	th99	motherboardidredirection
4578	35202	th99	motherboardidredirection
4579	35203	th99	motherboardidredirection
4580	35204	th99	motherboardidredirection
4581	35205	th99	motherboardidredirection
4582	35206	th99	motherboardidredirection
4583	35207	th99	motherboardidredirection
4584	35208	th99	motherboardidredirection
4585	35209	th99	motherboardidredirection
4586	35210	th99	motherboardidredirection
4587	35211	th99	motherboardidredirection
4588	35212	th99	motherboardidredirection
4589	35213	th99	motherboardidredirection
4590	35214	th99	motherboardidredirection
4591	35215	th99	motherboardidredirection
4592	35216	th99	motherboardidredirection
4593	35217	th99	motherboardidredirection
4594	35218	th99	motherboardidredirection
4595	35219	th99	motherboardidredirection
4596	35220	th99	motherboardidredirection
4597	35221	th99	motherboardidredirection
4598	35222	th99	motherboardidredirection
4599	35223	th99	motherboardidredirection
4600	35224	th99	motherboardidredirection
4601	35225	th99	motherboardidredirection
4602	35226	th99	motherboardidredirection
4603	35227	th99	motherboardidredirection
4604	35228	th99	motherboardidredirection
4605	35229	th99	motherboardidredirection
4606	35230	th99	motherboardidredirection
4607	35231	th99	motherboardidredirection
4608	35232	th99	motherboardidredirection
4609	35233	th99	motherboardidredirection
4610	35234	th99	motherboardidredirection
4611	35235	th99	motherboardidredirection
4612	35236	th99	motherboardidredirection
4613	35237	th99	motherboardidredirection
4614	35238	th99	motherboardidredirection
4615	35239	th99	motherboardidredirection
4616	35240	th99	motherboardidredirection
4617	35242	th99	motherboardidredirection
4618	35243	th99	motherboardidredirection
4619	35244	th99	motherboardidredirection
4620	35245	th99	motherboardidredirection
4621	35246	th99	motherboardidredirection
4622	35247	th99	motherboardidredirection
4623	35248	th99	motherboardidredirection
4624	35249	th99	motherboardidredirection
4625	35250	th99	motherboardidredirection
4626	35251	th99	motherboardidredirection
4627	35252	th99	motherboardidredirection
4628	35253	th99	motherboardidredirection
4629	35254	th99	motherboardidredirection
4630	35255	th99	motherboardidredirection
4631	35256	th99	motherboardidredirection
4632	35257	th99	motherboardidredirection
4633	35258	th99	motherboardidredirection
4634	35259	th99	motherboardidredirection
4635	35260	th99	motherboardidredirection
4636	35261	th99	motherboardidredirection
4637	35263	th99	motherboardidredirection
4638	35264	th99	motherboardidredirection
4639	35265	th99	motherboardidredirection
4640	35266	th99	motherboardidredirection
4641	35267	th99	motherboardidredirection
4642	35268	th99	motherboardidredirection
4643	35277	th99	motherboardidredirection
4644	35284	th99	motherboardidredirection
4645	35285	th99	motherboardidredirection
4646	35286	th99	motherboardidredirection
4647	35290	th99	motherboardidredirection
4648	35301	th99	motherboardidredirection
4649	35305	th99	motherboardidredirection
4650	35328	th99	motherboardidredirection
4651	35329	th99	motherboardidredirection
4652	35330	th99	motherboardidredirection
4653	35331	th99	motherboardidredirection
4654	35332	th99	motherboardidredirection
4655	35333	th99	motherboardidredirection
4656	35334	th99	motherboardidredirection
4657	35335	th99	motherboardidredirection
4659	35337	th99	motherboardidredirection
4660	35338	th99	motherboardidredirection
4661	35339	th99	motherboardidredirection
4662	35340	th99	motherboardidredirection
4663	35341	th99	motherboardidredirection
4664	35342	th99	motherboardidredirection
4665	35344	th99	motherboardidredirection
4666	35345	th99	motherboardidredirection
4667	35346	th99	motherboardidredirection
4668	35347	th99	motherboardidredirection
4669	35349	th99	motherboardidredirection
4670	35350	th99	motherboardidredirection
4671	35351	th99	motherboardidredirection
4672	35352	th99	motherboardidredirection
4673	35353	th99	motherboardidredirection
4674	35354	th99	motherboardidredirection
4675	35355	th99	motherboardidredirection
4676	35356	th99	motherboardidredirection
4677	35357	th99	motherboardidredirection
4678	35358	th99	motherboardidredirection
4679	35359	th99	motherboardidredirection
4680	35360	th99	motherboardidredirection
4681	35361	th99	motherboardidredirection
4682	35362	th99	motherboardidredirection
4683	35363	th99	motherboardidredirection
4684	35364	th99	motherboardidredirection
4685	35365	th99	motherboardidredirection
4686	35366	th99	motherboardidredirection
4687	35367	th99	motherboardidredirection
4688	35368	th99	motherboardidredirection
4689	35369	th99	motherboardidredirection
4690	35370	th99	motherboardidredirection
4691	35371	th99	motherboardidredirection
4692	35372	th99	motherboardidredirection
4693	35374	th99	motherboardidredirection
4694	35375	th99	motherboardidredirection
4695	35376	th99	motherboardidredirection
4696	35377	th99	motherboardidredirection
4697	35378	th99	motherboardidredirection
4698	35379	th99	motherboardidredirection
4699	35380	th99	motherboardidredirection
4700	35381	th99	motherboardidredirection
4701	35382	th99	motherboardidredirection
4702	35383	th99	motherboardidredirection
4703	35385	th99	motherboardidredirection
4704	35386	th99	motherboardidredirection
4705	35387	th99	motherboardidredirection
4706	35388	th99	motherboardidredirection
4707	35389	th99	motherboardidredirection
4708	35390	th99	motherboardidredirection
4709	35391	th99	motherboardidredirection
4710	35392	th99	motherboardidredirection
4711	35393	th99	motherboardidredirection
4712	35394	th99	motherboardidredirection
4713	35396	th99	motherboardidredirection
4714	35397	th99	motherboardidredirection
4715	35398	th99	motherboardidredirection
4716	35399	th99	motherboardidredirection
4717	35400	th99	motherboardidredirection
4718	35401	th99	motherboardidredirection
4719	35402	th99	motherboardidredirection
4720	35403	th99	motherboardidredirection
4721	35404	th99	motherboardidredirection
4722	35405	th99	motherboardidredirection
4723	35406	th99	motherboardidredirection
4724	35407	th99	motherboardidredirection
4725	35408	th99	motherboardidredirection
4726	35409	th99	motherboardidredirection
4727	35410	th99	motherboardidredirection
4728	35411	th99	motherboardidredirection
4729	35412	th99	motherboardidredirection
4730	35413	th99	motherboardidredirection
4731	35414	th99	motherboardidredirection
4732	35415	th99	motherboardidredirection
4733	35416	th99	motherboardidredirection
4734	35417	th99	motherboardidredirection
4735	35418	th99	motherboardidredirection
4736	35419	th99	motherboardidredirection
4737	35420	th99	motherboardidredirection
4738	35421	th99	motherboardidredirection
4739	35422	th99	motherboardidredirection
4740	35423	th99	motherboardidredirection
4741	35424	th99	motherboardidredirection
4742	35425	th99	motherboardidredirection
4743	35426	th99	motherboardidredirection
4744	35427	th99	motherboardidredirection
4745	35428	th99	motherboardidredirection
4746	35429	th99	motherboardidredirection
4747	35430	th99	motherboardidredirection
4748	35431	th99	motherboardidredirection
4749	35432	th99	motherboardidredirection
4750	35434	th99	motherboardidredirection
4751	35435	th99	motherboardidredirection
4752	35436	th99	motherboardidredirection
4753	35437	th99	motherboardidredirection
4754	35438	th99	motherboardidredirection
4755	35439	th99	motherboardidredirection
4756	35440	th99	motherboardidredirection
4757	35441	th99	motherboardidredirection
4758	35442	th99	motherboardidredirection
4759	35443	th99	motherboardidredirection
4760	35444	th99	motherboardidredirection
4761	35445	th99	motherboardidredirection
4762	35446	th99	motherboardidredirection
4763	35447	th99	motherboardidredirection
4764	35448	th99	motherboardidredirection
4765	35449	th99	motherboardidredirection
4766	35450	th99	motherboardidredirection
4767	35451	th99	motherboardidredirection
4768	35452	th99	motherboardidredirection
4769	35453	th99	motherboardidredirection
4770	35454	th99	motherboardidredirection
4771	35455	th99	motherboardidredirection
4772	35456	th99	motherboardidredirection
4773	35458	th99	motherboardidredirection
4774	35459	th99	motherboardidredirection
4775	35460	th99	motherboardidredirection
4776	35461	th99	motherboardidredirection
4777	35462	th99	motherboardidredirection
4778	35463	th99	motherboardidredirection
4779	35464	th99	motherboardidredirection
4780	35465	th99	motherboardidredirection
4781	35466	th99	motherboardidredirection
4782	35467	th99	motherboardidredirection
4783	35468	th99	motherboardidredirection
4784	35469	th99	motherboardidredirection
4785	35470	th99	motherboardidredirection
4786	35531	th99	motherboardidredirection
4787	35532	th99	motherboardidredirection
4788	35533	th99	motherboardidredirection
4789	35534	th99	motherboardidredirection
4790	35535	th99	motherboardidredirection
4791	35536	th99	motherboardidredirection
4792	35537	th99	motherboardidredirection
4793	35538	th99	motherboardidredirection
4794	35539	th99	motherboardidredirection
4795	35540	th99	motherboardidredirection
4796	35541	th99	motherboardidredirection
4798	3050	uh19	motherboardidredirection
4799	33585	th99	motherboardidredirection
4801	7984	uh19	motherboardidredirection
4802	7942	uh19	motherboardidredirection
4803	9057	uh19	motherboardidredirection
4804	9049	uh19	motherboardidredirection
4805	4790	uh19	motherboardidredirection
4806	9072	uh19	motherboardidredirection
4810	34073	th99	motherboardidredirection
4822	35125	th99	motherboardidredirection
4821	34967	th99	motherboardidredirection
4823	3036	uh19	motherboardidredirection
4824	32948	th99	motherboardidredirection
4825	3049	uh19	motherboardidredirection
4826	32871	th99	motherboardidredirection
4827	33756	th99	motherboardidredirection
4831	2246	uh19	motherboardidredirection
4832	34799	th99	motherboardidredirection
4834	34335	th99	motherboardidredirection
4833	34140	th99	motherboardidredirection
4839	32589	th99	motherboardidredirection
4843	8	uh19	motherboardidredirection
4844	5853	uh19	motherboardidredirection
4845	385	uh19	motherboardidredirection
4846	387	uh19	motherboardidredirection
4847	349	uh19	motherboardidredirection
4848	350	uh19	motherboardidredirection
4857	8506	uh19	motherboardidredirection
4858	3803	uh19	motherboardidredirection
4859	35336	th99	motherboardidredirection
4866	31839	th99	motherboardidredirection
4865	31663	th99	motherboardidredirection
4877	6739	uh19	motherboardidredirection
4880	31950	th99	motherboardidredirection
4883	32745	th99	motherboardidredirection
4884	4334	uh19	motherboardidredirection
4885	32745	th99	motherboardidredirection
4886	31987	th99	motherboardidredirection
4887	4329	uh19	motherboardidredirection
4889	54	uh19	motherboardidredirection
4890	31282	th99	motherboardidredirection
4891	6805	uh19	motherboardidredirection
4892	162	uh19	motherboardidredirection
4893	34201	th99	motherboardidredirection
4895	1097	uh19	motherboardidredirection
4896	32052	th99	motherboardidredirection
4897	5547	uh19	motherboardidredirection
4898	32592	th99	motherboardidredirection
4899	35840	th99	motherboardidredirection
4900	35863	th99	motherboardidredirection
4901	35862	th99	motherboardidredirection
4906	31760	th99	motherboardidredirection
4908	1179	uh19	motherboardidredirection
4909	30989	th99	motherboardidredirection
4910	35732	th99	motherboardidredirection
4911	35838	th99	motherboardidredirection
4912	35839	th99	motherboardidredirection
4913	35837	th99	motherboardidredirection
4914	35648	th99	motherboardidredirection
4915	35932	th99	motherboardidredirection
4916	35616	th99	motherboardidredirection
4917	35922	th99	motherboardidredirection
4918	35890	th99	motherboardidredirection
4919	35921	th99	motherboardidredirection
4920	35920	th99	motherboardidredirection
4921	35913	th99	motherboardidredirection
4922	35933	th99	motherboardidredirection
4923	35912	th99	motherboardidredirection
4924	35911	th99	motherboardidredirection
4925	35892	th99	motherboardidredirection
4926	35891	th99	motherboardidredirection
4927	35886	th99	motherboardidredirection
4928	35887	th99	motherboardidredirection
4929	35888	th99	motherboardidredirection
4930	35917	th99	motherboardidredirection
4931	35916	th99	motherboardidredirection
4932	35918	th99	motherboardidredirection
4933	35918	th99	motherboardidredirection
4934	35914	th99	motherboardidredirection
4935	35915	th99	motherboardidredirection
4936	35889	th99	motherboardidredirection
4937	35919	th99	motherboardidredirection
4938	35650	th99	motherboardidredirection
4939	35625	th99	motherboardidredirection
4940	35624	th99	motherboardidredirection
4941	33367	th99	motherboardidredirection
4942	35626	th99	motherboardidredirection
4943	36029	th99	motherboardidredirection
4944	36030	th99	motherboardidredirection
4945	36032	th99	motherboardidredirection
4946	36033	th99	motherboardidredirection
4947	36031	th99	motherboardidredirection
4948	35881	th99	motherboardidredirection
4949	35983	th99	motherboardidredirection
4950	35975	th99	motherboardidredirection
4951	35976	uh19	motherboardidredirection
4952	35973	th99	motherboardidredirection
4953	35871	th99	motherboardidredirection
4954	35870	th99	motherboardidredirection
4955	35655	th99	motherboardidredirection
4956	35869	th99	motherboardidredirection
4957	36137	th99	motherboardidredirection
4958	35977	th99	motherboardidredirection
4959	35984	th99	motherboardidredirection
4960	35985	th99	motherboardidredirection
4961	35980	th99	motherboardidredirection
4962	35981	th99	motherboardidredirection
4963	35979	th99	motherboardidredirection
4964	35971	uh19	motherboardidredirection
4965	35647	th99	motherboardidredirection
4966	35972	th99	motherboardidredirection
4967	33524	th99	motherboardidredirection
4968	35982	th99	motherboardidredirection
4969	35974	th99	motherboardidredirection
4970	35978	uh19	motherboardidredirection
4971	35874	th99	motherboardidredirection
4972	36136	th99	motherboardidredirection
4973	36133	th99	motherboardidredirection
4974	35873	th99	motherboardidredirection
4975	35872	th99	motherboardidredirection
4976	35875	th99	motherboardidredirection
4977	36134	th99	motherboardidredirection
4978	35831	th99	motherboardidredirection
4979	35879	th99	motherboardidredirection
4980	36132	th99	motherboardidredirection
4981	35878	th99	motherboardidredirection
4982	35880	th99	motherboardidredirection
4983	35852	th99	motherboardidredirection
4984	35653	th99	motherboardidredirection
4985	35654	th99	motherboardidredirection
4986	35951	th99	motherboardidredirection
4987	35952	th99	motherboardidredirection
4988	35936	th99	motherboardidredirection
4989	31236	th99	motherboardidredirection
4990	35937	th99	motherboardidredirection
4991	487	uh19	motherboardidredirection
4992	33342	th99	motherboardidredirection
4993	34350	th99	motherboardidredirection
4994	36036	th99	motherboardidredirection
4995	36035	th99	motherboardidredirection
4996	31957	uh19	motherboardidredirection
4997	33259	th99	motherboardidredirection
4998	31969	th99	motherboardidredirection
4999	35124	th99	motherboardidredirection
5000	35836	th99	motherboardidredirection
5002	619	uh19	motherboardidredirection
5003	35709	th99	motherboardidredirection
5004	35710	th99	motherboardidredirection
5005	35711	th99	motherboardidredirection
5006	31196	th99	motherboardidredirection
5007	33751	th99	motherboardidredirection
5008	35519	th99	motherboardidredirection
5009	35520	th99	motherboardidredirection
5010	32926	th99	motherboardidredirection
5011	36034	th99	motherboardidredirection
5012	33790	th99	motherboardidredirection
5013	35986	th99	motherboardidredirection
5014	35641	th99	motherboardidredirection
5015	35923	th99	motherboardidredirection
5016	35924	th99	motherboardidredirection
5017	35925	th99	motherboardidredirection
5018	34176	th99	motherboardidredirection
5019	35518	th99	motherboardidredirection
5020	34535	th99	motherboardidredirection
5021	35521	th99	motherboardidredirection
5022	31461	th99	motherboardidredirection
5023	32277	th99	motherboardidredirection
5024	35664	th99	motherboardidredirection
5025	35663	th99	motherboardidredirection
5026	35665	th99	motherboardidredirection
5027	30826	th99	motherboardidredirection
5028	35730	th99	motherboardidredirection
5029	35998	th99	motherboardidredirection
5030	35926	th99	motherboardidredirection
5031	35928	th99	motherboardidredirection
5032	35927	th99	motherboardidredirection
5033	30097	th99	motherboardidredirection
5034	30096	th99	motherboardidredirection
5035	30098	th99	motherboardidredirection
5036	30095	th99	motherboardidredirection
5037	30971	th99	motherboardidredirection
5038	30094	th99	motherboardidredirection
5039	30988	th99	motherboardidredirection
5040	35323	th99	motherboardidredirection
5041	1185	uh19	motherboardidredirection
5042	35740	th99	motherboardidredirection
5043	35322	th99	motherboardidredirection
5044	35739	th99	motherboardidredirection
5045	35321	th99	motherboardidredirection
5046	1191	uh19	motherboardidredirection
5047	1193	uh19	motherboardidredirection
5048	35324	th99	motherboardidredirection
5049	1195	uh19	motherboardidredirection
5050	35745	th99	motherboardidredirection
5051	35746	th99	motherboardidredirection
5052	35744	th99	motherboardidredirection
5053	35743	th99	motherboardidredirection
5054	35748	th99	motherboardidredirection
5055	35742	th99	motherboardidredirection
5056	35751	th99	motherboardidredirection
5057	35741	th99	motherboardidredirection
5058	35749	th99	motherboardidredirection
5059	35747	th99	motherboardidredirection
5060	35752	th99	motherboardidredirection
5061	35750	th99	motherboardidredirection
5062	30303	th99	motherboardidredirection
5063	1279	uh19	motherboardidredirection
5064	30870	th99	motherboardidredirection
5065	35777	th99	motherboardidredirection
5066	30728	th99	motherboardidredirection
5067	34218	th99	motherboardidredirection
5068	35893	th99	motherboardidredirection
5069	35860	th99	motherboardidredirection
5070	35861	th99	motherboardidredirection
5071	35864	th99	motherboardidredirection
5072	35717	th99	motherboardidredirection
5073	35930	th99	motherboardidredirection
5074	35866	th99	motherboardidredirection
5075	35867	th99	motherboardidredirection
5076	35713	th99	motherboardidredirection
5077	35714	th99	motherboardidredirection
5078	35715	th99	motherboardidredirection
5079	35929	th99	motherboardidredirection
5080	35882	th99	motherboardidredirection
5081	35844	th99	motherboardidredirection
5082	35843	th99	motherboardidredirection
5083	35712	th99	motherboardidredirection
5084	35698	th99	motherboardidredirection
5085	35704	th99	motherboardidredirection
5086	35865	th99	motherboardidredirection
5087	35701	th99	motherboardidredirection
5088	35702	th99	motherboardidredirection
5089	35699	th99	motherboardidredirection
5090	35700	th99	motherboardidredirection
5091	35963	th99	motherboardidredirection
5092	35962	th99	motherboardidredirection
5093	35960	th99	motherboardidredirection
5094	35964	th99	motherboardidredirection
5095	35961	th99	motherboardidredirection
5096	35842	th99	motherboardidredirection
5097	35716	th99	motherboardidredirection
5098	35705	th99	motherboardidredirection
5099	35848	th99	motherboardidredirection
5100	35841	th99	motherboardidredirection
5101	31907	th99	motherboardidredirection
5102	35949	th99	motherboardidredirection
5103	35948	th99	motherboardidredirection
5104	30912	th99	motherboardidredirection
5105	35950	th99	motherboardidredirection
5106	32287	th99	motherboardidredirection
5107	35513	th99	motherboardidredirection
5108	31653	th99	motherboardidredirection
5109	35515	th99	motherboardidredirection
5110	35509	th99	motherboardidredirection
5111	35241	th99	motherboardidredirection
5112	33707	th99	motherboardidredirection
5113	33706	th99	motherboardidredirection
5114	35514	th99	motherboardidredirection
5115	35516	th99	motherboardidredirection
5116	35510	th99	motherboardidredirection
5117	33703	th99	motherboardidredirection
5118	35508	th99	motherboardidredirection
5119	36144	th99	motherboardidredirection
5120	36143	th99	motherboardidredirection
5121	36135	th99	motherboardidredirection
5122	35507	th99	motherboardidredirection
5123	36138	th99	motherboardidredirection
5124	36142	th99	motherboardidredirection
5125	35511	th99	motherboardidredirection
5126	36140	th99	motherboardidredirection
5127	36141	th99	motherboardidredirection
5128	36139	th99	motherboardidredirection
5129	33993	th99	motherboardidredirection
5130	35970	th99	motherboardidredirection
5131	36054	th99	motherboardidredirection
5132	34053	th99	motherboardidredirection
5133	36053	th99	motherboardidredirection
5134	35115	th99	motherboardidredirection
5135	36112	th99	motherboardidredirection
5136	35680	th99	motherboardidredirection
5137	35486	th99	motherboardidredirection
5138	35600	th99	motherboardidredirection
5139	35574	th99	motherboardidredirection
5140	35567	th99	motherboardidredirection
5141	35475	th99	motherboardidredirection
5142	35577	th99	motherboardidredirection
5143	35478	th99	motherboardidredirection
5144	35489	th99	motherboardidredirection
5145	35586	th99	motherboardidredirection
5146	31752	th99	motherboardidredirection
5147	31772	th99	motherboardidredirection
5148	35851	th99	motherboardidredirection
5149	35850	th99	motherboardidredirection
5150	34734	th99	motherboardidredirection
5151	35849	th99	motherboardidredirection
5152	35116	th99	motherboardidredirection
5153	35524	th99	motherboardidredirection
5155	35636	th99	motherboardidredirection
5156	35637	th99	motherboardidredirection
5157	33890	th99	motherboardidredirection
5158	30116	th99	motherboardidredirection
5159	35931	th99	motherboardidredirection
5160	33551	th99	motherboardidredirection
5161	32103	th99	motherboardidredirection
5162	35652	th99	motherboardidredirection
5163	35559	th99	motherboardidredirection
5164	35558	th99	motherboardidredirection
5165	35555	th99	motherboardidredirection
5166	35662	th99	motherboardidredirection
5167	35557	th99	motherboardidredirection
5168	35556	th99	motherboardidredirection
5169	35651	th99	motherboardidredirection
5170	35560	th99	motherboardidredirection
5171	35638	th99	motherboardidredirection
5172	35639	th99	motherboardidredirection
5173	35634	th99	motherboardidredirection
5174	35615	th99	motherboardidredirection
5175	35480	th99	motherboardidredirection
5176	35500	th99	motherboardidredirection
5177	35621	th99	motherboardidredirection
5178	35614	th99	motherboardidredirection
5179	35594	th99	motherboardidredirection
5180	35471	th99	motherboardidredirection
5181	36107	th99	motherboardidredirection
5182	36100	th99	motherboardidredirection
5183	36099	th99	motherboardidredirection
5184	36102	th99	motherboardidredirection
5185	36101	th99	motherboardidredirection
5186	35685	th99	motherboardidredirection
5187	35686	th99	motherboardidredirection
5188	36100	th99	motherboardidredirection
5189	36097	th99	motherboardidredirection
5190	36109	th99	motherboardidredirection
5191	36104	th99	motherboardidredirection
5192	36105	th99	motherboardidredirection
5193	36111	th99	motherboardidredirection
5194	36096	th99	motherboardidredirection
5195	35687	th99	motherboardidredirection
5196	35688	th99	motherboardidredirection
5197	35684	th99	motherboardidredirection
5198	35692	th99	motherboardidredirection
5199	36103	th99	motherboardidredirection
5200	36092	th99	motherboardidredirection
5201	36093	th99	motherboardidredirection
5202	36095	th99	motherboardidredirection
5203	36098	th99	motherboardidredirection
5204	35696	th99	motherboardidredirection
5205	35693	th99	motherboardidredirection
5206	35690	th99	motherboardidredirection
5207	35689	th99	motherboardidredirection
5208	35694	th99	motherboardidredirection
5209	35691	th99	motherboardidredirection
5210	36108	th99	motherboardidredirection
5211	36106	th99	motherboardidredirection
5212	35697	th99	motherboardidredirection
5213	35706	th99	motherboardidredirection
5214	35695	th99	motherboardidredirection
5215	35643	th99	motherboardidredirection
5217	33451	th99	motherboardidredirection
5218	35683	th99	motherboardidredirection
5219	35682	th99	motherboardidredirection
5220	35681	th99	motherboardidredirection
5221	36091	th99	motherboardidredirection
5222	35136	th99	motherboardidredirection
5223	35137	th99	motherboardidredirection
5224	35756	th99	motherboardidredirection
5225	33320	th99	motherboardidredirection
5226	35857	th99	motherboardidredirection
5227	35855	th99	motherboardidredirection
5228	35856	th99	motherboardidredirection
5229	35853	th99	motherboardidredirection
5230	35854	th99	motherboardidredirection
5231	30557	th99	motherboardidredirection
5232	36071	th99	motherboardidredirection
5233	36068	th99	motherboardidredirection
5234	36000	th99	motherboardidredirection
5235	36069	th99	motherboardidredirection
5236	36070	th99	motherboardidredirection
5237	35999	th99	motherboardidredirection
5238	36022	th99	motherboardidredirection
5239	36023	th99	motherboardidredirection
5240	36046	th99	motherboardidredirection
5241	35667	th99	motherboardidredirection
5242	36018	th99	motherboardidredirection
5243	36001	th99	motherboardidredirection
5244	36010	th99	motherboardidredirection
5245	36016	th99	motherboardidredirection
5246	36017	th99	motherboardidredirection
5247	36020	th99	motherboardidredirection
5248	36024	th99	motherboardidredirection
5249	36015	th99	motherboardidredirection
5250	36004	th99	motherboardidredirection
5251	36019	th99	motherboardidredirection
5252	36002	th99	motherboardidredirection
5253	36003	th99	motherboardidredirection
5254	35675	th99	motherboardidredirection
5255	35676	th99	motherboardidredirection
5256	35678	th99	motherboardidredirection
5257	35677	th99	motherboardidredirection
5258	36007	th99	motherboardidredirection
5259	35671	th99	motherboardidredirection
5260	35674	th99	motherboardidredirection
5261	35673	th99	motherboardidredirection
5262	35672	th99	motherboardidredirection
5263	36012	th99	motherboardidredirection
5264	36013	th99	motherboardidredirection
5265	36014	th99	motherboardidredirection
5266	35666	th99	motherboardidredirection
5267	35670	th99	motherboardidredirection
5268	36005	th99	motherboardidredirection
5269	36006	th99	motherboardidredirection
5270	35668	th99	motherboardidredirection
5271	35669	th99	motherboardidredirection
5272	36009	th99	motherboardidredirection
5273	36008	th99	motherboardidredirection
5274	36011	th99	motherboardidredirection
5275	36021	th99	motherboardidredirection
5276	34035	th99	motherboardidredirection
5277	34036	th99	motherboardidredirection
5278	34037	th99	motherboardidredirection
5279	35994	th99	motherboardidredirection
5280	35990	th99	motherboardidredirection
5281	35644	th99	motherboardidredirection
5282	35987	th99	motherboardidredirection
5283	35988	th99	motherboardidredirection
5284	35989	th99	motherboardidredirection
5285	35646	th99	motherboardidredirection
5286	35645	th99	motherboardidredirection
5287	35991	th99	motherboardidredirection
5288	35640	th99	motherboardidredirection
5289	35992	th99	motherboardidredirection
5290	35995	th99	motherboardidredirection
5291	35993	th99	motherboardidredirection
5292	35118	th99	motherboardidredirection
5293	35679	th99	motherboardidredirection
5294	35896	th99	motherboardidredirection
5295	35895	th99	motherboardidredirection
5296	35894	th99	motherboardidredirection
5297	33491	th99	motherboardidredirection
5298	30795	th99	motherboardidredirection
5299	30796	th99	motherboardidredirection
5300	30794	th99	motherboardidredirection
5301	30837	th99	motherboardidredirection
5302	30410	th99	motherboardidredirection
5303	30061	th99	motherboardidredirection
5304	33306	th99	motherboardidredirection
5305	32108	th99	motherboardidredirection
5306	33922	th99	motherboardidredirection
5307	33455	th99	motherboardidredirection
5308	33348	th99	motherboardidredirection
5309	35120	th99	motherboardidredirection
5310	33814	th99	motherboardidredirection
5311	35778	th99	motherboardidredirection
5312	35883	th99	motherboardidredirection
5313	35884	th99	motherboardidredirection
5314	35885	th99	motherboardidredirection
5315	35780	th99	motherboardidredirection
5316	35779	th99	motherboardidredirection
5317	34883	th99	motherboardidredirection
5318	34969	th99	motherboardidredirection
5319	32642	th99	motherboardidredirection
5320	34978	th99	motherboardidredirection
5321	34980	th99	motherboardidredirection
5322	35997	th99	motherboardidredirection
5323	35996	th99	motherboardidredirection
5324	33575	th99	motherboardidredirection
5325	33576	th99	motherboardidredirection
5326	35733	th99	motherboardidredirection
5327	35755	th99	motherboardidredirection
5328	35732	th99	motherboardidredirection
5329	35753	th99	motherboardidredirection
5330	35731	th99	motherboardidredirection
5331	35731	th99	motherboardidredirection
5332	32174	th99	motherboardidredirection
5333	35522	th99	motherboardidredirection
5334	35527	th99	motherboardidredirection
5335	35523	th99	motherboardidredirection
5336	35518	th99	motherboardidredirection
5337	32373	th99	motherboardidredirection
5338	33324	th99	motherboardidredirection
5339	35762	th99	motherboardidredirection
5340	35764	th99	motherboardidredirection
5341	35763	th99	motherboardidredirection
5342	35765	th99	motherboardidredirection
5343	35761	th99	motherboardidredirection
5344	35966	th99	motherboardidredirection
5345	35968	th99	motherboardidredirection
5346	35965	th99	motherboardidredirection
5347	35967	th99	motherboardidredirection
5348	35845	th99	motherboardidredirection
5349	33438	th99	motherboardidredirection
5350	35734	th99	motherboardidredirection
5351	35719	th99	motherboardidredirection
5352	35757	th99	motherboardidredirection
5353	35758	th99	motherboardidredirection
5354	35736	th99	motherboardidredirection
5355	35720	th99	motherboardidredirection
5356	35876	th99	motherboardidredirection
5357	35737	th99	motherboardidredirection
5358	35738	th99	motherboardidredirection
5359	35718	th99	motherboardidredirection
5360	35877	th99	motherboardidredirection
5361	35846	th99	motherboardidredirection
5362	35735	th99	motherboardidredirection
5363	35847	th99	motherboardidredirection
5364	35579	th99	motherboardidredirection
5365	35584	th99	motherboardidredirection
5366	35585	th99	motherboardidredirection
5367	35582	th99	motherboardidredirection
5368	35583	th99	motherboardidredirection
5369	35581	th99	motherboardidredirection
5370	35580	th99	motherboardidredirection
5371	35728	th99	motherboardidredirection
5372	35729	th99	motherboardidredirection
5373	35723	th99	motherboardidredirection
5374	35721	th99	motherboardidredirection
5375	35722	th99	motherboardidredirection
5376	35725	th99	motherboardidredirection
5377	35724	th99	motherboardidredirection
5378	35834	th99	motherboardidredirection
5379	35835	th99	motherboardidredirection
5380	35130	th99	motherboardidredirection
5381	35726	th99	motherboardidredirection
5382	35727	th99	motherboardidredirection
5383	35770	th99	motherboardidredirection
5384	35833	th99	motherboardidredirection
5385	35832	th99	motherboardidredirection
5386	35775	th99	motherboardidredirection
5387	35628	th99	motherboardidredirection
5388	35627	th99	motherboardidredirection
5389	35629	th99	motherboardidredirection
5390	35774	th99	motherboardidredirection
5391	35773	th99	motherboardidredirection
5392	35632	th99	motherboardidredirection
5393	35631	th99	motherboardidredirection
5394	35630	th99	motherboardidredirection
5395	35776	th99	motherboardidredirection
5396	35772	th99	motherboardidredirection
5397	35859	th99	motherboardidredirection
5398	35858	th99	motherboardidredirection
5399	36040	th99	motherboardidredirection
5400	36041	th99	motherboardidredirection
5401	36039	th99	motherboardidredirection
5402	36038	th99	motherboardidredirection
5403	36037	th99	motherboardidredirection
5404	36043	th99	motherboardidredirection
5405	36047	th99	motherboardidredirection
5406	36048	th99	motherboardidredirection
5407	36049	th99	motherboardidredirection
5408	36042	th99	motherboardidredirection
5409	36050	th99	motherboardidredirection
5410	35939	th99	motherboardidredirection
5411	35935	th99	motherboardidredirection
5412	35941	th99	motherboardidredirection
5413	35940	th99	motherboardidredirection
5414	35942	th99	motherboardidredirection
5415	35943	th99	motherboardidredirection
5416	36045	th99	motherboardidredirection
5417	36044	th99	motherboardidredirection
5418	35934	th99	motherboardidredirection
5419	36061	th99	motherboardidredirection
5420	36062	th99	motherboardidredirection
5421	36060	th99	motherboardidredirection
5422	36056	th99	motherboardidredirection
5423	36057	th99	motherboardidredirection
5424	36055	th99	motherboardidredirection
5425	36059	th99	motherboardidredirection
5426	36058	th99	motherboardidredirection
5427	36063	th99	motherboardidredirection
5428	36067	th99	motherboardidredirection
5429	36064	th99	motherboardidredirection
5430	36066	th99	motherboardidredirection
5431	36065	th99	motherboardidredirection
5432	35910	th99	motherboardidredirection
5433	36051	th99	motherboardidredirection
5434	36052	th99	motherboardidredirection
5435	35908	th99	motherboardidredirection
5436	35907	th99	motherboardidredirection
5437	35909	th99	motherboardidredirection
5438	35905	th99	motherboardidredirection
5439	35904	th99	motherboardidredirection
5440	35897	th99	motherboardidredirection
5441	35899	th99	motherboardidredirection
5442	35901	th99	motherboardidredirection
5443	35906	th99	motherboardidredirection
5444	35903	th99	motherboardidredirection
5445	35898	th99	motherboardidredirection
5446	35900	th99	motherboardidredirection
5447	35902	th99	motherboardidredirection
5448	34364	th99	motherboardidredirection
5449	35944	th99	motherboardidredirection
5450	35549	th99	motherboardidredirection
5451	35554	th99	motherboardidredirection
5452	35946	th99	motherboardidredirection
5453	35947	th99	motherboardidredirection
5454	35548	th99	motherboardidredirection
5455	35550	th99	motherboardidredirection
5456	35553	th99	motherboardidredirection
5457	35552	th99	motherboardidredirection
5458	35551	th99	motherboardidredirection
5459	35543	th99	motherboardidredirection
5460	35547	th99	motherboardidredirection
5461	35945	th99	motherboardidredirection
5462	35545	th99	motherboardidredirection
5463	35546	th99	motherboardidredirection
5464	35544	th99	motherboardidredirection
5465	36084	th99	motherboardidredirection
5466	36086	th99	motherboardidredirection
5467	36094	th99	motherboardidredirection
5468	36083	th99	motherboardidredirection
5469	36082	th99	motherboardidredirection
5470	36075	th99	motherboardidredirection
5471	36081	th99	motherboardidredirection
5472	36080	th99	motherboardidredirection
5473	36079	th99	motherboardidredirection
5474	36078	th99	motherboardidredirection
5475	36077	th99	motherboardidredirection
5476	36076	th99	motherboardidredirection
5477	36085	th99	motherboardidredirection
5478	36074	th99	motherboardidredirection
5479	36073	th99	motherboardidredirection
5480	35658	th99	motherboardidredirection
5481	35656	th99	motherboardidredirection
5482	35657	th99	motherboardidredirection
5483	36087	th99	motherboardidredirection
5484	36089	th99	motherboardidredirection
5485	36088	th99	motherboardidredirection
5486	35955	th99	motherboardidredirection
5487	35956	th99	motherboardidredirection
5488	35957	th99	motherboardidredirection
5489	35938	th99	motherboardidredirection
5490	35969	th99	motherboardidredirection
5491	35953	th99	motherboardidredirection
5492	35954	th99	motherboardidredirection
5493	35959	th99	motherboardidredirection
5494	35958	th99	motherboardidredirection
5495	36090	th99	motherboardidredirection
5496	35759	th99	motherboardidredirection
5497	35760	th99	motherboardidredirection
5498	30854	th99	motherboardidredirection
5499	30390	th99	motherboardidredirection
5500	31275	th99	motherboardidredirection
5501	33806	th99	motherboardidredirection
5502	32721	th99	motherboardidredirection
5503	33124	th99	motherboardidredirection
5504	30408	th99	motherboardidredirection
5505	30409	th99	motherboardidredirection
5506	31842	th99	motherboardidredirection
5507	30335	th99	motherboardidredirection
5508	31243	th99	motherboardidredirection
5509	33037	th99	motherboardidredirection
5510	33678	th99	motherboardidredirection
5511	31798	th99	motherboardidredirection
5512	32169	th99	motherboardidredirection
5513	31876	th99	motherboardidredirection
5514	33108	th99	motherboardidredirection
5515	31879	th99	motherboardidredirection
5516	35131	th99	motherboardidredirection
5517	32303	th99	motherboardidredirection
5518	31630	th99	motherboardidredirection
5519	30591	th99	motherboardidredirection
5520	31287	th99	motherboardidredirection
5521	32053	th99	motherboardidredirection
5522	31470	th99	motherboardidredirection
5523	31759	th99	motherboardidredirection
5524	33682	th99	motherboardidredirection
5525	32400	th99	motherboardidredirection
5526	33657	th99	motherboardidredirection
5527	31512	th99	motherboardidredirection
5528	30540	th99	motherboardidredirection
5529	30730	th99	motherboardidredirection
5530	30392	th99	motherboardidredirection
5531	30760	th99	motherboardidredirection
5532	30124	th99	motherboardidredirection
5533	31449	th99	motherboardidredirection
5534	32034	th99	motherboardidredirection
5535	31325	th99	motherboardidredirection
5536	35576	th99	motherboardidredirection
5537	35587	th99	motherboardidredirection
5538	35529	th99	motherboardidredirection
5539	35659	th99	motherboardidredirection
5541	35660	th99	motherboardidredirection
5542	35707	th99	motherboardidredirection
5543	35708	th99	motherboardidredirection
5544	35661	th99	motherboardidredirection
5545	4231	uh19	motherboardidredirection
5546	33033	th99	motherboardidredirection
5547	2259	uh19	motherboardidredirection
5548	35635	th99	motherboardidredirection
5549	3348	uh19	motherboardidredirection
5550	34851	th99	motherboardidredirection
5551	3349	uh19	motherboardidredirection
5552	34852	th99	motherboardidredirection
5553	3355	uh19	motherboardidredirection
5554	34841	th99	motherboardidredirection
5555	8512	uh19	motherboardidredirection
5558	8032	uh19	motherboardidredirection
5559	6391	uh19	motherboardidredirection
5560	9741	uh19	motherboardidredirection
5561	9779	uh19	motherboardidredirection
5563	5950	uh19	motherboardidredirection
5566	3579	uh19	motherboardidredirection
5567	32513	th99	motherboardidredirection
5568	321	uh19	motherboardidredirection
5569	32055	th99	motherboardidredirection
5570	32541	th99	motherboardidredirection
5571	5770	uh19	motherboardidredirection
5572	34112	th99	motherboardidredirection
5573	35213	th99	motherboardidredirection
5574	568	uh19	motherboardidredirection
5575	31960	th99	motherboardidredirection
5576	7181	uh19	motherboardidredirection
5577	3645	uh19	motherboardidredirection
5578	33023	th99	motherboardidredirection
5580	4032	uh19	motherboardidredirection
5581	32481	th99	motherboardidredirection
5582	4031	uh19	motherboardidredirection
5583	32105	th99	motherboardidredirection
5584	2794	uh19	motherboardidredirection
5585	35642	th99	motherboardidredirection
5586	34122	th99	motherboardidredirection
5587	7209	uh19	motherboardidredirection
5590	10051	uh19	motherboardidredirection
5591	7000	uh19	motherboardidredirection
5592	6814	uh19	motherboardidredirection
5594	9816	uh19	motherboardidredirection
5595	6312	uh19	motherboardidredirection
5596	6314	uh19	motherboardidredirection
5597	34094	th99	motherboardidredirection
5601	2971	uh19	motherboardidredirection
5602	34787	th99	motherboardidredirection
5603	35943	th99	motherboardidredirection
5606	31636	th99	motherboardidredirection
5607	34427	th99	motherboardidredirection
5608	34427	th99	motherboardidredirection
5613	10181	uh19	motherboardidredirection
5619	4998	uh19	motherboardidredirection
5620	32556	th99	motherboardidredirection
5621	3891	uh19	motherboardidredirection
5622	34459	th99	motherboardidredirection
5623	1210	uh19	motherboardidredirection
5624	33010	th99	motherboardidredirection
5625	3886	uh19	motherboardidredirection
5626	34456	th99	motherboardidredirection
5628	4246	uh19	motherboardidredirection
5629	33562	th99	motherboardidredirection
5630	4247	uh19	motherboardidredirection
5631	33574	th99	motherboardidredirection
5632	10195	uh19	motherboardidredirection
5633	33328	th99	motherboardidredirection
5634	34542	th99	motherboardidredirection
5635	9801	uh19	motherboardidredirection
5636	6714	uh19	motherboardidredirection
5640	2247	uh19	motherboardidredirection
5641	34798	th99	motherboardidredirection
5643	32820	th99	motherboardidredirection
5645	35770	th99	motherboardidredirection
\.



--
-- Data for Name: instruction_set; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.instruction_set (id, name) FROM stdin;
0	i8086
1	i186
2	i286
3	i386
4	i486
5	i586
6	i686
8	3DNow!
9	SSE
12	i8087
13	i187
14	i287
15	i387
16	i487
10	SSE2
7	MMX
17	SSE3
18	SSSE3
19	SSE4.1
20	NX Bit
21	CMOV
22	3DNow!+
23	SSE4A
24	VT-x/AMD-V
11	AMD64/EM64T
26	Cyrix EMMI
25	Intel Extended MMX
27	68k
28	Z80
30	PowerPC
29	i8080
32	Weitek FPU
33	Nx587
34	Nx586
35	VIA Padlock
36	Alpha
37	6x86
\.


--
-- Data for Name: instruction_set_instruction_set; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.instruction_set_instruction_set (instruction_set_source, instruction_set_target) FROM stdin;
1	0
2	1
3	2
4	3
5	4
6	5
5	16
28	29
37	4
37	16
10	9
17	9
17	10
18	7
18	25
18	9
18	10
18	17
10	7
10	25
9	7
9	25
19	7
19	25
19	9
19	10
19	17
19	18
\.


--
-- Data for Name: io_port; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.io_port (id, name) FROM stdin;
1	Floppy interface
3	IDE interface
4	PS/2 keyboard
5	PS/2 mouse
6	Parallel
7	Serial
9	Internal SCSI
10	External SCSI
11	SB_Link
12	USB 2.0
2	Gameport
8	USB 1.x
13	SATA I
14	SATA II
15	IEEE 1394
16	RJ-45 LAN
17	S/PDIF
18	VGA
19	TV-Out
20	AT Keyboard
21	XT Keyboard
22	Keyboard
23	CF Card Slot
24	GPIO
25	Composite Video
26	DVI
27	Toslink
28	RJ-11 modem
29	EGA
30	CGA
31	MDA
32	SCR (SmartCard Reader)
33	HP-HIL
34	Disk-on-Chip Socket
35	S-Video
36	eSATA
37	USB 3.0
\.


--
-- Data for Name: known_issue; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.known_issue (id, name) FROM stdin;
1	Leaky Ni-Cd clock battery
2	DALLAS RTC may be flat
3	Fake cache
4	Bad/leaky electrolytic capacitors
5	Bad/shorted tantalum capacitors
6	Underpowered AGP
7	Underpowered VRM
9	Intel MTH issues
10	Bad IDE Controller
11	Underpowered VRM (in certain revisions)
8	Underperforming chipset/board
13	Propietary Cache
14	Broken AGP implementation
18	Fake AGP slot
15	Propietary Power Supply Connector
16	VRM spec not as advertised
17	Propietary RAM
19	BIOS Flash Chip may be bad
12	Inapropiate Power Delivery
20	Poor Stability/Reliability
\.


--
-- Data for Name: language; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.language (id, name, original_name, iso_code) FROM stdin;
1	English	English	en
2	French	Français	fr
3	German	Deutsch	de
4	Spanish	Español	es
5	Italian	Italiano	it
6	Multi-Language	n/a	n/a
7	Chinese	中文	zh
8	Japanese	日本語	ja
9	Korean	한국어 (韓國語) ; 조선말 (朝鮮語)	ko
10	Polish	Polski	pl
11	Afar	Afaraf	aa
12	Abkhazian	Аҧсуа	ab
14	Afrikaans	Afrikaans	af
15	Akan	Akan	ak
16	Amharic	አማርኛ	am
17	Aragonese	Aragonés	an
18	Arabic	العربية	ar
19	Assamese	অসমীয়া	as
20	Avaric	авар мацӀ ; магӀарул мацӀ	av
21	Aymara	Aymar aru	ay
22	Azerbaijani	Azərbaycan dili	az
23	Bashkir	башҡорт теле	ba
24	Belarusian	Беларуская	be
25	Bulgarian	български език	bg
26	Bihari	भोजपुरी	bh
27	Bislama	Bislama	bi
28	Bambara	Bamanankan	bm
29	Bengali	বাংলা	bn
30	Tibetan	བོད་ཡིག	bo
31	Breton	Brezhoneg	br
32	Bosnian	Bosanski jezik	bs
33	Catalan	Català	ca
34	Chechen	нохчийн мотт	ce
35	Chamorro	Chamoru	ch
36	Corsican	Corsu ; lingua corsa	co
37	Cree	ᓀᐦᐃᔭᐍᐏᐣ	cr
38	Czech	Česky ; čeština	cs
39	Old Church Slavonic	Словѣньскъ	cu
40	Chuvash	чӑваш чӗлхи	cv
41	Welsh	Cymraeg	cy
42	Danish	Dansk	da
43	Divehi	ދިވެހި	dv
44	Dzongkha	རྫོང་ཁ	dz
45	Ewe	Ɛʋɛgbɛ	ee
46	Greek	Ελληνικά	el
47	Esperanto	Esperanto	eo
48	Estonian	Eesti keel	et
49	Basque	Euskara	eu
50	Persian	فارسی	fa
51	Fulah	Fulfulde	ff
52	Finnish	Suomen kieli	fi
53	Fijian	Vosa Vakaviti	fj
54	Faroese	Føroyskt	fo
55	Western Frisian	Frysk	fy
56	Irish	Gaeilge	ga
57	Scottish Gaelic	Gàidhlig	gd
58	Galician	Galego	gl
59	Guarani	Avañe'ẽ	gn
60	Gujarati	ગુજરાતી	gu
61	Manx	Ghaelg	gv
62	Hausa	هَوُسَ	ha
63	Hebrew	עברית	he
64	Hindi	हिन्दी ; हिंदी	hi
65	Hiri Motu	Hiri Motu	ho
66	Croatian	Hrvatski	hr
67	Haitian	Kreyòl ayisyen	ht
68	Hungarian	magyar	hu
69	Armenian	Հայերեն	hy
70	Herero	Otjiherero	hz
72	Indonesian	Bahasa Indonesia	id
74	Igbo	Igbo	ig
75	Sichuan Yi	ꆇꉙ	ii
76	Inupiaq	Iñupiaq ; Iñupiatun	ik
77	Ido	Ido	io
78	Icelandic	Íslenska	is
79	Inuktitut	ᐃᓄᒃᑎᑐᑦ	iu
81	Javanese	Basa Jawa	jv
82	Georgian	ქართული	ka
83	Kongo	KiKongo	kg
84	Kikuyu	Gĩkũyũ	ki
85	Kwanyama	Kuanyama	kj
86	Kazakh	Қазақ тілі	kk
87	Greenlandic	Kalaallisut ; kalaallit oqaasii	kl
88	Khmer	ភាសាខ្មែរ	km
89	Kannada	ಕನ್ನಡ	kn
90	Kanuri	Kanuri	kr
91	Kashmiri	कश्मीरी ; كشميري	ks
92	Kurdish	Kurdî ; كوردی	ku
93	Komi	коми кыв	kv
94	Cornish	Kernewek	kw
95	Kirghiz	кыргыз тили	ky
96	Latin	Latine ; lingua latina	la
97	Luxembourgish	Lëtzebuergesch	lb
98	Ganda	Luganda	lg
99	Limburgish	Limburgs	li
100	Lingala	Lingála	ln
101	Lao	ພາສາລາວ	lo
102	Lithuanian	Lietuvių kalba	lt
103	Luba	tshiluba	lu
104	Latvian	Latviešu valoda	lv
105	Malagasy	Fiteny malagasy	mg
106	Marshallese	Kajin M̧ajeļ	mh
107	Māori	Te reo Māori	mi
108	Macedonian	македонски јазик	mk
109	Malayalam	മലയാളം	ml
110	Mongolian	Монгол	mn
111	Moldavian	лимба молдовеняскэ	mo
112	Marathi	मराठी	mr
113	Malay	Bahasa Melayu ; بهاس ملايو	ms
114	Maltese	Malti	mt
115	Burmese	ဗမာစာ	my
116	Nauru	Ekakairũ Naoero	na
117	Norwegian Bokmål	Norsk bokmål	nb
118	North Ndebele	isiNdebele	nd
119	Nepali	नेपाली	ne
120	Ndonga	Owambo	ng
121	Dutch	Nederlands	nl
122	Norwegian Nynorsk	Norsk nynorsk	nn
123	Norwegian	Norsk	no
124	South Ndebele	Ndébélé	nr
125	Navajo	Diné bizaad ; Dinékʼehǰí	nv
126	Chichewa	ChiCheŵa ; chinyanja	ny
127	Occitan	Occitan	oc
129	Oromo	Afaan Oromoo	om
130	Oriya	ଓଡ଼ିଆ	or
131	Ossetian	Ирон ӕвзаг	os
132	Panjabi	ਪੰਜਾਬੀ ; پنجابی	pa
133	Pāli	पािऴ	pi
135	Pashto	پښتو	ps
136	Portuguese	Português	pt
137	Quechua	Runa Simi ; Kichwa	qu
138	Reunionese	Kréol Rénioné	rc
139	Romansh	Rumantsch grischun	rm
140	Kirundi	kiRundi	rn
141	Romanian	Română	ro
142	Russian	русский язык	ru
143	Kinyarwanda	Kinyarwanda	rw
144	Sanskrit	संस्कृतम्	sa
145	Sardinian	sardu	sc
146	Sindhi	सिन्धी ; سنڌي، سندھی	sd
147	Northern Sami	Davvisámegiella	se
148	Sango	Yângâ tî sängö	sg
149	Serbo-Croatian	srpskohrvatski jezik ; српскохрватски језик	sh
150	Sinhalese	සිංහල	si
151	Slovak	Slovenčina	sk
152	Slovenian	Slovenščina	sl
153	Samoan	Gagana fa'a Samoa	sm
154	Shona	chiShona	sn
155	Somali	Soomaaliga ; af Soomaali	so
156	Albanian	Shqip	sq
157	Serbian	српски језик	sr
158	Swati	SiSwati	ss
159	Sotho	seSotho	st
160	Sundanese	Basa Sunda	su
161	Swedish	Svenska	sv
162	Swahili	Kiswahili	sw
163	Tamil	தமிழ்	ta
164	Telugu	తెలుగు	te
165	Tajik	тоҷикӣ ; toğikī ; تاجیکی	tg
166	Thai	ไทย	th
167	Tigrinya	ትግርኛ	ti
168	Turkmen	Türkmen ; Түркмен	tk
169	Tagalog	Tagalog	tl
170	Tswana	seTswana	tn
171	Tonga	faka Tonga	to
172	Turkish	Türkçe	tr
173	Tsonga	xiTsonga	ts
174	Tatar	татарча ; tatarça ; تاتارچا	tt
175	Twi	Twi	tw
176	Tahitian	Reo Mā`ohi	ty
177	Uighur	Uyƣurqə ; ئۇيغۇرچ	ug
178	Ukrainian	українська мова	uk
179	Urdu	اردو	ur
180	Uzbek	O'zbek ; Ўзбек ; أۇزبېك	uz
181	Venda	tshiVenḓa	ve
182	Viêt Namese	Tiếng Việt	vi
184	Walloon	Walon	wa
185	Wolof	Wollof	wo
186	Xhosa	isiXhosa	xh
187	Yiddish	ייִדיש	yi
188	Yoruba	Yorùbá	yo
189	Zhuang	Saɯ cueŋƅ ; Saw cuengh	za
190	Zulu	isiZulu	zu
\.









--
-- Data for Name: license; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.license (id, name) FROM stdin;
1	Creative Commons Attribution 4.0 International
2	Copyright image's creator
\.


--
-- Data for Name: manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.manual (id, motherboard_id, language_id, file_name, link_name, updated_at) FROM stdin;
\.


--
-- Data for Name: manufacturer; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.manufacturer (id, name, short_name) FROM stdin;
1	A-TREND TECHNOLOGY CORPORATION	A-Trend
3	ABC COMPUTER COMPANY, LTD.	\N
4	ABIT COMPUTER CORPORATION	ABit
5	ACC Microelectronics	\N
6	ACER AMERICA CORPORATION	\N
7	ACER, INC.	Acer
10	ACQUIRE COMPUTER SYSTEMS, INC.	\N
12	ACS, INC.	\N
13	ACTION INSTRUMENTS	\N
14	ACTION WELL DEVELOPMENT, LTD.	\N
15	ACTIVEI SYSTEMS, INC.	\N
17	ADVANCED COMPUTER TECHNOLOGY, LTD.	\N
18	ADVANCED DIGITAL CORPORATION	\N
22	AIM MOTHERBOARD COMPANY	\N
24	ALPHA MICROSYSTEMS	\N
25	ACER LABS, INC.	ALi
26	AMAX ENGINEERING CORPORATION	\N
27	ADVANCED MICRO DEVICES, INC.	AMD
28	AMDEK CORPORATION	\N
30	AMERICAN DIGITAL DATA ASSOCIATES	\N
31	AMERICAN MEGATRENDS, INC.	AMI
33	AMERICAN RESEARCH CORPORATION	\N
34	AMPRO COMPUTERS, INC.	\N
35	AMPTRON INTERNATIONAL, INC.	Amptron
36	ANIX TECHNOLOGY CORPORATION	\N
37	ANSEL COMMUNICATIONS, INC.	\N
38	ANTEC, INC.	\N
40	APRICOT COMPUTERS LIMITED	\N
42	ARC	\N
44	AREA ELECTRONICS SYSTEMS, INC.	\N
45	ARNOS INSTRUMENTS & COMPUTER SYSTEMS, INC.	\N
46	ARTEK COMPUTER SYSTEMS, INC.	\N
47	ASIA DATA, INC.	\N
48	ASIA DIRECT CORPORATION	\N
49	ASICOM, INC.	\N
51	ASPEN SYSTEMS, INC.	\N
54	AT&T, INC.	\N
56	ATEN RESEARCH, INC.	\N
57	ATLANTIC COMPUTER PRODUCTS, INC.	\N
58	ATRONICS INTERNATIONAL, INC.	\N
59	ATI TECHNOLOGIES, INC.	ATi
60	AURORA IMPEX CORPORATION	\N
61	AUSTIN COMPUTER SYSTEMS	\N
63	AVT INDUSTRIAL, LTD.	\N
64	AXIK COMPUTER, INC.	\N
67	Accumos	\N
68	ADDONICS TECHNOLOGIES, INC.	Addonics
69	Ahead	\N
71	Alcor	\N
73	ATMEL CORPORATION	Atmel
74	AVANCE LOGIC, INC.	Avance Logic
75	AWARD SOFTWARE INTERNATIONAL, INC.	Award
76	BASE SYSTEMS, INC.	\N
78	BEAVER COMPUTER CORPORATION	\N
79	BEC COMPUTER ENTERPRISE	\N
82	BIOSTAR MICROTECH INTERNATIONAL CORPORATION	Biostar
83	BJMT TECHNOLOGY CORPORATION	\N
85	BUFFALO PRODUCTS, INC.	\N
87	CACHE COMPUTERS, INC.	\N
89	CAF TECHNOLOGY, INC.	\N
90	CALIBER COMPUTER	\N
92	CARDINAL TECHNOLOGIES, INC.	\N
94	CHEERFUL INTERNATIONAL CORPORATION	\N
95	CHICONY, INC.	Chicony
96	CLUB AMERICAN TECHNOLOGIES, INC.	\N
97	CMS ENHANCEMENTS, INC.	\N
98	COLUMBIA DATA PRODUCTS, INC.	\N
99	COMMODORE BUSINESS MACHINES, INC.	Commodore
100	COMPAQ COMPUTER CORPORATION	Compaq
101	COMPUADD, INC.	\N
103	COMPULINK RESEARCH, INC.	\N
104	COMPUSYSTEMS, INC.	\N
106	CONCORD OFFICE AUTOMATION INDUSTRIAL (HK),, LTD.	\N
108	CORDATA TECHNOLOGIES	\N
109	CORE INTERNATIONAL, INC.	\N
110	CORE PACIFIC ELECTRONICS, INC.	\N
111	CORONA COMPUTER CORPORATION	\N
112	CREATIVE ELECTRONIC, INC.	\N
113	CRYSTAL COMPUTER SYSTEMS	\N
115	CT CONTINENTAL CORPORATION	\N
117	CYBLE TECHNOLOGY, INC.	\N
118	CHIPS & TECHNOLOGIES	Chips & Technologies
119	CIRRUS LOGIC, INC.	Cirrus Logic
120	Cypress	\N
121	Cyrix	\N
122	DASH COMPUTER, INC.	\N
123	DATA BUSINESS SYSTEMS	\N
125	DATAVAN INTERNATIONAL CORPORATION	\N
126	DAYTON MICRO	\N
129	DECISION COMPUTER INTERNATIONAL CO., LTD.	\N
130	DEICO ELECTRONICS, INC.	\N
131	DELDUCA SYSTEMS, INC.	\N
132	DELL COMPUTER CORPORATION	Dell
134	DESKSTATION TECHNOLOGY, INC.	\N
135	DESTINY COMPUTERS, INC.	\N
136	DIAMOND FLOWER, INC.	DFI
139	DIGITAL SCIENTIFIC RESEARCH, INC.	\N
138	DIGITAL EQUIPMENT CORPORATION	DEC
93	CHAINTECH COMPUTER COMPANY, LTD.	Chaintech
140	DIVERSIFIED TECHNOLOGY	\N
77	BCM ADVANCED RESEARCH, INC.	BCM
137	DIAMOND MULTIMEDIA SYSTEMS, INC.	Diamond
2	AAEON TECHNOLOGY, INC.	AAEON Technology
124	DATAEXPERT CORPORATION	DataExpert
8	ACHITEC CORPORATION, LTD.	Achitec
53	ASUS COMPUTER INTERNATIONAL	ASUS
102	Compudyne, Inc.	Compudyne
107	Contaq	\N
142	DYNA MICRO, INC.	\N
65	AXIOM TECHNOLOGY, INC.	AXIOM Tech
11	ACQUTEK CORPORATION	Acqutek
21	ADVANTECH CO., LTD.	Advantech
23	ALARIS, INC.	Alaris
43	ARCHE TECHNOLOGIES, INC.	Arche
39	AORTA SYSTEMS CORPORATION	Asus (former name)
91	CALIFORNIA GRAPHICS & PERIPHERALS, INC.	California Graphics
80	BEK-TRONIC TECHNOLOGY, INC.	BEK-tronic
81	BETHEL ELECTRONICS INTERNATIONAL, INC.	Bethel
84	BOSER TECHNOLOGY CO., LTD.	Boser
88	CACHING TECH CORPORATION	Caching Tech Corp.
105	COMPUTREND SYSTEMS, INC.	Computrend
29	AMERICAN DIGICOM CORPORATION	Digicom
66	AZZA (Pro-Team/Proteam Computer Corp.)	Azza
55	ATC/UNITRON COMPUTERS & COMPUTER PARTS	ATC/Unitron
128	Leo Systems Inc. (FIC)	\N
143	EASYDATA COMPUTER PRODUCTS	\N
144	EDE ELECTRONIC LABORATORY SERVICES	\N
147	EISA TECH CORPORATION	\N
148	ELISA TECHNOLOGY, INC.	\N
307	PARCORP, INC	\N
149	ELITEGROUP COMPUTER SYSTEMS, INC.	ECS
150	EMPAC INTERNATIONAL	\N
155	ETEQ MICROSYSTEMS, INC.	ETEQ
156	EURONE	\N
157	EVEREX SYSTEMS, INC.	\N
158	EVERGREEN SYSTEMS, INC.	\N
160	EXCLUSIVE MAINBOARD PRODUCTS, INC.	\N
161	Efar Microsystems	\N
162	FAIR FRIEND ENTERPRISE COMPANY, LTD.	\N
163	FAMOUS TECHNOLOGY CO., LTD.	\N
164	FIRST INTERNATIONAL COMPUTER, INC.	FIC
165	FLASH TECH, INC.	\N
167	FOCUS INFORMATION SYSTEMS, INC.	\N
169	FORCOM TECHNOLOGY CORPORATION	\N
171	FORTRESS SYSTEMS INTERNATIONAL	\N
174	FRONTIER INDUSTRIAL, INC.	\N
175	FUJIKAMA  USA, INC.	\N
176	G-2	\N
177	GCH SYSTEMS, INC.	\N
179	GENESYS ATE, INC.	\N
181	GESPAC	\N
182	GIGA-BYTE TECHNOLOGY CO., LTD.	Gigabyte
185	HAUPPAUGE COMPUTER WORKS, INC.	\N
186	HAWK COMPUTERS	\N
187	HEADLAND TECHNOLOGY, INC.	\N
188	HEDAKA	\N
189	HEWLETT-PACKARD COMPANY	HP
190	HOKKINS SYSTEMATION, INC.	\N
191	HORNET TECHNOLOGY CORPORATION	\N
192	HYUNDAI ELECTRONICS, INC.	Hyundai
193	Headland	\N
194	HiNT	\N
195	Highland	\N
197	IBM CORPORATION	IBM
198	ICL	\N
199	IDT	\N
200	ILON USA, INC.	\N
201	IMS	\N
205	INSIDE TECHNOLOGY A/S	\N
206	INTEGRATED WORKSTATIONS, INC.	\N
209	INTERCOMP, INC.	\N
210	INTERLOGIC INDUSTRIES	\N
211	INTERNATIONAL INSTRUMENTATION, INC.	\N
213	ISA/EISA, INC.	\N
214	ITT CORPORATION	\N
216	Intercomp	\N
217	J&J TECHNOLOGY, INC.	\N
223	JC INFORMATION SYSTEMS CORPORATION	\N
224	JETPRO INFOTECH COMPANY, LTD.	\N
225	JOINDATA SYSTEMS, INC.	\N
226	JOY SYSTEMS, INC.	\N
227	JPN CORPORATION	\N
231	KILA SYSTEMS	\N
233	KLH	\N
234	KOUWELL ELECTRONIC CORPORATION	\N
235	KRIS TECHNOLOGIES	\N
237	L & K MICRO SUPPLY, INC.	\N
240	LCI	\N
241	LEADING EDGE PRODUCTS, INC.	\N
243	LION COMPUTERS, INC.	\N
244	LONGBAR DEVELOPMENT LIMITED	\N
247	MAGITRONICS	\N
248	MAGNAVOX	\N
249	MAGUS DATA TECHNOLOGY, INC.	\N
250	MANDAX COMPUTER, INC.	\N
251	MECER CORPORATION	\N
252	MECTEL INTERNATIONAL, INC.	\N
253	MEMOREX TELEX CORPORATION	\N
254	MIC	\N
255	MICRO COMPUTER SYSTEMS CORPORATION	\N
256	MICRO EQUIPMENT CORPORATION	\N
257	MICRO EXPRESS, INC.	\N
258	MICRO-STAR INTERNATIONAL CO., LTD.	MSI
259	MICROMATION TECHNOLOGY, INC.	\N
260	MICROMEDIA TECHNOLOGIES, INC.	\N
261	MICROMODULE SYSTEMS, INC.	\N
262	MICRONICS COMPUTERS, INC.	Micronics
263	MICROWAY, INC.	\N
264	MICRO WISE, INC.	\N
265	MINI MICRO SUPPLY COMPANY	\N
266	MINTA TECHNOLOGIES, CO.	\N
269	MNC INTERNATIONAL, INC.	\N
270	MODULAR CIRCUIT TECHNOLOGY	\N
271	MONOLITHIC SYSTEMS, INC. (COLORADO MSI),	\N
272	MORSE TECHNOLOGIES, INC.	Morse
273	MOTOROLA, INC.	Motorola
274	MPL	\N
275	MULTI-MICRO SYSTEMS, INC.	\N
276	MULTI-DIMENSION RESEARCH, INC.	\N
277	MULTI-TECH SYSTEMS, INC.	\N
278	MULTIBEST INDUSTRIAL & MANUFACTURING, INC.	\N
280	Macronix	\N
281	Matrox	\N
284	Mr. BIOS	\N
285	NASCENT TECHNOLOGY, INC.	\N
152	EPSON, INC.	Epson
286	NBI	\N
232	KINGSTON TECHNOLOGY CORPORATION	Kingston
215	IWILL CORPORATION	Iwill
145	EDOM INTERNATIONAL CORPORATION	Edom/WinTech
218	J-BOND COMPUTER SYSTEMS CORPORATION	J-Bond
245	LUCKY STAR TECHNOLOGY CO., LTD.	Lucky Star
230	KADATCO CO., LTD.	Aristo
178	GEMLIGHT COMPUTER LTD.	Gemlight
239	LASER COMPUTER, INC.	Laser
279	MYLEX CORPORATION	Mylex
229	JUKO LABORATORIES, LTD.	JUKO
287	NCR Corporation	NCR
184	GVC Technologies, Inc.	GVC
183	GoldStar	\N
268	Mitsubishi Electronics	Mitsubishi
168	FONG KAI INDUSTRIAL CO.	Fong Kai
246	M TECHNOLOGY, INC.	M-Tech (MTI)/Rise
289	NEC TECHNOLOGIES, INC.	NEC
290	NETPOWER	\N
291	NEWTON NET TECHNOLOGY, INC.	\N
292	NEXGEN	Nexgen
146	EFA CORPORATION	EFA
153	ETC COMPUTER, INC.	ETC
180	GENOA SYSTEMS CORPORATION	Genoa
196	I-BUS/IBUS	\N
222	JATON CORPORATION	Jaton
219	Jetway/J-MARK COMPUTER CORPORATION	Jetway
166	FLYTECH GROUP INTERNATIONAL	Flytech
236	KT TECHNOLOGY PTE., LTD.	KT Technology
202	INDUSTRIAL COMPUTER SOURCE	ICS
221	JAMICON CORPORATION	Jamicon
293	NIAGARA SMD TECHNOLOGY, INC.	\N
294	NIC TECHNOLOGY, INC.	\N
296	NOVACOR, INC.	\N
297	NOVAS	\N
300	OGIVAR, INC.	\N
302	OMNITEL, INC.	\N
303	OPTI, INC.	OPTi
207	Intel Corporation	Intel
212	IPC CORPORATION, LTD.	IPC
220	JAMECO ELECTRONIC COMPONENTS	Jameco
304	ORCHID TECHNOLOGY	\N
305	OAK TECHNOLOGY	Oak
306	PACKARD BELL	Packard Bell
308	PC & C RESEARCH CORPORATION	\N
309	PC BRAND	\N
310	PC CALC, INC.	\N
312	PC WARE INTERNATIONAL, INC.	\N
313	PC WAVE, INC.	\N
317	PHILIPS CONSUMER ELECTRONICS, CO.	Philips
319	PIONEER COMPUTER, INC.	\N
320	PIONEX TECHNOLOGIES, INC.	\N
321	POLOTEC, INC.	\N
322	POSITIVE CORPORATION	\N
324	PRECISION AMERICA, INC.	\N
325	PROGEN TECHNOLOGY, INC.	\N
326	PROGRESSIVE PERIPHERALS, INC.	\N
327	PROLINK COMPUTER, INC.	\N
328	PROSYS	\N
330	PHOENIX TECHNOLOGIES, LTD.	Phoenix
331	QDI COMPUTER, INC.	QDI
332	QUALOGY, INC.	\N
333	QUICK TECHNOLOGY, INC.	\N
334	QUICKPATH SYSTEMS, INC.	\N
335	QUADTEL	Quadtel
336	RADISYS CORPORATION	\N
337	RAKOA COMPUTER CO., LTD.	\N
338	RAVEN SERVICE WORKS	\N
340	RELIALOGIC CORPORATION PRIVATE, LTD.	\N
341	REPLY CORPORATION	\N
342	RINGO TECHNOLOGY, INC.	\N
343	ROBOTECH, INC.	\N
344	S3 GRAPHICS, LTD.	S3
345	SAMSUNG ELECTRONICS, INC.	Samsung
346	SANTA CLARA SYSTEMS, INC.	\N
348	SARC	\N
349	SCI SYSTEMS, INC.	\N
351	SEE-THRU DATA SYSTEMS, LTD.	\N
353	SHUTTLE COMPUTER INTERNATIONAL, INC.	Shuttle
355	SIIG, INC.	\N
357	SILICON VALLEY COMPUTER, INC.	\N
358	SILICON VALLEY TECHNOLOGY	\N
359	SIMA TECHNOLOGY CO., LTD.	\N
360	SINGA	\N
361	SIO	\N
362	SIREX	\N
363	SKYWELL TECHNOLOGY CORPORATION, LTD.	\N
364	SMD	\N
365	SOFTSYS COMPUTER CENTERS, INC.	\N
366	SOLECTEK COMPUTER SUPPLY, INC.	\N
368	SOTA TECHNOLOGY, INC.	\N
369	SOYO COMPUTER CO., LTD.	Soyo
370	SPRING CIRCLE COMPUTER, INC.	\N
372	SPRITE, INC.	\N
374	STANDARD BRAND PRODUCTS	\N
378	SYNTAX	\N
379	SILICON INTEGRATED SYSTEMS	SiS
380	Suntac	\N
381	Symphony Labs	\N
382	TAI HSIN GROUP	\N
384	TANDON CORPORATION	\N
385	TANDY/RADIO SHACK	Tandy
386	TARGET MICRO	\N
387	TECHMEDIA COMPUTER SYSTEMS CORPORATION	\N
393	TEXAS INSTRUMENTS	Texas Instruments
394	TEXAS MICRO, INC.	\N
396	TOP MICROSYSTEMS, INC.	\N
397	TORONTO MICROELECTRONICS, INC.	\N
399	TOUCH, INC.	\N
400	TRENTON TECHNOLOGY, INC.	\N
405	TRIDENT MICROSYSTEMS	Trident
406	TSENG LABORATORIES, INC.	Tseng Labs
407	U.S. INTEGRATED TECHNOLOGIES, INC.	\N
408	UNITED MICROELECTRONICS CORPORATION	UMC
410	UNISYS CORPORATION	Unisys
413	UPDATE TECHNOLOGY, INC.	\N
414	Unichip	\N
417	VIA TECHNOLOGIES, INC.	VIA
419	VISION TECHNOLOGIES	\N
420	VISIONEX	\N
421	VITALCOM INTERNATIONAL, INC.	\N
422	VLSI TECHNOLOGY, INC.	VLSI
423	VTECH INDUSTRIES, INC.	VTech
424	VTI	\N
425	WELLS AMERICAN CORPORATION	\N
426	WESTERN DIGITAL CORPORATION	Western Digital
428	WINCAL TECHNOLOGY CORPORATION	\N
429	WISEWARE COMPUTER, INC.	\N
404	TYAN COMPUTER CORPORATION	Tyan
430	WUGO (DELL),	\N
431	WYSE TECHNOLOGY, INC.	Wyse
401	TRIGEM MICROSYSTEMS, INC.	TriGem
314	PC'S LIMITED, INC.	PC’s Limited (Dell)
299	OCEAN INFORMATION SYSTEMS, INC.	Octek
403	TWINHEAD INTERNATIONAL CORPORATION	Twinhead
315	PEACOCK AG	Peacock
323	POWERTECH ELECTRONICS, INC.	PowerTech
318	PINE TECHNOLOGY	Pine Technology
295	NORTHGATE COMPUTER SYSTEMS, INC.	Northgate Computer Systems
416	Vextrec Technology Inc.	Vextrec
301	Olivetti S.p.A.	Olivetti
339	RECTRON ELECTRONIC ENTERPRISES, INC.	Rectron
392	TELEVIDEO SYSTEMS, INC.	TeleVideo (TVS)
347	SANYO ELECTRIC CO., LTD.	Sanyo
398	TOTEM TECHNOLOGY CO., LTD.	Totem
432	XENER	\N
433	XINETRON, INC.	\N
435	YOUTH KEEP ENTERPRISES, LTD.	\N
437	ZENTECH CORPORATION	\N
438	ZENY COMPUTERS	\N
440	ZETA INDUSTRIAL CO., LTD.	\N
316	PEAKTRON COMPUTER, INC.	Peaktron
329	PURETEK INDUSTRIAL CO., LTD.	PureTek
356	SILICON STAR INTERNATIONAL, INC. (old name MSI)	\N
376	SUPER MICRO COMPUTER	Supermicro
383	TAKEN CORPORATION	Taken
411	UNITRON COMPUTER, INC.	Unitron
427	WIN LAN ENTERPRISE CO., LTD.	Win Lan
373	SQUARE ONE INDUSTRIES, INC.	Square One Ind.
375	SUK JUNG ELECTRONIC CO., LTD.	Suk Jung
371	SPRINT MANUFACTURING CORPORATION	Sprint Manuf. Corp.
443	ZODIAC TECHNOLOGIES	\N
444	ZYTEX COMPUTERS, INC.	\N
445	ZILOG, INC.	Zilog
446	WEITEK CORPORATION	Weitek
450	TIDALPOWER TECHNOLOGY Inc.	\N
451	LEADMAN ELECTRONICS Inc.	\N
452	BIOTEQ	\N
453	ESS TECHNOLOGY Inc.	ESS
718	ETA	\N
454	REALTEK SEMICONDUCTOR CORP.	Realtek
581	IEI	\N
402	TULIP COMPUTERS	Tulip Computers
455	CREATIVE TECHNOLOGY LTD.	Creative
456	CRYSTAL SEMICONDUCTOR CORP.	Crystal
457	MICOMS SYSTEM PTE LTD.	\N
442	ZIDA TECHNOLOGIES, LTD.	Zida
458	ACORP INTERNATIONAL SRL	Acorp
459	FUTURE TECHNOLOGY DEVICES INTERNATIONAL	FTDI
460	AMSTRAD	Amstrad
461	TOSHIBA CORPORATION	Toshiba
462	YAMAHA	Yamaha
464	WINBOND ELECTRONICS CORP.	Winbond
170	FOREX COMPUTER CORPORATION	Forex
20	ADVANCED LOGIC RESEARCH, INC.	ALR
466	DAEWOO TELECOM LTD.	Daewoo
467	PALIT MICROSYSTEMS, INC.	Palit
468	TAIWAN TURBO TECHNOLOGY CO., LTD.	\N
469	TRIPLE D INTERNATIONAL INC.	Triple D International
471	Nvidia Corporation	Nvidia
472	3DFX INTERACTIVE	3dfx
470	C-MEDIA ELECTRONICS, INC.	C-Media
474	Solutions	Solutions
475	Aureal Semiconductor Inc	Aureal
476	SigmaTel	\N
478	PC PARTNER GROUP LIMITED	PCPartner
479	PARADISE SYSTEMS, INC	Paradise
480	Alliance Semiconductor	Alliance
481	GMX, INC.	GMX, INC.
482	Adaptec	\N
484	IC Ensemble Inc	IC Ensemble
486	Silicon Motion	SMI
487	Whizpro Inc.	Whizpro
489	Discrete	Discrete
490	UTron/HiNT	UTron/HiNT
491	PLATO TECHNOLOGY CO., LTD.	\N
493	GLOBAL CIRCUIT TECHNOLOGY INC.	GCT
494	Joss Technology LTD.	Joss Tech
367	SOLTEK COMPUTER, INC.	Soltek
391	TEKRAM TECHNOLOGY CO., LTD.	Tekram
495	ARK Logic, Inc	ARK Logic
496	NeoMagic Corporation	NeoMagic
497	Integrated Information Technology, Inc.	IIT
498	Rendition, Inc.	Rendition
477	Jetway Computer Corp.	Jetway(old)
501	ASRock Inc.	ASRock
502	Medion AG	Medion
483	AcerOpen Inc.	AOpen
503	Electronic Solutions Associates	ESA
507	ZyMOS Corporation/Appian Technology, Inc	ZyMOS/Appian
508	ACT Electronics Ltd	ACT
509	Panda	\N
510	Beyond	Beyond
512	Access Methods Incorporated (Flying Triumph)	Access Methods
513	Uniron	Uniron
514	MG	MG
515	CMP Enterprise Co	CMP
516	CDTek	CDTek
517	Win-Win Electronic Co	Win-Win Electronic Co
518	Pyramid	\N
519	Wearnes	\N
541	(Mixed Brands)	\N
434	YOUNG MICRO SYSTEMS, INC.	Young Micro Systems
352	SERITECH ENTERPRISE Co., Ltd.	Seritech
521	DM&P Electronics	DM&P
522	Rise Technology	Rise
523	National Semiconductor	\N
524	Sunlogix	\N
526	Faraday	\N
527	PAN-ASIA	\N
528	Tamarack	\N
529	LSI Logic	LSI
530	My-Com	\N
531	Amstrad	\N
532	SystemSoft	\N
533	Lattice	\N
534	Elite	\N
535	Citygate	\N
536	Golden Star Technology Inc	\N
537	LIN Data Corporation	Lin Data Corp
538	Impression	\N
525	VDL	\N
539	Up To Date Technology Inc.	UTD
540	Micral	\N
52	AST RESEARCH, INC.	AST
542	Deep	\N
543	Infinity	\N
544	U-Board Computerize Co. Ltd.	U-Board
203	INFOMATIC POWER SYSTEMS CORPORATION (IPX),	Infomatic Power Systems
545	Kaimei Electronic Corp	Kaimei
546	STMicroelectronics	ST-remove
547	Analog Devices	\N
548	ANIGMA	Anigma
549	Fujitsu Limited	Fujitsu
550	Intersil, Inc	Intersil
465	STMicroelectronics N.V.	ST
354	Siemens Nixdorf Informationssysteme, AG	Siemens Nixdorf
551	Siemens AG	Siemens
447	FULL YES INDUSTRIAL CORP	Full Yes
436	Zenith Data Systems	\N
553	OKI Electric Industry Co., Ltd.	OKI
441	ZF Microsystems	ZF Micro
504	USSR	\N
554	Matra-Harris Semiconductors	MHS
555	ULi Electronics Incorporated	ULi
506	ADI2	ADI2
473	ADI	ADI
557	Asian Digital Corporation	ADC
558	ForteMedia	\N
559	A-Win (ACE Project)	A-WIN
560	ENPC	ENPC
561	Foxconn Technology Group	Foxconn
562	Hightech Information Systems	HIS
563	Sunnylab	\N
565	Schneider	\N
566	Long State	\N
151	EPOX COMPUTER CO., LTD.	EPoX/ProNiX
172	FREE COMPUTER TECHNOLOGY, INC.	Freetech/Flexus
463	Lucky Tech/Shining Yuan Enterprises	Lucky Tech
520	Modula Tech Co	Modula Tech
485	NEWTECH	NewTech/SMT
564	Nexcom International Co.	NexCom
505	PROTECH SYSTEMS	Protech
267	MITAC INTERNATIONAL CORPORATION	MiTAC/Trigon
499	FORMOSA INDUSTRIAL COMPUTER INC.	Formosa Industrial
568	Ford Lian	Ford Lian
569	RedFox	\N
377	SUPERPOWER COMPUTER CO., LTD.	SuperPower
570	S&D	\N
571	Zaapa	\N
572	Dunson Electronics	\N
573	Protac	\N
574	TK	\N
575	PRAgue Electronics FActory	PRAEFA
576	CX Technology Inc.	\N
577	Transcend	\N
578	Labway Computer Co.	\N
579	Advanced Linux Design Ltd	ALD
580	MATSONIC	Matsonic
492	Sowah Research	\N
556	TAIWAN COMMATE COMPUTER INC	Commel / Commate
582	Chyang Fun Industries	CFI
584	R.P.T. Intergroups International Ltd.	RPTI
586	Micro Leader Enterprises	MLE
587	Lite-On	\N
588	ASEM	\N
589	Xsonictech	Xsonic
590	Copam	\N
591	MICROSOFT CORPORATION	Microsoft
592	DIGITAL RESEARCH, INC.	Digital Research
593	NOVELL, INC.	Novell
594	CALDERA, INC.	Caldera
595	Viglen	\N
596	Gateway 2000	Gateway
597	MicroDesign GmbH	MicroDesign
598	Atari Inc.	Atari
599	Corvalent Corporation	Corvalent
600	Vobis	\N
602	Ability Technologies	\N
603	Elpina	\N
604	JUMPtec	\N
605	Sigma Computer Corp	Sigma
606	Altos	\N
608	ZENITH	Zenith
609	Consolidated Marketing Corp.	CMC
610	AZtech	\N
611	Dart	Dart
612	Reliance Computer Corp./ServerWorks	ServerWorks
613	Hitachi	\N
614	Sony	\N
615	SMSC	\N
616	Accos Enterprise Co.	Accos
617	Acer Sertek Inc.	Sertek
618	Mirage (reference to Achme sometimes)	Mirage
619	Acrosser Technology	Acrosser
620	Adcom	\N
621	ADLink Technology Inc.	ADLink
141	DTK COMPUTER, INC. (Datatech Enterprises Co./former Advance Creative Computer Corp.)	DTK
19	ADVANCED INTEGRATION RESEARCH, INC. aka UHC	Advanced Integration Research (AIR)
622	Advanced Scientific Corp.	\N
623	Aeontech International Co.	Aeontech
624	Aeton Technology	Aeton
625	Aewin	\N
626	Agama	\N
627	AIC Japan	AIC
628	Albatron	\N
629	Allwell (Chou Chin)	\N
630	Ally	\N
631	Alpha-Top Corp.	\N
632	Alptech Logic Products Inc.	\N
633	Amaquest/Anson/Ansoon Technology Co.	\N
32	AMERICAN PREDATOR CORPORATION	APC
634	Amptek Technology Co.Ltd.	\N
635	Angel (SYNC)	\N
636	Angine Ltd.	\N
637	Anpro	\N
638	APLUS	\N
639	Applied Component Technology Corp.	\N
583	ARBOR Technology Corp	Arbor
640	Arcom	\N
641	Arima	\N
642	Arrgo Systems Inc.	\N
643	Artdex Computer Corp.	\N
644	Artis	\N
645	Advanced Semiconductor Engineering	ASE
647	Askey Computer Corp.	Askey
648	ASMT Corp.	\N
649	Astra Communication Corp.	\N
650	Assem	\N
651	Pegatron	\N
652	Aten International Co.Ltd.	\N
653	Atherton Technology	\N
654	Atoz International	\N
655	Auhua Electronics Co. Ltd.	Auhua
62	AUVA COMPUTER, INC. (Autocomputer Co.)	Auva Computer
656	Atima	\N
657	Axis Taiwan	\N
658	Ay Ruey International Co.	\N
659	Azylex Tech	\N
660	BAFO Tech	\N
41	AQUARIUS SYSTEMS, INC.	Aquarius Systems/BCOM
661	Beneon Corp.	\N
662	Bestek Computer Co.	\N
663	Bharat Electronics	\N
664	Brain Power Co.	\N
665	Britek	\N
667	Calcomp	\N
668	CAM Enterprise Inc.	\N
669	Canta	\N
670	Cantron	\N
671	Cantta Enterprises Co.	\N
672	Cardex/Gainward	\N
673	Cast Technology Inc.	\N
675	Chaining Computer and Communication	\N
677	Chaplet	\N
678	China Semiconductor Corp.	\N
679	Chung Yu Electronics Co.	\N
680	Chuntex Elex.	\N
681	Clevo	\N
682	Cloud	\N
683	CMT-Taiwan Inc.	\N
684	Codegen Technology Co.	\N
685	Concierge Co.	\N
686	Contec	\N
687	Cordial Far East Corp.	\N
688	Cosmotech Computer Corp.	\N
689	CoxsWain Technology Co. Ltd.	\N
666	C.P. Technology Co. /PowerColor	\N
690	CReTE Systems Inc.	\N
691	CTL Corp	\N
692	CTX	\N
693	Cybernet	\N
694	Daesun	\N
695	DAIC Microsystems	\N
696	Darter Technology	Darter
697	Datacom Technology Co.	\N
698	Fungus	\N
699	Dataworld International Corp.	\N
601	Delta Technologies/Delta Electronics Inc./Delta Systems	Delta
133	DENSITRON CORPORATION	Densitron
700	Deson Trade Inc.	\N
701	Dimensions Electronics Co.	\N
702	Ding Ying	\N
703	Dkine Enterprise	\N
704	Dolch Computer Systems	\N
585	Iston Computer Corp.	Iston
674	Japan Cere'Bro Computers Inc.	CBR
567	SNOBOL INDUSTRIAL CORP.	Snobol
705	Domex Technology Corp.	Domex (DTC)
706	Dongwha	\N
707	DSG Technology Inc.	\N
708	DT Research Inc.	\N
709	Dual Technology Corp.	Dual Tech
710	Dynasty Computer	\N
711	E-San Electronic Co.	\N
712	Eagle Computer Technology Co.	\N
713	Ecel Systems Corp.	\N
714	Elechands International Co.	\N
715	Elonex	\N
716	ENMIC	\N
717	ESPCo	\N
719	Evalue Tech	\N
720	Evate T & C	\N
721	EVGA	\N
722	EVOC	\N
723	Expen Tech	\N
724	Expert Electronics Corp.	\N
725	Express	\N
727	Fantas Technology Co.	Fantas
726	Fastfame Computer Co.	\N
728	Other	\N
729	Firich Enterprises Co.	\N
730	Flagpoint	\N
731	Force System Inc.	\N
732	Four Star Computer Co.	\N
733	Foxen	\N
734	Freedom Data Technology Co.	\N
735	FuguTech	\N
736	Fukunaga	\N
737	Funtech Entertainment Corp.	\N
738	Gain Technology Co.	\N
739	Garnet International Corp.	\N
740	relabeler (jetway/ADI) GB486 Computer Systems?	\N
741	GBM	\N
742	<generic code>	\N
743	Giantec Technology Corp.	\N
744	Gisol	\N
745	GIT (unconfirmed)	\N
746	Gleem Industries Co.	\N
747	Globe Legate	\N
748	GNS Technologies Inc.	\N
749	Gold Rain	\N
750	Golden Horse Computer Co.	\N
751	Golden Way Electronic Corp.	\N
752	Grandtek	\N
753	Great Electronics Corp.	\N
754	Great Tek Corp.	\N
755	Great Wall	\N
756	Green Taiwan Computer Co.	\N
757	GSE	\N
758	GTK	\N
676	Chang Tseng Corp.(Sono Computer)	HCC/Sono Computer
759	Hedonic	\N
761	Hi-Com Industrial Co. Ltd.	\N
762	High Ability Computer Co.	\N
763	High Large Corp.	\N
764	HMC	\N
765	Hong Lin	\N
766	Honotron Corp.	\N
767	Howatek	\N
768	HTR Asia Pacific Inc.	\N
769	Huawei	\N
770	EONtronics	\N
771	Eupa Computer	\N
772	Hyosan	\N
773	Hyosung	\N
774	IA Link	\N
388	TECHNOLAND, INC.	IBASE/TechnoLand
775	IBS	\N
776	ICON	\N
777	ICP Electronics Inc.	ICP
778	iDOT	\N
779	Ikon Technologies Corp.	\N
780	Imageview	\N
781	Imax	\N
204	INFORMTECH INTERNATIONAL, INC.	Informtech
783	Inlog Micro Systems Co	\N
784	Innovance	\N
785	Integrated Technology Express	\N
786	Interplanetary Information Co.	\N
787	Inventa (Twn)	\N
788	Inventec	\N
789	IOI	\N
790	IPAC	\N
791	Ipex ITG International Ltd.	\N
792	IPOX Tech.	\N
793	J Shin's Kingdom	\N
794	J-Square	\N
795	J-Star	\N
796	Jackson Dai Industrial Co.	\N
797	Jama	\N
798	Janich & Klass	\N
799	Japan Digital	\N
800	Jean	\N
801	Jeruo	\N
802	Jetta	\N
803	JMI	\N
804	Join Inc.	\N
805	Kapok	\N
806	Kasan	\N
807	Kentech Electronic	\N
808	Key Win Electronics	\N
809	Khi Way Enterprise Co.	\N
810	King Fair	\N
811	King Young Technology	\N
812	Kingstone	\N
813	KINPO Electronic	\N
814	Kiwi	\N
815	Korea	\N
816	Kou Sheng Computer Co.	\N
817	Kuei Hao Industrial Co.	\N
818	Lantic Inc.	\N
819	Lapro Corp.	\N
820	Leadtek	\N
821	Lian Guan	\N
822	Lica	\N
823	LiPPERT Automationstechnik	\N
824	Logisys	\N
825	LTL	\N
826	Lucky Tiger	\N
827	Lung Hwa Electronics Co.	Lung Hwa
828	Lutron Electronic Enterprise Co.	\N
829	M.I.(Sungwon)	\N
830	Macro Mate Corp.	Macro Mate
831	Macrotek International Corp.	Macrotek
832	Magic-Pro	\N
833	Magtron Technology.	\N
834	Manufacturing Technology Resources Inc.	\N
835	Maruda	\N
836	MAT Technologies Ltd.	\N
837	Maxnav/Maxtech	\N
838	Maxtium Computer	\N
839	Mercury Computer Corp.	\N
782	Industrial Tech. Research Ins. (ITRI)	\N
840	Leotec	\N
841	Micro Meter	\N
842	Microbus	\N
843	Microgram	\N
844	Micron Design Technology Ltd.	\N
845	Microsys	\N
846	Mida	\N
847	Mirle Automation Corp.	\N
848	Mits Technology Co.	\N
849	Miyuki	\N
850	Monterey International	\N
851	Movita	\N
852	Muse Technology Co. Ltd.	\N
853	Mustek	\N
854	Myung Shig	\N
855	Nasdaq	\N
856	National Advantages Computer Inc	\N
857	Needs System Development Co.	\N
858	Neon Tech	\N
859	Netcon Co.	\N
860	New Comm Technology Co.	\N
861	New Dimension	\N
862	New Paradise Enterprise Co.	\N
863	Nexar	\N
864	NMC	\N
865	Norm Advanced Technology Corp.	\N
866	Notestar	\N
867	Nuseed Technology Inc	\N
868	Optimum	\N
869	Oricom	\N
870	Orientech Electronics Corp.	\N
871	Orlycon Enterprise Co.	\N
872	OVIS Enterprises Co.	\N
873	P.J.	\N
874	Pacific Information Inc.	\N
875	Padalin International Development	\N
876	Pai Jung Electronic Ind.	Pai Jung
877	Palmax	\N
878	Paoku P & C Co	\N
879	PC Direct Technology Co.	\N
311	PC CHIPS MANUFACTURING, LTD. (Hsin Tech)	PCChips
880	NTK Computer	\N
881	Pionix	\N
882	Portwell Infotech Inc.	Portwell
883	President Technology Inc	\N
884	Procomp Informatics	\N
885	Prodisti Co.	\N
886	Project Information Company Ltd.	\N
887	Protronic Enterprises Corp.	\N
888	Proware Technology Corp.	\N
889	Quanta Computer Inc.(Twn)	Quanta
890	Random Technology Inc.	\N
891	Rever Computer Inc.	\N
892	RioWorks Solutions Inc.	RioWorks Solutions
893	Rock Technology Ltd.	\N
894	Reason Technologies	\N
895	RSAP Technology	\N
500	San Li Technology Ltd.	San Li
896	Seahill Technology Co.	\N
897	Seal International Corp.	\N
760	Heisei	\N
898	Seavo	\N
899	Senor Science Co.	\N
900	SerComm Corp.	\N
901	Shenzhen Jiehe	\N
902	ShenZhen Zeling	\N
903	Silver Bally Inc.	\N
904	Sky Computer	\N
905	Smart D & M Technology	\N
906	Softek Systems Co.	\N
907	Source Of Computer Co.	\N
908	Singdak Electronic	\N
909	Spring Hill	\N
910	Storage System Inc.	\N
911	Sun's Electronics	\N
912	Sunflower Systems Inc.	\N
913	Sunrex Technology Corp.	\N
914	SunTop Computer Systems Corp.	\N
915	Sunvalley	\N
607	Super Grace Electronics	SuperGrace
917	Supertone Electronic Co.	\N
918	Syncus Tech	\N
919	Systex Corp.	\N
920	Syzygia Computer Corp.	\N
921	T & W Electronics	\N
922	T sann Kuen Enterprise	\N
923	Tae IL Media Co Ltd	\N
925	Taiwan Igel Co.	\N
926	Taiwan Turbo Technology Co.	\N
395	Taiwan MyComp Corp./TMC RESEARCH CORP.	TMC/MyComp/MyNix/Megastar
927	Tangent Computer	\N
928	Taste Corp.	\N
929	Tatung	\N
931	Technical House Inc.	\N
930	Technica House	\N
389	TECHNOLOGY POWER ENTERPRISES, INC.	TPE
932	Teco	\N
933	Tekhill	\N
934	Ten Yun Co.	\N
935	TerComputer Technologies Corp.	\N
936	Termtek	\N
937	Teryang Systems Co.	\N
938	Tesco	\N
939	Think Systems	\N
940	Tidal Technologies	\N
941	Top Cyber	\N
942	Top Star	\N
943	Top Thunder Technology Co.	\N
944	Top Union Electronics Corp.	\N
945	Toyen Computer Co.	\N
946	Trigen	\N
947	Tripod Technology Corp.	Tripod
948	TTC Computer Products	\N
949	UFO Systems Inc.	\N
950	Ultima Electronics Corp.	\N
951	Umax	\N
952	Unico	\N
953	Unicorn Computer	Unicorn
954	Unika	\N
955	Union Genius Computer Co.	\N
956	Unicore	\N
957	Uniwill	\N
958	Upgrade Tech Computer	\N
959	UpRight Technology Co.	\N
960	Vector	\N
961	Veridata Electronics Inc.	Veridata Electronics
962	Vision Top Technology	\N
963	Vista Technology Co.	Vista
964	Warp Speed	\N
965	Weal Union Development Ltd.	\N
966	Well Join Industry	WellJoin
967	WeLink Solutions	\N
968	Win Tech Technology Co. Ltd.	\N
969	Wellstar	\N
970	Wen Wha	\N
971	Winco	\N
972	WKK	\N
973	Wuu Lin Electronics Co. Ltd.	\N
974	XO Infotech	\N
975	Yamashita	\N
976	YKM	\N
977	Yoko	\N
978	Yung Lin Technology Corp.	\N
979	Zillion	\N
127	DD & TT ENTERPRISE USA CO.	DD & TT Enterprise
238	LANNER ELECTRONICS, INC.	Lanner Electronics
412	UNIVERSAL SCIENTIFIC INDUSTRIES CO., LTD.	Universal Scientific Ind. (USI)
980	Silicon Graphics	\N
981	Wistron	\N
982	Sun Microsystems	Sun
983	Mentor	\N
984	Sector	\N
985	SIDUS SYSTEMS INC	Sidus
986	Premio	\N
988	Bona Technologies	Bona
242	LEADING TECHNOLOGY INC	LTI
989	SER	\N
987	Transmeta Corporation	Transmeta
990	Nice	\N
991	Domino	\N
916	SuperTek Computer Electronics	SuperTek
646	ASK Tech	ASK
992	FTK	\N
993	AMPEX	\N
994	Logicstar	\N
511	Arstonia/Arstoria	\N
995	USA Integration	\N
350	SEANIX TECHNOLOGY, INC.	Seanix
996	Advance Micro Research	\N
208	Intelligent Data System	\N
997	NSK	\N
998	ARP	\N
999	Lexar	\N
1000	Armas	\N
114	CSS LABORATORIES, INC.	CSS Labs
1001	INVESTRONICA	\N
1002	Freeway	\N
1003	Sunnyvale Labs	\N
159	EVERSOURCE INTERNATIONAL CORPORATION.	Source
1004	Minstaple	\N
1005	SOURCE	\N
1006	Q-Lity/Quanta	\N
1007	Janus	\N
1008	Micro Q	\N
1009	Falcon	\N
1010	US Technologies	\N
552	HARRIS SEMICONDUCTOR	Harris
1012	QinZhong	\N
1013	Trimond (Mitsubishi subsidary)	Trimond
439	ZEOS INTERNATIONAL, LTD.	ZEOS
390	TEKNOR INDUSTRIAL COMPUTERS, INC.	Teknor
1014	Occidental Systems	\N
1015	Sunpronic	\N
1016	ASKA	\N
1017	Spear	\N
1018	Asaki	\N
1019	InterGraph	\N
924	Trang Bow Co., Ltd./Taemung/Fentech	Trang Bow/Trangg Bow
1020	Ambra	\N
1021	Yakumo	\N
1022	Wave Mate	\N
16	ADDTECH RESEARCH, INC.	Addtech
1023	New Union	\N
1024	New Portwell	\N
1025	Tempustech	\N
1026	Flying Triumph	FTC
1027	Canyon	\N
1028	Winco Electronic Co., Ltd.	Winco
1029	LG Semicon	\N
1030	PACKARD	Packard
1031	TOPRO	\N
1032	WinSystems	\N
1033	Klever	\N
\.


--
-- Data for Name: manufacturer_bios_manufacturer_code; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.manufacturer_bios_manufacturer_code (id, manufacturer_id, bios_manufacturer_id, code) FROM stdin;
1	53	75	A0
2	4	75	A1
3	1	75	A2
4	41	75	A3
5	65	75	A5
6	483	75	AB
7	2	75	AC
8	473	75	AN
9	583	75	AP
10	606	75	AQ
11	8	75	AX
12	511	75	AZ
13	82	75	B0
14	82	31	1223
15	3	31	5004
16	2	31	1931
17	1	31	1117
18	559	75	X4
19	4	31	1247
20	5	31	1392
21	616	31	1151
22	7	31	1135
24	617	31	1774
25	8	31	1150
26	618	75	AM
27	458	75	X3
28	11	31	1960
29	619	75	AV
30	619	31	1780
31	473	31	1371
32	620	75	A8
33	621	75	XA
34	141	75	D1
35	141	31	1283
36	141	31	8036
37	19	75	U2
38	622	31	1675
39	21	75	AK
40	21	31	1593
41	623	31	1879
42	624	75	TY
43	625	75	BG
44	626	75	X9
45	626	75	XJ
46	627	75	AL
47	19	31	6064
48	23	31	6328
49	628	75	KH
50	579	75	PK
51	629	75	X8
52	630	75	AO
53	631	31	1182
54	632	31	1404
55	633	75	AD
56	633	31	1762
57	32	31	6423
58	32	31	6155
59	31	31	7803
60	31	31	6730
61	31	31	6782
62	634	31	1242
63	635	75	AY
64	636	31	1140
65	637	31	1827
66	483	31	1770
67	7	75	AW
68	638	75	AE
69	639	31	1175
70	41	31	1112
71	41	31	1914
72	583	31	1939
73	43	31	1462
74	640	75	BI
75	641	75	X5
76	641	31	1262
77	642	31	1355
78	643	31	1493
79	644	75	AI
80	645	31	1652
81	646	75	AT
82	647	75	Q3
83	647	31	1286
84	648	31	1933
85	501	31	1368
86	649	31	1962
87	650	75	AH
88	53	31	1292
89	651	75	P4
90	54	31	1977
91	652	31	1391
92	653	31	1989
93	654	75	XH
94	655	75	SC
95	62	31	1105
96	63	31	8005
97	65	31	1828
98	656	75	FD
99	657	75	AA
100	658	31	1737
101	659	75	BQ
102	66	75	P8
103	660	75	BZ
104	77	75	B3
105	77	31	1540
106	80	75	B1
107	80	31	1759
108	661	31	1948
109	662	31	1204
110	81	75	B5
111	510	75	B6
112	663	75	BF
113	84	75	B2
114	84	31	1588
115	664	31	1847
116	665	75	BB
117	666	31	1471
118	88	31	1190
119	667	75	C6
120	91	75	CV
121	668	31	1929
122	669	75	C7
123	670	75	QL
124	671	31	1965
125	672	75	CS
126	673	31	1666
127	674	75	CH
128	516	31	1435
129	675	31	1707
130	93	75	C3
131	93	31	1128
132	676	31	1998
133	677	75	C5
134	677	31	1108
135	95	75	C2
136	95	31	1116
137	678	31	1982
138	679	31	1954
139	118	31	1190
140	680	31	1126
141	681	75	C1
142	681	31	1178
143	682	75	C8
144	609	75	C4
145	683	31	1794
146	684	31	1936
147	556	75	TP
148	105	75	C9
149	685	31	1988
150	609	31	1608
152	687	31	1671
151	686	75	CL
153	688	31	1246
154	689	31	1367
155	666	75	CZ
156	690	75	CE
157	690	31	1143
158	113	31	6326
159	114	31	6081
160	115	31	1549
161	691	31	6666
162	692	75	CI
163	693	75	XQ
164	694	75	DF
165	466	75	D7
166	695	75	DN
167	696	75	DJ
168	696	31	1221
169	697	31	1472
170	124	75	D0
171	124	31	1107
172	698	75	FD
173	125	75	R3
174	125	31	1612
175	699	31	1229
176	127	75	D5
177	127	31	1297
178	601	75	DL
179	601	31	1184
180	133	75	DB
181	700	31	1961
182	136	75	D4
183	136	31	1211
184	29	75	D3
185	701	31	1963
186	702	75	DD
187	703	31	1132
188	521	31	1986
189	704	31	6105
190	705	75	DI
191	705	31	1222
192	706	75	DC
193	707	31	1700
194	708	31	1260
195	709	75	DE
196	709	31	1304
197	572	31	1160
198	710	31	1106
199	711	31	1708
200	712	31	1526
201	713	31	1451
202	149	75	E1
203	149	31	1131
204	149	31	1218
205	145	31	1379
206	146	75	E3
207	146	31	1281
208	161	31	1783
209	714	31	1810
210	715	75	E6
211	715	31	6407
212	716	75	MC
213	560	75	EC
214	151	75	PA
215	151	31	1519
216	717	75	E4
217	718	75	DP
218	153	75	E2
219	719	75	EO
220	720	75	EI
221	721	75	EV
222	722	75	EJ
223	723	75	E7
224	723	31	1990
225	724	31	1807
226	725	75	E9
228	727	75	FF
229	727	31	1720
230	726	75	FG
227	726	31	1959
231	162	31	1109
232	164	75	F0
233	164	31	1121
234	729	31	1142
235	730	75	CF
236	172	31	1470
237	166	75	F1
238	166	31	1244
239	731	31	1531
240	568	75	F9
241	499	75	F8
242	499	31	1235
243	732	31	1258
244	561	75	FK
245	561	75	FL
246	733	75	FI
247	172	75	F2
248	172	31	1240
249	734	31	1906
250	735	75	F5
251	735	31	1973
252	736	75	FB
253	447	75	F3
254	447	31	1274
255	737	31	1941
256	738	31	1691
257	739	31	1846
258	596	31	8200
260	741	75	GG
261	178	75	G3
262	178	31	1969
263	742	31	9999
264	742	75	00
265	180	31	6156
266	180	31	6165
267	743	31	1172
268	182	75	G0
269	182	31	1199
270	744	75	GC
271	745	75	G1
272	743	75	GA
273	746	31	1585
274	493	75	G9
275	747	75	GE
276	748	31	1195
277	749	75	GF
278	750	31	1546
279	536	31	1155
280	751	31	1197
281	752	75	G6
282	753	31	1440
283	754	31	1490
284	755	75	GB
285	756	31	1974
286	757	75	O3
287	758	75	G2
288	184	75	G5
289	184	31	1259
290	676	75	HJ
291	759	75	H3
292	759	31	1461
293	760	75	HE
294	138	75	D2
295	138	31	1628
296	761	31	1158
297	762	31	1685
298	763	31	1957
299	562	75	HH
300	562	31	1177
301	764	75	H5
302	765	75	HA
303	766	31	1617
304	767	75	H8
305	189	31	6214
306	189	31	6385
307	768	31	1850
308	769	75	HB
309	770	75	EC
310	771	75	TX
311	562	75	HJ
312	353	75	H2
313	353	75	S5
314	353	31	1343
315	772	75	H9
316	773	75	H7
317	192	75	H6
318	774	75	IM
319	388	75	IL
321	775	75	ID
322	196	75	IB
323	776	75	IP
324	777	75	I9
325	777	31	1192
326	778	75	IO
327	779	31	1996
328	780	75	IG
329	781	75	IA
330	782	75	IE
331	782	75	IH
332	204	75	I5
333	783	31	1823
334	783	75	I7
335	784	75	I1
336	785	31	1147
337	210	31	1192
338	786	31	1806
339	787	75	I4
340	788	75	IC
341	788	31	1323
342	789	75	I6
343	790	75	IQ
344	791	31	1920
345	792	75	IX
346	585	31	1630
349	217	75	J7
350	217	31	1796
351	793	75	JE
352	218	75	J3
353	218	31	1353
354	794	75	J5
355	795	75	JA
356	796	31	1275
357	797	75	JK
358	221	75	J2
359	798	75	JG
360	674	31	1994
361	799	75	JD
362	222	75	JB
363	800	75	JJ
364	801	75	J9
365	224	31	1739
366	802	75	J4
367	802	31	1576
368	219	75	J1
369	219	31	1276
370	803	75	JF
371	804	31	1924
372	494	75	J6
373	494	31	1776
374	545	75	K1
375	545	31	1453
376	805	75	K0
377	805	31	2100
378	806	75	KB
379	807	75	K9
380	808	31	1400
382	810	75	K5
383	811	75	KH
384	232	31	1655
385	812	75	K6
386	813	75	KF
387	814	75	KE
388	815	75	KA
389	816	31	1926
390	236	75	K7
391	236	31	1149
392	817	31	1932
393	578	31	1422
394	238	75	L7
395	238	31	1918
396	818	31	1647
397	819	31	1672
398	451	31	1234
399	820	75	LB
400	821	75	LG
401	822	75	L8
402	537	31	1425
403	243	31	6395
404	823	75	EM
405	823	75	LE
406	587	75	LL
407	824	75	L6
408	825	75	L5
409	245	75	L1
410	245	31	1256
411	826	75	L9
412	463	75	SH
413	827	75	L0
414	827	31	1284
415	828	31	1867
416	829	75	ME
417	830	75	MQ
418	830	31	1951
419	831	75	MH
420	831	31	1658
421	833	31	1123
422	834	31	1881
423	835	75	MK
424	836	31	1970
425	837	75	MS
426	838	75	MP
427	839	31	1165
428	597	75	MI
429	586	75	M9
430	586	31	1113
431	543	75	IA
432	840	75	L7
433	841	75	Y5
434	842	75	MN
435	843	75	MF
436	844	31	1964
437	258	75	M4
438	258	31	1169
439	258	31	1122
440	845	75	MJ
441	846	75	MT
442	847	31	1183
443	267	75	M3
444	267	31	1484
445	267	31	1743
446	848	31	1950
447	849	75	MA
448	520	75	M1
449	520	31	1266
450	850	31	1161
451	272	31	1216
452	851	75	WL
453	246	75	R0
454	852	31	1248
455	853	75	M8
456	853	31	1241
457	279	31	6399
458	854	75	MG
459	855	75	NE
460	856	75	N4
461	856	31	1949
462	289	75	N5
463	857	31	1943
464	858	75	N9
465	859	31	1500
466	860	31	1317
467	861	75	NC
468	862	31	1621
469	485	31	1201
470	863	75	NX
471	564	75	N0
472	564	75	UK
473	564	31	1928
474	564	31	1981
475	864	75	NM
476	865	31	1945
477	866	75	N1
478	867	75	N6
479	867	31	1141
480	299	75	O0
481	299	31	6069
482	301	31	1206
483	301	31	1697
484	301	31	2292
485	868	75	O9
486	869	75	O4
487	870	31	1937
488	871	31	1953
489	872	31	1820
490	873	75	PG
491	874	31	6386
492	875	31	1180
493	876	75	P2
494	876	31	1130
495	467	31	1801
496	877	75	PS
497	878	31	1111
498	879	31	1845
499	311	75	H0
500	311	75	P1
501	311	31	1437
502	311	31	1347
503	311	31	1473
504	478	31	4500
505	478	31	8045
506	316	31	6182
507	318	75	PC
508	318	75	YN
509	318	31	8054
510	880	31	1723
511	881	75	PX
512	491	31	1393
513	882	75	PV
514	882	31	1251
515	882	31	1270
516	323	75	P9
517	323	31	1815
518	883	75	PF
519	883	31	1491
520	884	75	PN
521	885	31	1935
522	886	31	1938
523	66	31	1494
524	505	75	P6
525	505	31	1354
526	887	31	1309
527	888	31	1845
528	329	75	P0
529	329	31	1209
530	331	75	Q1
531	331	31	8003
532	889	75	Q0
533	889	31	1188
534	584	31	1622
535	890	31	1564
537	740	31	8060
548	339	75	R2
550	891	31	1214
551	892	75	RA
552	892	31	1168
553	522	75	R0
554	522	31	1210
555	893	31	1889
556	894	31	5034
557	895	75	R9
558	570	75	SW
559	500	31	1154
560	896	31	1927
561	897	31	1888
562	350	75	SA
563	898	75	SV
564	899	31	1115
565	900	31	1193
566	352	31	1133
567	901	75	JL
569	463	31	1171
570	605	31	1176
571	379	31	1373
572	903	31	1934
573	904	31	1306
574	905	75	S3
575	905	31	1856
576	485	75	SE
577	567	31	1346
578	906	31	1163
579	676	31	1252
580	907	31	1917
581	492	75	SJ
582	908	31	1351
583	369	75	S2
584	369	31	1102
585	369	31	1868
586	370	75	S9
587	370	31	1395
588	370	31	1398
589	372	31	6154
590	373	75	N3
591	909	31	1927
592	910	31	1656
593	375	31	0394
594	375	75	SC
595	911	31	1136
596	912	31	1942
597	524	31	1101
598	913	31	1203
599	914	31	1940
600	915	75	SL
601	607	75	PR
602	376	75	SX
603	376	31	6389
604	376	75	LB
605	916	75	G9
606	377	75	SM
607	917	31	1975
608	918	75	ST
609	919	31	1788
610	920	31	1800
611	921	75	TW
612	922	75	T7
613	923	75	TB
614	924	75	T1
615	925	31	1170
616	926	31	1719
617	395	75	M2
618	395	31	1291
619	395	31	5034
620	383	75	T4
621	383	31	1301
622	927	31	1507
623	928	31	1146
624	929	75	T7
625	929	31	1396
626	930	75	TE
627	931	31	1156
628	389	31	6132
629	932	75	TN
630	933	75	TS
631	390	31	6377
632	391	75	TG
633	391	31	1124
634	934	31	1947
635	935	31	1826
636	936	75	YX
637	937	31	1980
638	938	75	TM
639	939	75	TF
640	940	31	1271
641	450	31	1103
642	941	75	TD
643	942	75	TR
644	943	31	1152
645	944	31	1985
646	398	75	TJ
647	945	31	1771
648	924	31	1277
649	577	75	TL
650	401	31	1198
651	401	31	1298
652	401	31	1299
653	946	75	T6
655	947	75	TI
656	947	31	1727
657	948	31	6247
658	403	75	T0
659	403	31	1159
660	404	75	T5
661	404	31	6285
662	544	75	U0
663	544	31	1792
664	949	31	1273
665	950	31	1272
666	951	75	U3
667	408	75	UZ
668	952	75	U5
669	953	75	U4
670	953	31	1120
671	954	31	6100
672	11	31	1618
673	955	31	1618
674	19	31	1452
675	411	75	U6
676	411	31	1318
549	339	31	1139
677	956	75	HT
678	957	31	1403
679	412	75	U1
680	412	31	1196
681	958	75	U7
682	959	31	1503
683	960	75	V1
684	961	31	1853
685	962	75	V5
686	963	75	V9
687	963	31	1144
688	600	75	V6
689	423	75	V3
690	964	75	U9
691	420	75	PV
692	965	75	W9
693	965	31	8078
694	966	75	W1
695	966	31	1421
696	967	75	WB
697	968	31	1238
698	145	75	W0
699	427	75	W7
700	969	31	8028
701	970	75	W4
702	427	31	1450
703	971	75	W5
704	971	31	1978
705	972	75	W6
706	973	31	1514
707	431	75	WA
708	974	75	Z0
709	975	75	Y2
710	975	31	1955
711	976	75	V7
712	977	75	Y3
713	434	31	1958
714	434	31	6259
715	978	31	1225
716	442	75	Z1
717	442	31	8031
718	979	75	RM
719	571	75	GE
654	267	31	1594
381	809	31	1968
720	128	31	1181
721	567	75	S0
722	202	31	6250
723	202	31	6421
724	371	31	6428
725	984	75	SH
726	902	75	Z3
746	215	75	I3
747	215	31	1114
753	242	31	3601
754	646	31	8028
755	992	31	1220
756	956	75	U8
757	350	31	6265
758	262	75	MD
759	1000	31	1185
760	114	75	CS
761	114	31	6089
762	114	31	8100
763	1003	31	1183
764	159	31	1326
765	1005	31	1326
766	439	31	6099
767	147	31	1187
768	514	31	8021
769	514	31	8022
770	295	31	6362
771	1019	31	6350
772	87	31	6063
773	301	31	1110
774	65	31	1127
775	517	31	1138
776	243	31	6398
777	289	31	1169
778	16	31	6333
779	350	31	6362
780	961	31	891E
781	866	31	1122
782	11	31	1823
783	35	31	6218
784	1023	31	1840
785	1024	31	1357
786	390	31	6347
787	58	31	1805
788	548	31	6482
789	220	31	5030
790	1033	31	6135
\.


--
-- Data for Name: max_ram; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.max_ram (id, value) FROM stdin;
1	64
2	128
3	256
4	512
5	640
6	768
7	1024
8	1280
9	1664
10	2048
11	2176
12	2560
13	3072
14	3226
15	4096
16	5120
17	6144
18	8192
19	9216
20	10240
21	11264
22	12288
23	13312
24	14336
25	15360
26	16384
27	17408
28	18432
29	20480
30	24576
31	26624
32	32768
33	33796
34	36864
35	40960
36	49152
37	50176
38	53248
39	57344
40	65536
41	69632
42	73728
43	81920
44	98304
45	102400
46	106496
47	114688
48	131072
49	135168
50	139264
51	147456
52	163840
53	196608
54	262144
55	327680
56	393216
57	524288
58	655360
59	786432
60	1048576
61	2097152
62	3145728
63	4194304
65	32
66	1572864
67	6291456
68	8388608
69	16777216
70	3670016
71	1
72	1310720
73	12582912
74	33554432
75	25165824
\.


--
-- Data for Name: media_type_flag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.media_type_flag (id, name, tag_name, file_name, updated_at) FROM stdin;
6	Redbook CD-Rom	redbook	redbook-6099c439d3629974741616.gif	2021-05-11 01:39:37
11	Archive	zip	zip-61d073e4aad57624594507.svg	2022-01-01 15:31:48
4	3.5" HD Floppy Disk	floppy35hd	floppy35hd-61d074517540a400420596.svg	2022-01-01 15:33:37
3	3.5" DD Floppy Disk	floppy35dd	floppy35-61d0745971cf0899671454.svg	2022-01-01 15:33:45
5	Standard CD-Rom	cdrom	cd-61d076424c000921987862.svg	2022-01-01 15:41:54
7	DVD-ROM	dvd	dvd-61d0764918a75055041210.svg	2022-01-01 15:42:01
10	Source code	source	code-61d077532d4bf289342263.svg	2022-01-01 15:46:27
9	Written documentation	book	book-61d077a9ef730008784689.svg	2022-01-01 15:47:53
8	Hard Disk Drive	hdd	hdd-61d0799042301292660561.svg	2022-01-01 15:56:00
1	5.25" DD Floppy Disk	floppy525dd	floppy525dd-61d07ee26d7e3604371452.svg	2022-01-01 16:18:42
2	5.25" HD Floppy Disk	floppy525hd	floppy525-61d07eea09926316070024.svg	2022-01-01 16:18:50
12	Installer	exe	exe-61d08930d4a26921712107.svg	2022-01-01 17:02:40
\.


--
-- Data for Name: motherboard; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard (id, manufacturer_id, chipset_id, form_factor_id, video_chipset_id, max_video_ram_id, audio_chipset_id, name, dimensions, note, last_edited, max_cpu) FROM stdin;
\.


--
-- Data for Name: motherboard_alias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_alias (id, motherboard_id, manufacturer_id, name) FROM stdin;
\.


--
-- Data for Name: motherboard_bios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_bios (id, motherboard_id, manufacturer_id, file_name, post_string, board_version, updated_at, core_version, note) FROM stdin;
\.


--
-- Data for Name: motherboard_cache_size; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_cache_size (motherboard_id, cache_size_id) FROM stdin;
\.


--
-- Data for Name: motherboard_coprocessor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_coprocessor (motherboard_id, coprocessor_id) FROM stdin;
\.


--
-- Data for Name: motherboard_cpu_socket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_cpu_socket (motherboard_id, cpu_socket_id) FROM stdin;
\.


--
-- Data for Name: motherboard_cpu_speed; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_cpu_speed (motherboard_id, cpu_speed_id) FROM stdin;
\.


--
-- Data for Name: motherboard_dram_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_dram_type (motherboard_id, dram_type_id) FROM stdin;
\.


--
-- Data for Name: motherboard_expansion_slot; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_expansion_slot (motherboard_id, expansion_slot_id, count) FROM stdin;
\.


--
-- Data for Name: motherboard_id_redirection; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_id_redirection (id, destination_id) FROM stdin;
\.


--
-- Data for Name: motherboard_image; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_image (id, motherboard_image_type_id, motherboard_id, creditor_id, license_id, file_name, description, updated_at) FROM stdin;
\.


--
-- Data for Name: motherboard_image_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_image_type (id, name) FROM stdin;
1	Schema
2	Photo front
3	Photo back
4	Photo misc
5	Schema misc
\.


--
-- Data for Name: motherboard_io_port; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_io_port (motherboard_id, io_port_id, count) FROM stdin;
\.


--
-- Data for Name: motherboard_known_issue; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_known_issue (motherboard_id, known_issue_id) FROM stdin;
\.


--
-- Data for Name: motherboard_max_ram; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_max_ram (motherboard_id, max_ram_id, note) FROM stdin;
\.


--
-- Data for Name: motherboard_processor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_processor (motherboard_id, processor_id) FROM stdin;
\.


--
-- Data for Name: motherboard_processor_platform_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_processor_platform_type (motherboard_id, processor_platform_type_id) FROM stdin;
\.


--
-- Data for Name: motherboard_psuconnector; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.motherboard_psuconnector (psuconnector_id, motherboard_id) FROM stdin;
\.


--
-- Data for Name: os_family; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.os_family (id, name, file_name, updated_at) FROM stdin;
15	pcdos	pcdos-60ac34d6bacfd750838300.gif	2021-05-25 01:20:54
8	pcdos1.x	pcdos-60ac34de91421805909214.gif	2021-05-25 01:21:02
9	pcdos2.x	pcdos-60ac34e637e92130677355.gif	2021-05-25 01:21:10
10	pcdos3.x	pcdos-60ac34ec3bd51201786580.gif	2021-05-25 01:21:16
11	pcdos4.x	pcdos-60ac34f2b07de593066829.gif	2021-05-25 01:21:22
12	pcdos5.x	pcdos-60ac34f965589365129050.gif	2021-05-25 01:21:29
13	pcdos6.x	pcdos-60ac34ffb1a9b308837533.gif	2021-05-25 01:21:35
14	pcdos7.x	pcdos-60ac35071f04e358479614.gif	2021-05-25 01:21:43
20	drdos	drdos-60ac36323e846411378920.gif	2021-05-25 01:26:42
16	drdos3.x	drdos-60ac3638da3d2514999210.gif	2021-05-25 01:26:48
17	drdos5.x	drdos-60ac363f4492c802557954.gif	2021-05-25 01:26:55
18	drdos6.x	drdos-60ac36450a59f813753654.gif	2021-05-25 01:27:01
19	drdos7.x	drdos-60ac364b89fc0876878411.gif	2021-05-25 01:27:07
42	winnt4	win9x-61d080aaece19732399569.svg	2022-01-01 16:26:18
40	winnt3.x	win9x-61d080b6e1d05779488722.svg	2022-01-01 16:26:30
41	winnt3.5x	win9x-61d080bce0a72396566245.svg	2022-01-01 16:26:36
39	win9x	win9x-61d080c92b7a0363823912.svg	2022-01-01 16:26:49
38	win98	win9x-61d080d22dfdd821003271.svg	2022-01-01 16:26:58
37	win95 osr2.x	win9x-61d080e145c80143823696.svg	2022-01-01 16:27:13
43	win2k	win9x-61d080e7282e9310492623.svg	2022-01-01 16:27:19
28	msdos	msdos-61d08270ab2a4186002143.svg	2022-01-01 16:33:52
21	msdos1.x	msdos-61d08278064bb431325791.svg	2022-01-01 16:34:00
22	msdos2.x	msdos-61d0827cf40cf940681263.svg	2022-01-01 16:34:04
23	msdos3.x	msdos-61d08282bddce070487785.svg	2022-01-01 16:34:10
24	msdos4.x	msdos-61d0828883e55636998431.svg	2022-01-01 16:34:16
25	msdos5.x	msdos-61d0828ec644a173533641.svg	2022-01-01 16:34:22
26	msdos6.x	msdos-61d0829540134896772112.svg	2022-01-01 16:34:29
27	msdos7.x	msdos-61d0829ad1b3b962570027.svg	2022-01-01 16:34:34
29	dos	dos-61d0837286620392100248.svg	2022-01-01 16:38:10
32	win3.x	win3x-61d0838aece1c934797131.svg	2022-01-01 16:38:34
34	win3.1x	win3x-61d083936f03b296279159.svg	2022-01-01 16:38:43
35	wfw3.1x	win3x-61d083a08835c533851301.svg	2022-01-01 16:38:56
30	win1.x	win1x-61d083e89f55b671676807.svg	2022-01-01 16:40:08
33	win2.1x	win1x-61d083ef03306620604219.svg	2022-01-01 16:40:15
31	win2.x	win1x-61d083f60cfd6554237999.svg	2022-01-01 16:40:22
46	winxp	winxp-61d0842555382336335113.svg	2022-01-01 16:41:09
45	winnt5.x	winxp-61d0842c2ab6a141081932.svg	2022-01-01 16:41:16
44	win2k3	winxp-61d0843364f05814737662.svg	2022-01-01 16:41:23
47	os2 1.x	os2-61d084fce2636909794692.svg	2022-01-01 16:44:44
48	os2 2.x	os2-61d085057ff8a758709340.svg	2022-01-01 16:44:53
49	os2 3.x	os2-61d0850b9c197920574232.svg	2022-01-01 16:44:59
50	os2 4.x	os2-61d0851184bbc535316071.svg	2022-01-01 16:45:05
36	win95	win95-61d0871a7ccb4379477864.svg	2022-01-01 16:53:46
1	winxp.x64	winxp-61d0b879bf2fe322504227.svg	2022-01-01 20:24:25
\.


--
-- Data for Name: os_flag; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.os_flag (id, manufacturer_id, name, major_version, minor_version) FROM stdin;
1	197	PC-DOS 1.0	pcdos1	\N
2	197	PC-DOS 2.0	pcdos2	\N
3	197	PC-DOS 2.1	pcdos2	1
4	197	PC-DOS 3.3	pcdos3	3
5	197	PC-DOS 4.0	pcdos4	\N
6	197	PC-DOS 5.0	pcdos5	\N
7	197	PC-DOS 6.1	pcdos6	1
8	197	PC-DOS 6.3	pcdos6	3
9	197	PC-DOS 7.0	pcdos7	\N
10	197	PC-DOS 2000	pcdos2k	\N
11	592	DR-DOS 3.40	drdos3	40
12	592	DR-DOS 3.41	drdos3	41
13	592	DR-DOS 5.0	drdos5	\N
14	592	DR-DOS 6.0	drdos6	\N
15	593	DR-DOS 7.0	drdos7	\N
16	594	DR-DOS 7.01	drdos7	01
17	594	DR-DOS 7.02	drdos7	02
18	594	DR-DOS 7.03	drdos7	03
19	591	MS-DOS 1.25	msdos1	25
20	591	MS-DOS 2.0	msdos2	\N
21	591	MS-DOS 2.11	msdos2	11
22	591	MS-DOS 3.0	msdos3	\N
23	591	MS-DOS 3.1	msdos3	1
24	591	MS-DOS 3.20	msdos3	20
25	591	MS-DOS 3.21	msdos3	21
26	591	MS-DOS 3.3	msdos3	3
27	591	MS-DOS 4.0	msdos4	\N
28	591	MS-DOS 4.01	msdos4	01
29	591	MS-DOS 5.0	msdos5	\N
30	591	MS-DOS 6.0	msdos6	\N
31	591	MS-DOS 6.2	msdos6	2
32	591	MS-DOS 6.21	msdos6	21
33	591	MS-DOS 6.22	msdos6	22
34	591	MS-DOS 7.0	msdos7	\N
35	591	MS-DOS 7.1	msdos7	1
36	591	Windows 1.01	win1	01
37	591	Windows 1.02	win1	02
38	591	Windows 1.03	win1	03
39	591	Windows 1.04	win1	04
40	591	Windows 2.03	win2	03
41	591	Windows 2.10	win2	10
42	591	Windows 2.11	win2	11
43	591	Windows 3.0	win3	\N
44	591	Windows 3.0a	win3	0a
45	591	Windows 3.1	win3	1
46	591	Windows 3.11	win3	11
47	591	Windows For Workgroups 3.1	win3	1
48	591	Windows For Workgroups 3.11	win3	11
49	591	Windows 95	win95	rtm
50	591	Windows 95 OSR1	win95	osr1
51	591	Windows 95 OSR2	win95	osr2
52	591	Windows 95 OSR2.1	win95	osr2.1
53	591	Windows 95 OSR2.5	win95	osr2.5
55	591	Windows 98 SE	win98	se
56	591	Windows ME	winme	me
60	591	Windows NT 4.0	winnt4	rtm
61	591	Windows NT 4.0 Service Pack 1	winnt4	sp1
62	591	Windows NT 4.0 Service Pack 2	winnt4	sp2
63	591	Windows NT 4.0 Service Pack 3	winnt4	sp3
64	591	Windows NT 4.0 Service Pack 4	winnt4	sp4
65	591	Windows NT 4.0 Service Pack 5	winnt4	sp5
66	591	Windows NT 4.0 Service Pack 6	winnt4	sp6
67	591	Windows 2000	win2k	rtm
68	591	Windows 2000 Service Pack 1	win2k	sp1
69	591	Windows 2000 Service Pack 2	win2k	sp2
70	591	Windows 2000 Service Pack 3	win2k	sp3
71	591	Windows 2000 Service Pack 4	win2k	sp4
72	591	Windows XP	winxp	rtm
73	591	Windows XP Service Pack 1	winxp	sp1
74	591	Windows XP Service Pack 2	winxp	sp2
75	591	Windows XP Service Pack 3	winxp	sp3
80	197	OS/2 1.2	os2-1	2
84	197	OS/2 Warp 3.0	os2 w3	\N
85	197	OS/2 Warp 4.0	os2 w4	\N
86	197	OS/2 Warp 4.52	os2 w4	52
83	197	OS/2 2.1	os2 2	1
82	197	OS/2 2.0	os2 2	\N
81	197	OS/2 1.3	os2 1	3
79	197	OS/2 1.1	os2 1	1
78	197	OS/2 1.0	os2 1	\N
77	591	Windows XP x64 Service Pack 2	winxp x64	sp3
87	591	Windows Server 2003	win2k3	rtm
89	591	Windows Server 2003 Service Pack 2	win2k3	sp2
76	591	Windows XP x64	winxp x64	sp1
90	591	Windows NT 3.51 Service Pack 1	winnt3.51	sp1
92	591	Windows NT 3.51 Service Pack 3	winnt3.51	sp3
88	591	Windows Server 2003 Service Pack 1	win2k3	sp1
91	591	Windows NT 3.51 Service Pack 2	winnt3.51	sp2
93	591	Windows NT 3.51 Service Pack 4	winnt3.51	sp4
94	591	Windows NT 3.51 Service Pack 5	winnt3.51	sp5
58	591	Windows NT 3.5	winnt3.5	rtm
95	591	Windows NT 3.5 Service Pack 1	winnt3.5	sp1
96	591	Windows NT 3.5 Service Pack 2	winnt3.5	sp2
97	591	Windows NT 3.5 Service Pack 3	winnt3.5	sp3
59	591	Windows NT 3.51	winnt3.51	rtm
57	591	Windows NT 3.1	winnt3	rtm
98	591	Windows NT 3.1 Service Pack 1	winnt3	sp1
99	591	Windows NT 3.1 Service Pack 2	winnt3	sp2
100	591	Windows NT 3.1 Service Pack 3	winnt3	sp3
54	591	Windows 98	win98	fe
\.


--
-- Data for Name: os_flag_os_family; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.os_flag_os_family (os_flag_id, os_family_id) FROM stdin;
1	8
2	9
3	9
4	10
5	11
6	12
7	13
8	13
9	14
10	14
10	15
8	15
8	29
9	15
9	29
10	29
7	15
7	29
6	15
6	29
5	15
5	29
4	15
4	29
3	15
3	29
2	15
2	29
1	15
1	29
11	16
11	20
11	29
12	16
12	20
12	29
13	17
13	20
13	29
14	18
14	20
14	29
15	19
15	20
15	29
16	19
16	20
16	29
17	19
17	20
17	29
18	19
18	20
18	29
19	21
19	29
20	22
20	28
20	29
19	28
21	22
21	28
21	29
22	23
22	28
22	29
23	23
23	28
23	29
24	23
24	28
24	29
25	23
25	28
25	29
26	23
26	28
26	29
27	24
27	28
27	29
28	24
28	28
28	29
29	25
29	28
29	29
30	26
30	28
30	29
31	26
31	28
31	29
32	26
32	28
32	29
33	26
33	28
33	29
34	27
34	28
34	29
35	27
35	28
35	29
36	30
37	30
38	30
39	30
40	31
43	32
44	32
45	34
46	34
49	36
50	36
54	38
55	38
56	39
57	40
58	40
58	41
59	40
59	41
60	42
61	42
62	42
63	42
64	42
65	42
66	42
67	43
68	43
69	43
70	43
71	43
72	46
73	46
74	46
75	46
78	47
79	47
80	47
81	47
82	48
83	48
84	49
85	50
86	50
87	44
88	44
89	44
90	41
90	40
91	41
91	40
92	41
92	40
93	41
93	40
94	41
94	40
95	41
95	40
96	41
96	40
97	41
97	40
98	40
99	40
100	40
51	36
52	36
53	36
47	34
48	34
41	31
42	31
76	1
77	1
\.


--
-- Data for Name: processing_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processing_unit (id, speed_id, platform_id, fsb_id) FROM stdin;
782	19	22	19
783	52	22	28
823	28	22	28
916	106	33	82
909	106	34	88
793	30	53	38
826	52	22	28
755	2	5	38
757	2	5	38
760	6	5	46
759	6	5	46
761	2	5	38
739	72	5	46
825	46	22	19
774	1	1	1
824	28	22	28
1575	127	27	54
1580	128	27	54
785	1	4	1
1585	127	27	82
1590	133	27	82
1594	135	27	82
740	72	5	46
747	72	4	46
735	46	4	46
743	64	5	38
1598	135	27	82
1602	139	27	82
1606	130	27	82
756	70	5	28
754	76	5	35
737	64	5	38
1610	137	27	82
1617	1	63	1
1621	1	63	1
1625	71	63	71
1630	28	65	28
1634	38	66	38
1638	46	65	46
1642	46	66	46
1647	46	65	46
1651	125	27	54
808	164	11	40
835	20	8	64
769	12	60	12
710	154	57	154
711	46	58	46
712	52	59	52
798	52	22	28
801	1	8	1
794	64	3	38
766	9	5	38
917	100	33	82
724	64	4	38
771	38	3	38
714	44	2	44
719	13	22	13
716	13	3	13
828	38	4	38
814	12	10	59
860	64	26	64
810	24	12	64
902	106	33	88
905	111	35	88
862	53	25	2
789	72	8	46
871	94	27	47
791	9	9	64
790	17	9	70
792	15	9	64
772	38	3	13
819	46	3	46
869	12	8	59
717	38	3	38
865	54	25	64
734	51	14	51
809	70	8	52
884	92	29	47
811	15	9	64
812	73	4	38
813	7	8	52
818	28	3	28
721	28	4	28
730	13	4	13
731	52	4	28
858	39	9	64
805	70	8	52
806	15	9	64
894	53	31	20
895	63	31	20
832	51	14	51
829	38	4	38
831	38	4	38
900	106	33	82
908	96	34	82
827	46	4	46
904	127	35	88
915	106	33	82
906	111	35	88
830	28	4	28
907	106	34	88
778	38	4	38
786	46	4	46
775	64	4	38
773	38	4	38
788	2	5	38
787	6	5	46
777	2	5	38
776	64	4	38
836	44	55	44
779	28	4	28
872	98	27	47
873	102	27	47
879	113	27	54
877	98	27	47
874	121	27	54
875	127	27	82
876	130	27	82
881	131	27	54
880	121	27	54
817	1	61	1
815	1	61	1
816	1	61	1
896	60	31	20
1693	135	83	82
886	125	83	54
120	96	6	47
911	60	31	20
780	52	4	52
797	64	5	38
799	72	5	46
709	52	4	28
720	52	4	28
732	64	4	38
729	64	4	38
728	70	4	28
725	70	4	28
796	2	4	38
795	2	4	38
822	61	4	28
781	52	4	28
784	64	4	38
727	19	5	19
753	28	5	28
758	38	5	38
733	51	23	51
833	51	23	51
1569	38	22	38
910	116	39	82
1576	127	27	54
1581	131	27	54
1586	127	27	82
1591	133	27	82
938	1	48	1
939	1	48	1
940	1	48	1
941	1	48	1
1595	135	27	82
1599	137	27	82
1603	139	27	82
1611	137	27	82
1607	133	27	82
968	13	66	13
967	13	65	13
980	13	65	13
969	51	62	51
1614	1	62	1
964	58	63	58
1618	4	63	4
965	44	63	44
1622	4	63	4
1053	56	31	20
1054	60	31	20
1055	63	31	20
1056	69	31	20
1057	56	31	20
899	107	77	39
898	96	77	30
897	95	77	30
859	49	80	2
863	30	81	64
866	53	25	2
954	100	82	82
901	116	33	88
1058	60	31	20
1626	1	63	1
1631	38	65	38
1059	63	31	20
1060	69	31	20
726	2	5	38
976	13	65	13
1635	19	65	19
984	64	5	38
804	20	9	64
985	58	2	58
986	71	2	71
987	1	2	1
988	5	2	5
989	19	22	19
990	28	22	28
991	38	22	38
992	46	22	46
993	19	3	19
994	28	3	28
995	38	3	38
996	46	3	46
997	15	10	64
998	16	10	59
999	20	10	64
1061	91	31	20
1062	82	31	20
1004	39	10	64
1005	36	10	59
861	6	26	59
1006	9	26	64
1003	20	10	64
1000	20	10	64
933	47	13	2
977	13	66	13
1639	19	66	19
1063	83	31	20
1643	19	65	19
1064	85	31	20
960	94	29	47
864	36	45	64
867	88	44	9
1648	120	27	54
868	85	44	2
1652	127	27	54
926	128	47	141
882	100	47	82
888	108	47	141
1655	133	27	54
891	100	47	82
1658	133	27	82
885	94	29	47
961	96	29	47
1685	138	83	141
1007	2	5	38
1008	38	3	38
1065	87	31	20
1009	46	3	46
1010	38	4	38
1011	52	4	52
1012	52	4	28
1013	52	4	28
1066	88	31	20
1015	70	5	28
1016	19	4	19
1017	28	4	28
1018	38	4	38
1014	64	4	38
1019	70	5	28
1020	59	26	59
1021	76	8	59
1022	2	8	64
1023	6	8	59
1024	9	8	64
1025	12	8	59
1026	15	8	64
1027	20	8	64
1028	20	9	64
1029	24	9	64
1067	69	31	20
807	20	9	64
1664	125	27	54
1667	127	27	54
949	87	49	20
1670	131	27	54
951	96	49	30
1673	133	27	54
1676	133	27	54
1679	134	27	54
1068	91	31	20
1069	82	31	20
1070	83	31	20
1071	85	31	20
1072	87	31	20
956	20	53	38
955	16	53	35
1030	39	42	142
1695	137	83	82
1073	88	31	20
1697	108	47	141
1700	119	47	95
1703	125	47	141
1706	100	47	82
1709	116	47	82
922	133	27	82
921	138	27	141
923	136	27	141
925	136	83	141
1694	135	83	82
1031	63	31	20
1032	69	31	20
1033	91	31	20
1692	135	83	82
972	38	65	38
970	38	65	38
963	2	56	2
834	16	8	59
937	50	25	9
929	53	25	2
930	60	25	9
931	80	25	9
932	84	44	9
1570	46	22	46
1577	128	27	54
1582	131	27	54
1587	130	27	82
1592	133	27	82
1596	135	27	82
1600	137	27	82
1604	139	27	82
1608	135	27	82
1612	139	27	82
1615	71	62	71
1619	58	63	58
1623	44	63	44
1627	4	63	4
1632	19	66	19
1636	28	65	28
1640	28	66	28
1645	28	65	28
1649	121	27	54
1653	128	27	54
1656	130	27	82
1659	135	27	82
1662	123	27	54
1665	125	27	54
1668	128	27	54
1671	131	27	54
1674	134	27	54
1677	133	27	54
1680	136	27	54
1698	113	47	141
1701	119	47	95
1704	125	47	95
1707	106	47	82
1710	121	47	82
919	49	76	2
914	98	77	39
912	85	77	20
920	30	78	64
1691	133	83	82
1689	133	83	82
924	133	83	82
1683	130	83	82
1686	127	83	82
1682	127	83	82
935	60	85	9
936	60	90	9
934	53	84	2
928	130	95	95
893	125	95	95
889	125	94	95
1718	128	94	141
1716	127	94	141
1715	127	94	141
927	125	93	141
1713	123	94	141
1712	123	94	141
892	121	93	141
890	122	94	82
883	121	94	82
1749	13	67	13
1750	19	67	19
1751	28	67	28
979	28	66	28
1729	133	95	100
1725	132	94	95
1748	130	95	95
1567	71	62	71
1769	5	57	5
1770	154	57	154
1771	19	57	19
1772	28	57	28
1773	154	57	154
1774	154	57	154
1775	19	57	19
1776	19	57	19
1777	28	57	28
1778	28	57	28
1779	38	57	38
1780	38	57	38
1781	46	57	46
1782	52	57	52
1787	13	66	13
1767	46	65	46
1765	38	65	38
1766	46	65	46
1763	38	65	38
1764	38	66	38
1768	46	66	46
1785	46	65	46
1784	28	65	28
1761	38	65	38
1762	46	66	46
1756	13	66	13
1757	19	66	19
1783	28	66	28
978	46	65	46
1786	38	65	38
1758	28	66	28
1214	88	49	20
1215	92	49	20
1216	97	49	30
1217	99	49	30
1218	99	49	30
1219	100	49	30
1222	101	49	30
1759	38	66	38
1743	148	95	95
1744	148	95	95
1745	148	95	95
1760	46	66	46
1788	28	65	28
1789	38	65	38
1790	46	65	46
1791	46	65	46
1792	46	65	46
1793	28	66	28
1794	38	66	38
1795	38	66	38
1796	71	63	71
1797	5	63	5
1798	71	63	71
1235	97	49	30
1236	99	49	30
1237	99	49	30
1238	100	49	20
1241	100	49	30
1240	101	49	30
1242	101	49	30
1239	106	49	30
1243	107	49	39
1799	58	63	58
1800	1	63	1
1801	5	63	5
1802	44	63	44
1803	44	63	44
1804	58	63	58
1805	71	63	71
1806	1	63	1
1807	5	63	5
1808	1	63	1
1809	58	63	58
1810	44	63	44
1811	71	63	71
1812	1	63	1
1813	4	63	4
1259	76	8	59
1258	2	8	64
1260	76	8	59
1261	2	8	64
1262	146	8	59
1263	145	8	64
1264	9	8	64
1265	20	9	64
1266	24	9	64
1267	24	9	64
1084	90	31	30
1814	13	63	13
1815	19	63	19
1816	28	63	28
1817	4	64	4
1818	13	64	13
1819	4	64	4
1820	13	64	13
1822	161	69	157
1821	160	69	156
1823	70	11	155
1824	160	11	156
1825	161	11	157
1827	162	11	158
1826	161	11	157
1828	162	11	158
1829	163	11	159
1830	64	56	64
1831	38	56	38
1832	20	8	64
1833	23	8	70
1268	30	9	64
1269	36	9	64
1746	148	95	95
1747	148	95	95
1723	148	94	95
1733	125	95	95
1274	24	9	64
1275	29	42	2
1276	30	9	64
1277	36	42	2
1278	36	9	64
1279	39	42	142
1280	39	9	64
1281	41	42	2
1282	42	9	64
1283	43	42	142
1284	47	42	2
1285	47	9	64
1286	47	42	2
1287	47	9	64
1288	49	42	2
1289	49	42	2
1290	49	42	2
1291	77	42	142
1292	77	42	142
1293	53	42	2
1294	53	42	2
1295	54	42	143
1296	56	42	2
1297	56	42	2
1739	125	95	95
1742	125	95	95
1738	125	95	95
1741	125	95	95
1721	125	94	95
1737	122	95	95
1740	122	95	95
1736	122	95	95
1734	119	95	95
1735	119	95	95
1727	128	93	141
1732	125	93	141
1731	113	93	141
1754	28	65	28
1755	38	65	38
1311	49	76	2
1308	47	76	2
1306	47	76	2
1303	41	76	2
1299	36	76	2
1301	39	76	142
1310	48	76	144
1307	47	78	64
1309	47	78	64
1304	42	78	64
1302	39	78	64
1300	36	78	64
1298	30	78	64
1272	30	78	64
1273	30	78	64
1270	24	78	64
1220	106	82	82
952	100	82	82
1221	100	82	82
1432	88	85	9
1430	86	85	9
1314	24	9	64
1315	24	9	64
1316	30	9	64
1317	30	9	64
1318	36	42	2
1319	36	9	64
1320	36	42	2
1321	36	9	64
1322	39	42	142
1323	39	9	64
1324	39	42	142
1325	39	9	64
1326	41	42	2
1327	41	42	2
1328	47	42	2
1329	47	9	64
1331	24	53	38
1330	20	53	38
1332	36	53	38
1424	82	85	9
1422	80	85	9
1416	65	85	9
1428	85	85	2
1419	69	85	2
1418	69	85	2
1347	47	42	2
1348	47	9	64
1349	47	42	2
1350	47	9	64
1351	49	42	2
1352	49	42	2
1426	84	85	9
1431	86	90	9
1427	84	90	9
1425	82	90	9
1423	80	90	9
1417	65	90	9
1429	85	90	2
1421	69	90	2
1420	69	90	2
1414	56	84	2
1415	56	84	2
1413	56	84	2
1412	53	84	2
1411	53	84	2
1433	88	90	9
1372	24	12	64
1373	30	12	64
1374	30	12	64
1376	36	12	64
1383	39	45	64
1384	42	45	64
1386	47	45	64
1385	48	45	64
1387	50	45	64
1388	53	45	64
1389	54	45	64
1571	38	22	38
1395	24	9	64
1396	20	9	64
1399	47	9	64
1400	47	42	2
1407	47	13	2
1408	49	13	2
1409	49	13	2
1410	49	13	2
1435	88	44	9
1436	90	44	9
1437	90	44	9
1438	92	44	9
1439	93	44	9
1440	95	44	9
1441	96	44	9
1442	96	44	9
1443	82	25	9
1444	84	25	9
1445	86	25	9
1446	88	25	9
1447	90	25	9
1448	96	27	47
1464	54	25	9
1465	56	25	2
1466	60	25	2
1467	60	25	9
1468	63	25	2
1469	65	25	9
1470	69	25	2
1471	80	25	9
1472	91	25	2
1473	82	25	2
1474	82	25	9
1475	83	25	2
1476	84	25	9
1477	84	25	9
1478	85	25	2
1479	86	25	9
1480	86	25	9
1481	88	25	2
1482	88	25	9
1483	88	25	9
1484	89	25	2
1485	90	25	9
1486	57	25	64
1487	60	25	64
1488	62	25	64
1489	65	25	64
1490	69	25	64
1491	80	25	64
1492	81	25	64
1493	82	25	2
1494	83	25	2
1337	56	76	2
1370	53	76	2
1366	53	76	2
1363	53	76	2
1335	53	76	2
1346	53	76	2
1313	53	76	2
918	49	76	2
1361	49	76	2
1345	49	76	2
1344	49	76	2
1333	49	76	2
1360	49	76	2
1364	47	76	2
1342	47	76	2
1367	47	76	2
1340	47	76	2
1355	41	76	2
1336	54	76	143
1359	48	76	144
1362	77	76	142
1334	77	76	142
1312	77	76	142
1356	43	76	142
1353	39	76	142
1357	47	76	2
1338	147	76	142
1341	47	78	64
1365	47	78	64
1368	47	78	64
1358	47	78	64
1401	42	78	64
1354	39	78	64
1398	36	78	64
1397	24	78	64
1406	60	80	9
1403	54	80	9
1405	60	80	2
1404	56	80	2
1402	53	80	2
1375	30	81	64
1382	36	81	64
1390	36	81	64
1377	36	81	64
1391	39	81	64
1378	39	81	64
1392	42	81	64
1394	48	81	64
1379	41	81	2
1380	47	81	2
1381	49	81	2
1463	88	25	9
1461	86	25	9
1460	84	25	9
1458	82	25	9
1456	80	25	9
1453	65	25	9
1434	54	25	9
1459	83	25	2
1457	82	25	2
1455	91	25	2
1454	69	25	2
1452	63	25	2
1449	56	25	2
1450	60	25	2
1495	85	25	2
1496	87	25	2
1497	88	25	2
1498	89	25	2
1499	88	44	2
1500	89	44	2
1501	92	44	2
1502	94	44	2
1503	96	44	2
1504	98	44	2
1505	98	27	47
1506	100	27	47
1507	102	27	47
1508	106	27	47
1509	109	27	47
1510	111	27	47
1573	46	22	46
1578	128	27	54
1583	131	27	54
962	64	5	38
878	100	27	47
959	127	27	82
958	124	27	82
1511	96	27	47
1512	100	27	47
1513	102	27	47
1514	106	27	47
1515	109	27	47
1516	111	27	47
1517	100	27	47
1518	102	27	47
1519	106	27	47
1520	109	27	47
1521	111	27	20
1522	100	27	47
1523	106	27	47
1524	109	27	47
1525	111	27	47
1526	116	27	47
1527	121	27	47
1528	122	27	47
1529	124	27	47
1530	127	27	47
1531	130	27	47
1532	120	27	54
1533	121	27	54
1534	123	27	54
1535	125	27	54
1536	127	27	54
1537	131	27	54
1538	121	27	82
1539	127	27	82
1540	130	27	82
1541	133	27	82
1542	135	27	82
1543	106	27	47
1544	111	27	47
1545	114	27	47
1547	116	27	47
1548	118	27	47
1549	121	27	47
1550	122	27	47
1551	124	27	47
1552	126	27	47
1553	127	27	47
1554	135	27	82
1556	120	27	54
1557	125	27	54
1558	127	27	54
1559	130	27	82
1561	133	27	82
1563	135	27	82
1555	135	27	82
1564	125	27	54
1566	125	27	54
1034	82	31	20
1035	83	31	20
1036	85	31	20
1037	87	31	20
1100	92	77	20
1101	94	77	20
1102	96	77	20
1098	88	77	20
1099	89	77	20
1074	63	31	20
1075	69	31	20
1076	91	31	20
1077	82	31	20
1079	85	31	20
1080	87	31	20
1081	88	31	20
1082	88	31	30
1083	89	31	20
1085	92	31	20
1086	92	31	30
1087	93	31	30
1088	94	31	20
1089	95	31	30
1090	96	31	20
1091	96	31	30
1565	125	27	54
1562	135	27	82
1560	133	27	82
948	96	75	30
1052	94	75	20
1051	92	75	20
1050	89	75	20
1049	88	75	20
1048	87	75	20
1047	85	75	20
946	83	75	20
1045	69	75	20
945	60	75	20
1133	116	77	47
1144	116	77	47
1119	116	77	47
1150	114	77	47
1142	114	77	47
1141	111	77	47
1138	109	77	47
1145	119	77	39
1118	117	77	39
1117	115	77	39
1143	115	77	39
1116	112	77	39
1149	112	77	39
1139	112	77	39
1148	112	77	39
1132	112	77	39
1136	110	77	39
1146	107	77	39
1131	113	77	30
1140	113	77	30
1115	113	77	30
1113	111	77	30
1130	111	77	30
1114	111	77	30
1137	111	77	30
1125	111	77	30
1134	108	77	30
1128	106	77	30
1111	106	77	30
1124	106	77	30
1110	104	77	30
1112	106	77	30
1129	106	77	30
1097	104	77	30
1109	101	77	30
1126	101	77	30
1127	101	77	30
1096	101	77	30
1107	100	77	30
1043	100	77	30
1095	100	77	30
1104	99	77	30
1106	99	77	30
1123	99	77	30
1094	99	77	30
1105	97	77	30
1122	97	77	30
1093	97	77	30
913	96	77	30
1121	96	77	30
1092	96	77	30
1120	95	77	30
1042	94	77	20
1041	92	77	20
1040	89	77	20
1039	88	77	20
1038	87	77	20
944	111	79	30
943	101	79	30
1154	96	79	30
1153	95	79	30
1152	92	79	30
942	88	79	30
1151	92	79	20
1690	133	83	82
1696	137	83	82
1684	133	83	82
1687	130	83	82
1726	134	94	95
1724	130	94	95
1728	130	93	95
1722	148	94	95
1720	131	94	141
1717	127	94	141
1714	125	94	141
1730	121	93	141
1078	83	31	20
1574	127	27	54
1579	128	27	54
1584	131	27	54
1589	130	27	82
1593	135	27	82
1597	135	27	82
1601	137	27	82
1605	127	27	82
1609	137	27	82
1613	139	27	82
1616	71	63	71
1620	71	63	71
1624	58	63	58
1628	19	65	19
1633	28	66	28
1637	38	65	38
1641	38	66	38
1646	38	65	38
1650	123	27	54
1654	131	27	54
1657	133	27	82
1660	135	27	82
1663	123	27	54
1666	127	27	54
1669	128	27	54
1672	133	27	54
1675	131	27	54
1678	134	27	54
1681	137	27	54
1699	113	47	141
1702	121	47	141
1705	130	47	95
1708	111	47	82
1711	124	47	82
1834	27	8	59
1835	23	8	70
1836	27	8	59
1837	20	8	64
1839	30	8	64
1840	29	42	2
1838	24	42	2
1841	20	9	64
1842	54	25	9
1843	56	25	2
1844	60	25	2
1845	60	25	9
1846	63	25	2
1847	65	25	9
1848	69	25	2
1849	80	25	9
1850	91	25	2
1851	82	25	2
1852	63	25	2
1853	65	25	9
1854	69	25	2
1855	80	25	9
1856	91	25	2
1857	82	25	2
1858	82	25	9
1859	82	25	2
1860	82	25	9
1861	82	44	9
1862	83	25	2
1863	84	25	9
1864	84	44	9
1865	85	25	2
1866	86	25	9
1867	86	25	9
1868	88	44	2
1869	88	44	9
1870	88	44	9
1871	88	44	2
1872	90	44	9
1873	92	44	9
1874	95	44	9
1875	15	60	15
1876	20	60	20
1877	12	60	12
1878	20	60	20
1879	24	60	24
1880	32	60	32
1881	32	60	32
1882	36	60	36
1883	20	60	20
1884	30	60	30
1885	30	60	30
1226	113	75	30
1230	113	75	30
1205	113	75	30
1225	111	75	30
1229	111	75	30
1204	111	75	30
1228	108	75	30
1224	108	75	30
1233	106	75	30
1203	106	75	30
1213	106	75	30
1201	106	75	30
1223	106	75	30
1227	106	75	30
1212	101	75	30
1202	101	75	30
1200	101	75	30
1199	101	75	30
1211	100	75	30
1198	100	75	30
1209	99	75	30
1197	99	75	30
1185	100	75	30
1194	99	75	30
1183	99	75	30
1192	97	75	30
1181	97	75	30
1191	96	75	30
1177	95	75	30
1188	95	75	30
1196	99	75	30
1208	97	75	30
1195	97	75	30
1207	96	75	30
1175	92	75	30
1184	100	75	20
1193	98	75	20
1190	96	75	20
1189	96	75	20
1179	96	75	20
1178	96	75	20
1173	96	75	20
1187	94	75	20
1176	94	75	20
1172	94	75	20
1174	92	75	20
1186	92	75	20
1168	89	75	20
1170	89	75	20
1167	88	75	20
1169	88	75	20
1166	87	75	20
1165	85	75	20
1210	100	75	20
1182	98	75	20
1257	116	77	47
1256	111	77	39
1255	111	77	39
1251	107	77	39
1250	105	77	39
1254	101	77	39
1249	101	77	39
1248	103	77	39
1253	98	77	39
1246	106	75	30
1247	106	75	30
1245	96	75	30
1163	113	79	30
1164	113	79	30
1162	111	79	30
1161	106	79	30
1158	104	79	30
1160	101	79	30
1157	101	79	30
1156	100	79	30
1155	99	79	30
1159	92	79	30
1886	36	60	36
1887	36	60	36
1888	39	60	39
1889	39	60	39
1890	42	60	42
1891	47	60	47
1892	53	60	53
1893	48	60	48
1894	50	60	50
1895	54	60	54
1896	54	60	54
1897	60	60	60
1898	47	60	47
1899	50	60	50
1900	54	60	54
1901	154	57	154
1902	19	57	19
1903	28	57	28
1904	28	57	28
1905	38	57	38
1906	38	57	38
1907	46	57	46
1908	52	57	52
1909	52	57	52
1910	28	57	28
1911	28	57	28
1912	46	57	46
1913	46	57	46
1914	154	57	154
1915	19	57	19
1916	28	57	28
1917	38	57	38
1918	46	57	46
1919	46	57	46
1920	28	58	28
1921	38	58	38
1922	19	58	19
1923	28	58	28
1924	38	58	38
1925	46	58	46
1926	19	58	19
1927	28	58	28
1928	38	58	38
1929	46	58	46
1930	59	59	59
1931	64	59	64
1932	52	59	52
1933	64	59	64
1934	70	59	70
1935	59	59	59
1936	52	59	52
1937	64	59	64
1938	70	59	70
1939	70	3	28
1940	59	3	19
1941	46	22	19
1942	64	22	38
1943	72	8	46
1944	72	8	46
1945	2	8	52
1946	2	8	52
1947	3	8	55
1948	6	8	59
1949	9	8	64
1950	12	8	70
1951	2	9	52
1952	2	9	52
1953	3	9	55
1954	6	9	59
1955	9	9	64
1956	9	9	64
1957	12	9	70
1958	12	9	59
1959	9	9	64
1960	15	9	64
1961	12	9	70
1962	20	9	64
1963	15	9	73
1964	165	9	73
1965	165	9	73
1966	24	9	64
1967	23	9	70
1968	78	9	70
1969	29	9	73
1970	17	9	70
1971	20	9	64
1972	165	9	73
1973	17	9	70
1974	20	9	64
1975	24	9	64
1976	23	9	70
1977	23	9	70
1978	78	9	70
1979	29	9	73
1980	30	9	64
1981	78	9	70
1982	29	9	73
2063	126	94	82
1984	29	9	73
1985	29	42	2
2072	126	94	82
1987	166	42	142
1988	166	42	142
1989	36	42	2
1990	36	42	2
1991	6	70	35
1992	9	70	38
1993	12	70	35
1994	15	70	38
1995	15	70	38
1996	16	70	35
1997	20	70	38
1998	13	2	13
1999	19	2	19
2000	28	2	28
2001	46	3	19
2002	52	3	28
2003	64	3	38
2004	28	3	28
2005	46	3	46
2006	38	3	13
2007	46	3	19
2008	52	3	28
2009	38	22	13
2010	46	22	19
2011	52	22	28
2015	12	8	59
2016	15	8	64
2017	15	8	64
2018	16	8	59
2019	20	8	64
2020	15	9	73
2021	20	42	2
2022	20	42	2
2023	29	42	2
2024	72	5	46
2025	9	5	38
2026	70	5	28
2027	28	4	28
2028	46	4	46
2029	46	4	46
2030	52	4	28
2031	52	4	28
2033	72	4	46
2032	46	4	46
2034	52	5	28
800	70	5	28
2035	6	5	46
2036	38	5	38
821	46	4	19
2037	71	54	71
2038	1	54	1
2039	4	54	4
2040	13	54	13
2041	1	54	1
2042	4	54	4
2043	13	54	13
2044	19	54	19
2045	28	54	28
2046	1	41	1
2047	4	41	4
2048	13	41	13
2049	1	41	1
2050	4	41	4
2051	13	41	13
2052	19	41	19
2053	28	41	28
2054	106	47	82
2055	111	47	82
2056	116	47	82
2057	100	47	82
2058	111	47	82
2059	116	47	82
2060	121	47	82
2064	106	47	82
2065	111	47	82
2066	116	47	82
2067	121	47	82
1983	30	78	64
2062	124	94	82
2069	124	94	82
2070	124	94	82
2061	122	94	82
2068	116	94	82
2084	111	33	82
2085	111	33	82
2086	116	33	82
2087	121	33	82
2088	116	33	82
2089	121	33	82
2090	121	33	82
2096	106	33	88
2101	121	33	82
2093	121	39	82
2094	106	33	82
2095	111	33	82
2097	116	33	82
2137	116	33	82
2099	121	33	82
2100	121	33	82
2134	111	33	82
2133	111	33	82
2131	106	33	82
2130	106	33	82
2132	106	33	82
2107	88	33	82
2108	111	33	82
2109	111	33	82
2110	116	33	82
2111	121	33	82
2112	106	33	82
2188	126	33	88
2114	100	33	82
2115	100	33	82
2116	100	33	82
2117	100	33	82
2118	100	33	82
2119	100	33	82
2120	106	33	82
2121	106	33	82
2122	106	33	82
2123	106	33	82
2124	106	33	82
2125	106	33	82
2126	111	33	82
2127	111	33	82
2128	111	33	82
2129	111	33	82
2187	126	33	88
2189	127	33	88
2178	124	33	88
2181	124	33	88
2186	121	33	88
2177	121	33	88
2180	121	33	88
2185	116	33	88
2176	116	33	88
2179	116	33	88
2193	111	33	88
2182	116	33	88
2175	111	33	88
2184	106	33	88
2192	100	33	88
2183	100	33	88
2191	88	33	88
2208	118	33	82
2207	116	33	82
2199	116	33	82
2206	114	33	82
2205	111	33	82
2203	111	33	82
2197	111	33	82
2202	106	33	82
2161	111	34	88
2163	116	34	88
2164	121	34	88
2165	124	34	88
2166	127	34	88
2167	130	34	88
2168	106	34	88
2169	111	34	88
2170	116	34	88
2171	121	34	88
2172	124	34	88
2174	127	34	88
2209	106	35	82
2210	111	35	82
2211	116	35	82
2212	124	72	111
2213	126	72	111
2215	127	72	111
2216	129	72	111
2217	121	72	111
2218	122	72	111
2195	106	33	82
2204	109	33	82
2196	106	33	82
2194	100	33	82
2198	111	33	82
2200	100	33	82
2201	106	33	82
2160	124	39	88
2159	121	35	88
2158	121	35	88
2153	121	35	88
2152	116	35	88
2155	116	35	88
2154	116	35	88
2157	116	35	88
2150	111	35	88
2151	111	35	88
2148	121	39	88
2149	124	39	88
2147	127	39	88
1688	130	83	82
2082	133	94	141
2081	131	94	141
2079	128	94	141
2080	128	94	141
2078	127	94	141
2077	133	94	82
2076	130	94	82
2074	127	94	82
2073	126	94	82
2248	121	82	82
2261	121	82	82
2247	116	82	82
2256	116	82	82
2237	116	82	82
2260	116	82	82
2228	111	82	82
2241	111	82	82
2246	111	82	82
2242	111	82	82
2255	111	82	82
2259	111	82	82
2226	106	82	82
2240	106	82	82
2244	106	82	82
2232	106	82	82
2239	106	82	82
2233	106	82	82
2234	106	82	82
2231	106	82	82
2253	106	82	82
2254	106	82	82
2227	106	82	82
2263	106	82	82
2221	106	82	82
2258	106	82	82
2225	100	82	82
2230	100	82	82
2252	100	82	82
2251	100	82	82
2238	100	82	82
2243	100	82	82
2224	100	82	82
2220	100	82	82
2219	100	82	82
953	100	82	82
2223	100	82	82
2262	100	82	82
2222	100	82	82
2113	96	82	82
2236	111	82	82
2146	121	33	88
2139	121	33	88
2103	121	33	88
2092	121	33	88
2091	121	33	88
2141	116	33	88
2142	116	33	88
2145	116	33	88
2138	116	33	88
2143	116	33	88
2102	116	33	88
2105	111	33	88
2136	111	33	88
2098	111	33	88
2135	106	33	88
2104	106	33	88
903	124	39	88
887	127	83	82
121	98	6	47
122	102	6	47
123	111	6	47
2279	111	35	88
2280	116	35	88
2281	116	35	88
2282	121	35	88
2283	121	35	88
2284	124	35	88
2285	124	35	88
2286	127	35	88
2287	127	35	88
2288	130	35	88
2289	130	35	88
2290	133	35	88
2291	111	35	88
2292	111	35	88
2293	111	35	88
2294	116	35	88
2295	116	35	88
2296	121	35	88
2297	121	35	88
2298	124	35	88
2299	124	35	88
2300	111	35	88
2301	109	35	88
2302	114	35	88
2303	116	35	88
2304	118	35	88
2305	121	35	88
2306	122	35	88
2307	124	35	88
2308	124	35	88
2309	126	35	88
2310	127	35	88
2311	127	35	88
2312	129	35	88
2313	130	35	88
2315	140	35	88
2317	109	35	88
2318	114	35	88
2319	118	35	88
2320	122	35	88
2321	98	35	88
2322	114	35	88
2323	118	35	88
2324	122	35	88
2325	124	35	88
2326	118	35	88
2327	122	35	88
2328	124	35	88
2329	126	35	88
2330	127	35	88
2331	129	35	88
2332	96	29	47
2333	98	29	47
2334	100	29	47
2335	102	29	47
2336	106	29	47
2337	98	29	47
2338	98	29	47
2339	98	29	47
2340	100	29	47
2341	100	29	47
2342	71	14	71
2343	1	14	1
2344	71	14	71
2345	1	14	1
2346	71	23	71
2347	1	23	1
2348	71	23	71
2349	1	23	1
1661	137	27	82
1588	130	27	82
59	102	29	47
60	102	29	47
61	106	29	47
62	2	73	2
63	9	73	64
64	2	73	2
65	9	73	64
66	2	73	2
67	6	73	59
68	2	73	2
69	9	73	64
71	20	74	38
72	20	74	38
73	24	74	38
74	24	74	38
75	30	74	38
77	36	74	38
78	36	74	38
79	39	74	38
80	39	74	38
76	30	74	38
81	30	53	38
82	30	53	38
83	30	53	38
84	30	53	38
85	24	53	38
86	24	53	38
87	20	53	38
88	20	53	38
89	16	53	35
90	16	53	35
91	15	53	38
92	15	53	38
95	16	53	35
96	16	53	35
97	16	53	35
98	16	53	35
99	20	53	38
100	20	53	38
101	20	53	38
102	20	53	38
103	20	53	38
104	20	53	38
105	24	53	38
106	24	53	38
107	24	53	38
108	24	53	38
109	30	53	38
110	30	53	38
111	30	53	38
112	30	53	38
113	36	53	38
114	36	53	38
115	36	53	38
116	36	53	38
119	38	3	38
982	13	65	13
1753	19	65	19
1231	116	75	30
1234	108	75	30
1232	101	75	30
950	101	75	30
1180	96	75	30
1206	94	75	20
1171	92	75	20
1046	83	75	20
947	82	75	20
1371	56	76	2
1369	49	76	2
1339	41	76	2
1305	43	76	142
1986	29	76	2
1135	106	77	47
1252	111	77	39
1147	110	77	39
1044	106	77	30
1108	101	77	30
1103	97	77	30
1244	88	75	30
957	65	75	30
1343	47	78	64
1271	24	78	64
1393	47	81	64
1451	60	25	9
1462	88	25	2
2278	124	82	82
2250	121	82	82
2277	121	82	82
2276	116	82	82
2265	116	82	82
2275	111	82	82
2273	111	82	82
2235	111	82	82
2270	111	82	82
2264	111	82	82
2274	106	82	82
2245	106	82	82
2272	106	82	82
2267	106	82	82
2269	106	82	82
2229	100	82	82
2271	100	82	82
2268	100	82	82
2266	100	82	82
2257	100	82	82
2144	121	33	88
2106	116	33	88
2140	111	33	88
124	96	6	47
125	98	6	47
126	100	6	47
127	106	21	47
128	111	21	47
129	111	21	54
130	116	21	47
132	121	21	54
131	121	21	47
133	124	21	47
134	125	21	54
135	127	21	47
136	127	21	54
137	130	21	47
138	131	21	54
139	100	21	47
140	111	21	47
141	121	21	54
142	121	86	54
143	127	86	54
144	131	86	54
145	133	86	54
146	133	86	54
147	98	86	47
148	109	86	47
149	111	86	47
150	111	86	47
151	116	86	47
152	122	86	47
153	126	86	47
154	127	86	47
155	130	86	47
156	132	91	65
157	168	91	65
158	148	89	65
159	130	89	65
160	134	89	65
161	127	87	82
162	127	87	82
163	130	87	82
164	130	87	82
165	133	87	82
166	135	87	82
167	137	87	82
168	127	87	82
169	127	88	82
170	127	88	82
171	130	88	82
172	130	88	82
173	133	88	82
174	133	88	82
175	135	88	82
176	135	88	82
177	137	88	82
178	137	88	82
179	139	88	82
180	139	88	82
181	133	88	82
182	130	64	82
183	47	92	9
184	47	92	9
185	47	92	9
186	53	92	7
187	54	92	9
188	60	92	9
189	65	92	9
190	65	92	9
191	53	92	7
192	54	92	9
197	62	92	169
194	60	92	6
200	65	92	9
201	65	92	9
202	80	92	170
203	82	92	9
204	82	92	9
205	84	92	171
206	85	92	6
207	86	92	9
208	88	92	9
209	88	92	9
210	88	92	9
211	88	92	9
212	82	92	9
213	88	92	9
214	88	92	9
215	88	92	9
216	88	92	9
2083	134	94	141
1719	128	94	141
983	28	96	28
1752	38	96	38
429	106	29	47
430	106	29	47
431	108	29	54
432	111	29	47
433	114	29	47
435	111	29	54
434	111	29	54
436	113	29	54
437	120	29	54
438	100	29	54
439	104	29	54
440	94	29	47
441	96	29	47
442	98	29	47
446	94	29	47
447	96	29	47
448	96	64	47
449	98	29	47
450	100	29	47
451	102	29	47
453	4	3	4
454	28	3	28
455	38	3	38
456	28	3	28
457	19	3	19
458	28	3	28
459	38	3	38
460	46	3	46
461	38	3	38
\.


--
-- Data for Name: processing_unit_cpu_socket; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processing_unit_cpu_socket (processing_unit_id, cpu_socket_id) FROM stdin;
996	13
710	33
709	7
720	7
725	7
728	7
729	7
732	7
776	7
779	7
780	7
781	7
784	7
785	7
747	7
735	7
821	7
822	7
827	7
829	7
830	7
831	7
795	7
796	7
724	7
828	7
812	7
721	7
730	7
731	7
778	7
786	7
775	7
773	7
1010	7
1011	7
1012	7
1013	7
1016	7
1017	7
1018	7
1014	7
709	6
720	6
725	6
728	6
729	6
732	6
776	6
779	6
780	6
781	6
784	6
785	6
747	6
735	6
821	6
822	6
827	6
829	6
830	6
831	6
795	6
796	6
724	6
828	6
812	6
721	6
730	6
731	6
778	6
786	6
775	6
773	6
1010	6
1011	6
1012	6
1013	6
1016	6
1017	6
1018	6
1014	6
709	5
720	5
725	5
728	5
729	5
732	5
776	5
779	5
780	5
781	5
784	5
785	5
747	5
735	5
821	5
822	5
827	5
829	5
830	5
831	5
795	5
796	5
724	5
828	5
812	5
721	5
730	5
731	5
778	5
786	5
775	5
773	5
1010	5
1011	5
1012	5
1013	5
1016	5
1017	5
1018	5
1014	5
755	5
757	5
760	5
759	5
761	5
739	5
740	5
743	5
756	5
754	5
737	5
797	5
799	5
800	5
766	5
788	5
787	5
777	5
726	5
984	5
1007	5
1015	5
1019	5
962	5
755	32
757	32
760	32
759	32
761	32
739	32
740	32
743	32
756	32
754	32
737	32
797	32
799	32
800	32
766	32
788	32
787	32
777	32
726	32
984	32
1007	32
1015	32
1019	32
962	32
755	6
757	6
760	6
759	6
761	6
739	6
740	6
743	6
756	6
754	6
737	6
797	6
799	6
800	6
766	6
788	6
787	6
777	6
726	6
984	6
1007	6
1015	6
1019	6
962	6
789	4
801	4
869	4
809	4
813	4
805	4
834	4
1021	4
1022	4
1023	4
1024	4
1025	4
1026	4
1027	4
1259	4
1258	4
1260	4
1261	4
1262	4
1263	4
1264	4
790	4
791	4
835	4
792	4
811	4
858	4
806	4
804	4
920	4
1028	4
1029	4
807	4
1265	4
1266	4
1267	4
1268	4
1269	4
1270	4
1271	4
1272	4
1273	4
1274	4
1276	4
1278	4
1280	4
1282	4
1285	4
1287	4
1298	4
1300	4
1302	4
1304	4
1307	4
1309	4
1314	4
1315	4
1316	4
1317	4
1319	4
1321	4
1323	4
1325	4
1329	4
1341	4
1343	4
1348	4
1350	4
1354	4
1358	4
1365	4
1368	4
1395	4
1396	4
1397	4
1398	4
1399	4
1401	4
789	3
801	3
869	3
809	3
813	3
805	3
834	3
1021	3
1022	3
1023	3
1024	3
1025	3
1026	3
1027	3
1259	3
1258	3
1260	3
1261	3
1262	3
1263	3
1264	3
1332	4
793	4
1331	4
956	4
1330	4
955	4
871	15
1448	15
1505	15
1506	15
1507	15
1508	15
1509	15
1510	15
872	14
873	14
874	14
877	14
878	14
879	14
922	14
958	14
959	14
1511	14
1512	14
1513	14
1514	14
1515	14
1516	14
1517	14
1518	14
1519	14
1520	14
1521	14
1522	14
1523	14
1524	14
1525	14
1526	14
1527	14
1528	14
1529	14
1530	14
1531	14
1532	14
1533	14
1534	14
1535	14
1536	14
1537	14
1538	14
1539	14
1540	14
1541	14
1542	14
1543	14
1544	14
1545	14
875	16
876	16
880	16
881	16
886	16
887	16
921	16
923	16
924	16
925	16
892	16
927	16
893	16
926	16
882	16
883	16
889	16
888	16
928	16
891	16
890	16
860	1
861	1
1006	1
1020	1
995	13
994	13
993	13
716	13
711	34
712	35
769	36
862	10
865	10
931	10
932	10
864	10
867	10
868	10
929	10
930	10
1383	10
1384	10
1386	10
1385	10
1387	10
1388	10
1389	10
1435	10
1436	10
1437	10
1438	10
1439	10
1440	10
1441	10
1442	10
1443	10
1444	10
1445	10
1446	10
1447	10
1464	10
1465	10
1466	10
1467	10
1468	10
1469	10
1470	10
1471	10
1472	10
1473	10
1474	10
1475	10
1476	10
1477	10
1478	10
1479	10
1480	10
1481	10
1482	10
1483	10
1484	10
1485	10
1486	10
1487	10
1488	10
1489	10
1490	10
1491	10
1492	10
1493	10
1494	10
1495	10
1496	10
1497	10
1498	10
1499	10
1500	10
1501	10
1502	10
1503	10
1504	10
859	11
810	11
863	11
866	11
1372	11
1373	11
1374	11
1375	11
1376	11
1377	11
1378	11
1379	11
1380	11
1381	11
1382	11
1390	11
1391	11
1392	11
1393	11
1394	11
1402	11
1403	11
1404	11
1406	11
1405	11
1434	11
1449	11
1450	11
1451	11
1452	11
1453	11
1454	11
1455	11
1456	11
1457	11
1458	11
1459	11
1460	11
1461	11
1462	11
1463	11
933	24
934	24
935	24
936	24
1407	24
1408	24
1409	24
1410	24
1411	24
1412	24
1413	24
1414	24
1415	24
1416	24
1417	24
1418	24
1419	24
1420	24
1421	24
1422	24
1423	24
1424	24
1425	24
1426	24
1427	24
1428	24
1429	24
1430	24
1431	24
1432	24
1433	24
894	23
895	23
1053	23
1054	23
1055	23
1056	23
1057	23
1058	23
1059	23
1060	23
1061	23
1062	23
1063	23
1064	23
1065	23
1066	23
1067	23
1068	23
1069	23
1070	23
1071	23
1072	23
1073	23
896	17
897	17
898	17
899	17
911	17
947	17
912	17
914	17
1031	17
1032	17
1033	17
1034	17
1035	17
1036	17
1037	17
1038	17
1039	17
1040	17
1041	17
1042	17
1043	17
1044	17
1045	17
1046	17
1047	17
1048	17
1049	17
1050	17
1051	17
1052	17
942	17
943	17
944	17
950	17
948	17
946	17
957	17
945	17
913	17
1074	17
1075	17
1076	17
1077	17
1079	17
1080	17
1081	17
1082	17
1083	17
1084	17
1085	17
1086	17
1087	17
1088	17
1089	17
1090	17
1091	17
1092	17
1093	17
1094	17
1095	17
1096	17
1097	17
1098	17
1099	17
1100	17
1101	17
1102	17
1103	17
1104	17
1105	17
1106	17
1107	17
1108	17
1109	17
1110	17
1112	17
1113	17
1114	17
1116	17
1117	17
1118	17
1119	17
1120	17
1121	17
1122	17
1123	17
1124	17
1125	17
1126	17
1127	17
1128	17
1129	17
1130	17
1131	17
1132	17
1133	17
1134	17
1135	17
1136	17
1137	17
1138	17
1139	17
1140	17
1141	17
1142	17
1144	17
1145	17
1111	17
1115	17
1146	17
1147	17
1148	17
1149	17
1150	17
1151	17
1152	17
1153	17
1154	17
1155	17
1156	17
1157	17
1158	17
1159	17
1160	17
1161	17
1162	17
1163	17
1164	17
1165	17
1166	17
1167	17
1168	17
1169	17
1170	17
1171	17
1172	17
1173	17
1174	17
1175	17
1176	17
1177	17
1178	17
1180	17
1181	17
1182	17
1183	17
1184	17
1185	17
1186	17
1187	17
1188	17
1189	17
1190	17
1191	17
1192	17
1193	17
1194	17
1195	17
1196	17
1197	17
1198	17
1199	17
1201	17
1202	17
1203	17
1204	17
1205	17
1206	17
1207	17
1208	17
1209	17
1210	17
1211	17
1212	17
1213	17
1200	17
1223	17
1224	17
1225	17
1226	17
1227	17
1228	17
1229	17
1230	17
1231	17
1232	17
1233	17
1234	17
1244	17
1245	17
1246	17
1247	17
1248	17
1249	17
1251	17
1252	17
1253	17
1254	17
1255	17
1179	17
1250	17
1256	17
1257	17
1078	17
1143	17
884	25
960	25
885	25
961	25
709	12
728	12
732	12
776	12
779	12
780	12
785	12
747	12
735	12
821	12
822	12
827	12
829	12
830	12
831	12
796	12
724	12
828	12
812	12
721	12
730	12
731	12
778	12
786	12
775	12
773	12
1010	12
1011	12
1012	12
1013	12
1016	12
1017	12
1018	12
1014	12
1567	28
1030	4
919	4
1275	4
1277	4
1279	4
1281	4
1283	4
1284	4
1286	4
1288	4
1289	4
1290	4
1291	4
1292	4
1293	4
1294	4
1295	4
1296	4
1297	4
1299	4
1301	4
1303	4
1305	4
1306	4
1308	4
1310	4
1311	4
1312	4
1313	4
1318	4
1320	4
1322	4
1324	4
1326	4
1327	4
1328	4
1333	4
1334	4
1335	4
918	4
1336	4
1337	4
1338	4
1339	4
1340	4
1342	4
1344	4
1346	4
1347	4
1349	4
1351	4
1352	4
1353	4
1355	4
1356	4
1357	4
1359	4
1360	4
1361	4
1362	4
1363	4
1364	4
1366	4
1367	4
1369	4
1370	4
1371	4
1400	4
1345	4
719	38
989	38
990	38
992	38
782	38
783	38
823	38
826	38
825	38
1569	38
1570	38
824	38
1571	38
1573	38
1564	16
1565	16
1566	16
1574	16
1575	16
1576	16
1577	16
1578	16
1579	16
1580	16
1581	16
1582	16
1583	16
1584	16
1585	16
1586	16
1587	16
1588	16
1589	16
1590	16
1591	16
1592	16
1593	16
1594	16
1595	16
1596	16
1597	16
1598	16
1599	16
1600	16
1601	16
1602	16
1603	16
1604	16
1605	16
1606	16
1607	16
1608	16
1609	16
1610	16
1611	16
1612	16
1613	16
969	28
968	30
965	28
967	29
964	28
980	29
1614	28
1615	28
1616	28
1617	28
1618	28
1619	28
1620	28
1621	28
1622	28
1623	39
1624	39
1625	39
1626	39
1627	39
1628	29
1630	29
1631	29
1632	30
1633	30
1634	30
976	29
1635	29
1636	29
1637	29
1638	29
977	30
1639	30
1640	30
1641	30
1642	30
1643	29
1645	29
1646	29
1647	29
1648	14
1649	14
1650	14
1651	14
1652	14
1653	14
1654	14
1655	14
1656	16
1657	16
1658	16
1659	16
1660	16
1661	16
1662	16
1663	16
1664	16
1665	16
1666	16
1667	16
1668	16
1669	16
1670	16
1671	16
1672	16
1673	16
1674	16
1675	16
1676	16
1677	16
1678	16
1679	16
1680	16
1681	16
1682	16
1683	16
1684	16
1685	16
1686	16
1687	16
1688	16
1689	16
1690	16
1691	16
1692	16
1693	16
1694	16
1695	16
1696	16
1697	16
1698	16
1699	16
1700	16
1701	16
1702	16
1703	16
1704	16
1705	16
1706	16
1707	16
1708	16
1709	16
1710	16
1711	16
1712	16
1713	16
1714	16
1715	16
1716	16
1717	16
1718	16
1719	16
1720	16
1721	16
1722	16
1723	16
1724	16
1725	16
1726	16
1727	16
1728	16
1729	16
1730	16
1731	16
1732	16
1733	16
1734	16
1735	16
1736	16
1737	16
1738	16
1739	16
1740	16
1741	16
1742	16
1743	16
1744	16
1745	16
1746	16
1747	16
1748	16
1749	7
1749	6
1749	5
1750	7
1750	6
1750	5
1751	7
1751	6
1751	5
979	30
982	43
1753	43
1754	43
1755	43
1756	30
1757	30
1758	30
1759	30
1760	30
1761	29
1762	29
1763	29
1764	30
1765	29
1766	29
1767	29
1768	30
1769	29
1770	29
1771	29
1772	29
1773	29
1774	30
1775	30
1776	29
1777	30
1778	29
1779	30
1780	29
1781	29
1782	29
1783	30
972	29
1784	29
1785	29
970	29
978	29
978	44
1786	29
1786	44
1787	30
1788	29
1789	29
1790	29
1791	29
1792	29
1793	30
1794	30
1795	30
1796	28
1797	28
1798	28
1799	28
1800	28
1801	28
1802	28
1803	28
1804	28
1805	28
1806	28
1807	28
1808	28
1809	28
1810	28
1811	28
1812	28
1813	28
1814	28
1815	28
1816	28
1817	28
1818	28
1819	39
1820	39
1821	45
1822	45
808	46
1823	46
1824	46
1825	46
1826	46
1827	46
1828	46
1829	46
1832	3
1832	4
1833	3
1833	4
1834	3
1834	4
1835	4
1836	4
1837	4
1838	4
1839	4
1840	4
1841	4
937	10
1842	10
1843	10
1844	10
1845	10
1846	10
1847	10
1848	10
1849	10
1850	10
1851	10
1852	10
1853	10
1854	10
1855	10
1856	10
1857	7
1858	10
1859	10
1860	10
1861	10
1862	10
1863	10
1864	10
1865	10
1866	10
1867	10
1868	10
1869	10
1870	10
1871	10
1872	10
1873	10
1874	10
1875	36
1876	36
1877	36
1878	36
1879	36
1880	36
1881	36
1882	36
1883	36
1884	47
1885	47
1886	47
1887	47
1888	47
1889	47
1890	47
1891	47
1892	47
1893	47
1894	47
1895	47
1896	47
1897	47
1898	48
1899	48
1900	48
1901	33
1902	33
1903	33
1904	33
1905	33
1906	33
1907	33
1908	33
1909	33
1910	33
1911	33
1912	33
1913	33
1914	37
1915	37
1916	37
1917	37
1918	37
1919	37
1920	34
1921	34
1922	34
1923	34
1924	34
1925	34
1926	34
1927	34
1928	34
1929	34
1930	35
1931	35
1932	35
1933	35
1934	35
1935	35
1936	35
1937	35
1938	35
798	38
794	37
1939	37
1940	37
1940	13
1939	13
794	13
1941	38
1942	38
1943	3
1943	4
1944	3
1944	4
1945	3
1945	4
1946	3
1946	4
1947	3
1947	4
1948	3
1948	4
1949	3
1949	4
1950	3
1950	4
1951	4
1952	4
1953	4
1954	4
1955	4
1956	4
1957	4
1958	4
1959	4
1960	4
1961	4
1962	4
1963	4
1964	4
1965	4
1966	4
1967	4
1968	4
1969	4
1970	4
1971	4
1972	4
1973	4
1974	4
1975	4
1976	4
1977	4
1978	4
1979	4
1980	4
1981	4
1982	4
1983	4
1984	4
1985	4
1986	4
1987	4
1988	4
1989	4
1990	4
1330	50
1991	50
1992	50
1993	50
1994	50
1995	50
1996	50
1997	50
714	31
985	31
985	30
985	29
986	31
986	30
986	29
988	31
988	29
988	30
1998	31
1998	29
1998	30
1999	30
2000	30
772	13
2001	13
2002	13
2003	13
771	13
2004	13
2005	13
2006	13
2007	13
2008	13
819	52
819	13
717	13
2009	38
2010	38
2011	38
2015	3
2015	4
2016	3
2016	4
2017	3
2017	4
2018	3
2018	4
2019	3
2019	4
2020	9
2021	4
2022	4
2023	4
1003	9
1000	9
999	9
998	9
997	9
814	9
1004	9
1005	9
2024	6
2024	5
2024	32
2025	6
2025	5
2025	32
2026	1
2026	5
2026	32
2027	40
2027	7
2027	6
2027	5
2028	12
2028	7
2028	6
2028	5
831	53
2029	12
2029	7
2029	6
2029	5
2029	53
2030	12
2030	7
2030	6
2030	5
2031	12
2031	7
2031	6
2031	5
2032	12
2032	7
2032	6
2032	5
2033	12
2033	7
2033	6
2033	5
2034	6
2034	5
2034	32
2035	6
2035	5
2035	32
2036	6
2036	5
2036	32
2036	53
799	53
962	53
2034	53
727	54
753	54
758	54
730	54
730	37
1016	37
1016	54
1010	54
2037	29
2037	31
2037	44
2038	31
2038	44
2038	29
2039	31
2039	44
2039	30
2040	31
2040	30
2040	44
2041	31
2041	30
2042	31
2042	30
2042	44
2043	31
2043	30
2043	44
2044	31
2044	30
2044	44
2045	31
2045	30
2045	44
2046	31
2046	30
2046	44
2047	31
2047	30
2047	44
2047	29
2046	29
2048	31
2048	30
2048	44
2048	29
2049	31
2049	30
2049	44
2049	29
2050	31
2050	30
2050	44
2050	29
2051	31
2051	30
2051	44
2051	29
2052	31
2052	30
2052	44
2052	29
2053	31
2053	30
2053	44
2053	29
2054	16
2055	16
2056	16
2057	16
2058	16
2059	16
2060	16
2061	16
2062	16
2063	16
2064	16
2065	16
2066	16
2067	16
2068	16
2069	16
2070	16
2072	16
2073	16
2074	16
2076	16
2077	16
2078	16
2079	16
2080	16
2081	16
2082	16
2083	16
900	19
2084	19
2085	19
2086	19
2087	19
2088	19
2089	19
2090	19
901	20
2091	20
2092	20
910	21
2093	21
2094	19
2095	19
2096	20
2097	19
2098	20
2099	19
2100	19
2101	19
2102	20
2103	20
2104	20
2105	20
2106	20
2107	19
2108	19
2109	19
2110	19
2111	19
2112	19
2113	19
2114	19
2115	19
2116	19
2117	19
2118	19
2119	19
2120	19
2121	19
2122	19
2123	19
2124	19
2125	19
2126	19
2127	19
2128	19
2129	19
953	19
2130	20
2131	20
2132	20
916	20
2133	20
2134	20
2135	20
2136	20
2137	20
2138	20
2139	20
2140	20
2141	20
2142	20
2143	20
2144	20
2145	20
2146	20
903	20
2147	20
2148	20
2149	20
905	20
2150	20
2151	20
2152	20
2153	20
2154	20
2155	20
2157	20
2158	20
2159	20
2160	20
907	20
2161	20
2163	20
2164	20
2165	20
2166	20
2167	20
2168	20
2169	20
2170	20
2171	20
2172	20
2174	20
904	22
902	22
2175	22
2176	22
2177	22
2178	22
2179	22
2180	22
2181	22
2182	22
2183	22
2184	22
2185	22
2186	22
2187	22
2188	22
2189	22
2191	22
2192	22
2193	22
917	22
2194	22
2195	22
2196	22
2197	22
2198	22
2199	22
2200	22
2201	22
2202	22
2203	22
2204	22
2205	22
2206	22
2207	22
2208	22
2209	22
2210	22
2211	22
2212	22
2212	55
2212	56
2194	55
917	55
2200	55
2202	55
2195	55
2196	55
2201	55
2209	55
2204	55
2197	55
2198	55
2203	55
2205	55
2210	55
2206	55
2199	55
2207	55
2211	55
2208	55
2191	55
2183	55
2192	55
902	55
2184	55
909	22
909	55
2175	55
2193	55
906	22
906	55
2176	55
2179	55
2182	55
2185	55
2180	55
2177	55
2186	55
2178	55
2181	55
2188	55
2187	55
904	55
2189	55
2213	22
2213	55
2213	56
2215	22
2215	55
2215	56
2216	22
2216	55
2216	56
2217	22
2217	55
2217	56
2218	22
2218	55
2218	56
2219	19
2220	19
2221	19
1221	19
952	19
1220	19
2222	19
2223	19
2224	19
2225	19
2226	19
2227	19
2228	19
2229	19
2230	19
2231	19
2232	19
2233	19
2234	19
2235	19
2236	19
2237	19
2238	19
2239	19
2240	19
2241	19
2242	19
954	19
2243	19
2244	19
2245	19
2246	19
2247	19
2248	19
2250	19
2251	19
2252	19
2253	19
2254	19
2255	19
2256	19
2257	19
2258	19
2259	19
2260	19
2261	19
2262	19
2263	19
2264	19
2265	19
2266	19
2267	19
2268	19
2269	19
2270	19
2271	19
2272	19
2273	19
2274	19
2275	19
2276	19
2277	19
2278	19
2279	22
2279	55
2280	22
2280	55
2281	22
2281	55
2282	22
2282	55
2283	22
2283	55
2284	22
2284	55
2285	22
2285	55
2286	22
2286	55
2287	22
2287	55
2288	22
2288	55
2289	22
2289	55
2290	22
2290	55
2291	22
2291	55
2292	22
2292	55
2293	22
2293	55
2294	22
2294	55
2295	22
2295	55
2296	22
2296	55
2297	22
2297	55
2298	22
2298	55
2299	22
2299	55
2300	22
2300	55
2301	22
2301	55
2302	22
2302	55
2303	22
2303	55
2304	22
2304	55
2305	22
2305	55
2306	22
2306	55
2307	22
2307	55
2308	22
2308	55
2309	22
2309	55
2310	22
2310	55
2311	22
2311	55
2312	22
2312	55
2313	22
2313	55
2315	22
2315	55
2317	22
2317	55
2318	22
2318	55
2319	22
2319	55
2320	22
2320	55
2321	22
2321	55
2322	22
2322	55
2323	22
2323	55
2324	22
2324	55
2325	22
2325	55
2326	22
2326	55
2327	22
2327	55
2328	22
2328	55
2329	22
2329	55
2330	22
2330	55
2331	22
2331	55
2332	25
2333	25
2334	25
2335	25
2336	25
2337	25
2338	25
2339	25
2340	25
2341	25
2342	28
2343	28
2344	28
2345	28
733	28
2346	28
2347	28
833	28
2348	28
2349	28
734	28
832	28
980	43
970	43
977	43
976	43
1635	43
1636	43
1638	43
1765	43
967	43
1630	43
1631	43
1553	14
1552	14
1551	14
1550	14
1549	14
1548	14
1547	14
1557	14
1558	14
1562	14
1563	14
1555	16
1554	14
1561	14
1560	14
1559	14
1766	43
1784	43
1785	43
1628	43
1637	43
1643	43
1645	43
1646	43
1647	43
1761	43
1763	43
1767	43
972	43
978	43
1786	43
1788	43
1789	43
1790	43
1791	43
1792	43
59	25
60	25
61	25
62	2
63	2
64	2
65	2
66	2
67	2
68	2
69	2
71	50
72	4
73	50
74	4
75	50
76	4
77	50
78	4
79	50
80	4
81	4
82	4
83	50
84	50
85	4
86	50
87	4
88	50
89	4
90	50
91	4
92	50
95	50
96	50
97	4
98	4
99	50
100	50
101	4
102	4
103	4
104	4
105	50
106	50
107	4
108	4
109	50
110	50
111	4
112	4
113	4
114	4
115	50
116	50
119	13
120	26
121	26
122	26
123	26
124	26
125	26
126	26
127	26
128	26
129	27
130	26
131	26
132	27
133	26
134	27
135	26
136	27
137	26
138	27
139	27
140	27
141	27
142	27
143	27
144	27
145	27
146	27
147	26
148	26
149	26
150	27
151	26
152	26
153	26
154	26
155	26
156	27
157	27
158	27
159	27
160	27
161	27
162	27
163	27
164	27
165	27
166	27
167	27
168	27
169	27
170	27
171	27
172	27
173	27
174	27
175	27
176	27
177	27
178	27
179	27
180	27
181	27
182	27
183	8
184	8
185	8
186	8
187	8
188	8
189	8
190	8
191	8
192	8
194	8
197	8
200	8
201	57
202	8
203	8
204	8
205	8
206	8
207	8
208	8
209	8
210	8
211	8
212	57
213	57
214	57
215	57
216	57
1751	40
1750	40
1749	40
1752	58
983	58
991	38
747	40
735	40
785	40
724	40
828	40
812	40
721	40
730	40
731	40
829	40
831	40
827	40
830	40
778	40
786	40
775	40
773	40
776	40
779	40
780	40
709	40
720	40
732	40
729	40
728	40
725	40
796	40
795	40
822	40
781	40
784	40
1010	40
1011	40
1012	40
1013	40
1016	40
1017	40
1018	40
1014	40
2028	40
2029	40
2030	40
2031	40
2033	40
2032	40
821	40
429	25
430	25
431	25
432	25
433	25
434	25
435	25
436	25
437	25
438	25
439	25
440	25
441	25
442	25
446	25
447	25
448	25
449	25
450	25
451	25
453	13
454	37
455	37
456	13
457	37
458	37
459	37
460	37
461	13
\.


--
-- Data for Name: processing_unit_instruction_set; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processing_unit_instruction_set (processing_unit_id, instruction_set_id) FROM stdin;
726	0
726	1
726	2
726	3
726	4
716	3
766	4
859	6
859	9
766	16
724	4
724	16
984	4
984	16
771	4
714	2
985	2
986	2
734	0
987	2
988	2
719	3
989	3
990	3
991	3
992	3
832	0
833	0
993	3
994	3
995	3
996	3
828	4
814	6
997	6
998	6
860	5
999	6
1000	6
1003	6
810	6
810	7
1004	6
1004	7
1005	6
1005	7
861	5
1006	5
958	6
958	9
958	10
872	6
872	25
872	7
872	9
872	10
873	6
873	25
873	7
873	9
873	10
958	25
958	7
863	6
863	7
933	6
933	7
934	6
934	25
934	7
934	9
935	6
935	25
935	7
935	9
936	6
936	25
936	7
936	9
866	6
866	25
866	7
866	9
862	6
862	25
862	7
862	10
923	6
923	25
923	7
923	9
923	10
922	6
922	25
922	7
922	9
922	10
921	11
921	6
921	25
921	7
921	20
921	9
921	10
921	17
892	11
892	6
892	25
892	7
892	20
892	9
892	10
892	17
892	18
892	24
960	6
960	25
960	7
960	9
960	10
927	11
927	6
927	25
927	7
927	20
927	9
927	10
927	17
927	18
927	24
864	6
864	7
887	11
887	6
887	25
887	7
887	20
887	9
887	10
887	17
875	6
875	25
875	7
875	9
875	10
875	17
893	11
893	6
893	25
893	7
893	20
893	9
893	10
893	17
893	19
893	18
893	24
867	6
867	25
867	7
867	9
871	6
871	25
871	7
871	9
871	10
879	6
879	25
879	7
879	9
879	10
879	17
878	6
878	25
878	7
878	9
878	10
877	6
877	25
877	7
877	9
877	10
868	6
868	25
868	7
868	9
876	11
876	6
876	25
876	7
876	20
876	9
876	10
876	17
874	6
874	25
874	7
874	9
874	10
874	17
959	6
959	25
959	7
959	9
959	10
959	17
881	11
881	6
881	25
881	7
881	20
881	9
881	10
881	17
926	11
926	6
926	25
926	7
926	20
926	9
926	10
926	17
926	18
926	24
869	5
869	7
880	6
880	25
880	7
880	20
880	9
880	10
880	17
865	6
865	25
865	7
865	9
882	11
882	6
882	25
882	7
882	20
882	9
882	10
882	17
882	18
883	11
883	6
883	25
883	7
883	20
883	9
883	10
883	17
883	18
883	24
889	11
889	6
889	25
889	7
889	20
889	9
889	10
889	17
889	19
889	18
889	24
888	11
888	6
888	25
888	7
888	20
888	9
888	10
888	17
888	18
888	24
886	11
886	6
886	25
886	7
886	20
886	9
886	10
886	17
925	11
925	6
925	25
925	7
925	20
925	9
925	10
925	17
925	24
928	11
928	6
928	25
928	7
928	20
928	9
928	10
928	17
928	19
928	18
928	24
891	11
891	6
891	25
891	7
891	20
891	9
891	10
891	17
891	18
890	11
890	6
890	25
890	7
890	20
890	9
890	10
890	17
890	18
890	24
924	11
924	6
924	25
924	7
924	20
924	9
924	10
924	17
809	5
884	6
884	25
884	7
884	9
884	10
885	6
885	25
885	7
885	9
885	10
961	6
961	25
961	7
961	9
961	10
811	5
811	7
812	5
920	5
920	7
813	5
726	16
1007	4
1007	16
818	3
1008	3
1009	3
733	0
721	4
721	16
1010	4
1010	16
1011	4
1011	16
1012	4
1012	16
1013	4
1013	16
1014	4
1014	16
1015	4
1015	16
730	4
1016	4
1017	4
1018	4
1019	4
1019	16
1020	5
1021	5
1022	5
1023	5
1024	5
1025	5
1026	5
1027	5
1028	5
1028	7
1029	5
1029	7
731	4
929	8
929	5
929	7
930	8
930	5
930	7
918	8
918	5
918	7
919	8
919	5
919	7
858	8
858	6
858	7
1030	8
1030	5
1030	7
805	5
807	8
807	5
807	7
806	5
806	7
894	8
894	6
894	25
894	7
895	8
895	22
895	6
895	25
895	7
896	8
896	22
896	6
896	25
896	7
897	8
897	22
897	6
897	25
897	7
897	9
898	8
898	22
898	6
898	25
898	7
898	9
899	8
899	22
899	6
899	25
899	7
899	9
942	8
942	22
942	6
942	25
942	7
942	9
943	8
943	22
943	6
943	25
943	7
943	9
944	8
944	22
944	6
944	25
944	7
944	9
949	8
949	22
949	6
949	25
949	7
949	9
950	8
950	22
950	6
950	25
950	7
950	9
951	8
951	22
951	6
951	25
951	7
951	9
952	8
952	22
952	6
952	25
952	7
952	20
952	9
952	10
948	8
948	22
948	6
948	25
948	7
948	9
946	8
946	22
946	6
946	25
946	7
946	9
900	8
900	22
900	11
900	6
900	25
900	7
900	20
900	9
900	10
901	8
901	22
901	11
901	6
901	25
901	7
901	20
901	9
901	10
957	8
957	22
957	6
957	25
957	7
957	9
902	8
902	22
902	11
902	6
902	25
902	7
902	20
902	9
902	10
902	17
902	24
945	8
945	22
945	6
945	25
945	7
913	8
913	22
913	6
913	25
913	7
913	9
911	8
911	22
911	6
911	25
911	7
916	8
916	22
916	11
916	6
916	25
916	7
916	20
916	9
916	10
916	17
904	8
904	22
904	11
904	6
904	25
904	7
904	20
904	9
904	10
904	17
904	24
905	8
905	22
905	11
905	6
905	25
905	7
905	20
905	9
905	10
905	17
915	8
915	22
915	6
915	25
915	7
915	20
915	9
915	10
906	8
906	22
906	11
906	6
906	25
906	7
906	9
906	10
906	17
906	24
947	8
947	22
947	6
947	25
947	7
947	9
907	8
907	22
907	11
907	6
907	25
907	7
907	20
907	9
907	10
907	17
908	8
908	22
908	11
908	6
908	25
908	7
908	20
908	9
908	10
912	8
912	22
912	6
912	25
912	7
912	9
903	8
903	22
903	11
903	6
903	25
903	7
903	20
903	9
903	10
903	17
910	8
910	22
910	11
910	6
910	25
910	7
910	20
910	9
910	10
914	8
914	22
914	6
914	25
914	7
914	9
917	8
917	22
917	11
917	6
917	25
917	7
917	20
917	9
917	10
917	17
953	8
953	22
953	11
953	6
953	25
953	7
953	20
953	9
953	10
909	8
909	22
909	11
909	6
909	25
909	7
909	20
909	9
909	10
909	17
909	24
954	8
954	22
954	11
954	6
954	25
954	7
954	20
954	9
954	10
954	17
1031	8
1031	22
1031	6
1031	12
1031	7
1032	8
1032	22
1032	6
1032	25
1032	7
1033	8
1033	22
1033	6
1033	25
1033	7
1034	8
1034	22
1034	6
1034	25
1034	7
1035	8
1035	22
1035	6
1035	25
1035	7
1036	8
1036	22
1036	6
1036	25
1036	7
1037	8
1037	22
1037	6
1037	25
1037	7
1038	8
1038	22
1038	6
1038	25
1038	7
1039	8
1039	22
1039	6
1039	25
1039	7
1039	9
1040	8
1040	22
1040	6
1040	25
1040	7
1041	8
1041	22
1041	6
1041	25
1041	7
1042	8
1042	22
1042	6
1042	25
1042	7
1043	8
1043	22
1043	6
1043	25
1043	7
1044	8
1044	22
1044	6
1044	25
1044	7
1044	9
1043	9
1042	9
1041	9
1040	9
1038	9
1045	8
1045	22
1045	6
1045	25
1045	7
1046	8
1046	22
1046	6
1046	25
1046	7
1046	9
1047	8
1047	22
1047	6
1047	25
1047	7
1047	9
1048	8
1048	22
1048	6
1048	25
1048	7
1048	9
1049	8
1049	22
1049	6
1049	25
1049	7
1049	9
1050	8
1050	22
1050	6
1050	25
1050	7
1050	9
1051	8
1051	22
1051	6
1051	25
1051	7
1051	9
1052	8
1052	22
1052	6
1052	25
1052	7
1052	9
1053	8
1053	22
1053	6
1053	25
1053	7
1054	8
1054	22
1054	6
1054	25
1054	7
1055	8
1055	22
1055	6
1055	25
1055	7
1056	8
1056	22
1056	6
1056	25
1056	7
1057	8
1057	22
1057	6
1057	25
1057	7
1058	8
1058	22
1058	6
1058	25
1058	7
1059	8
1059	22
1059	6
1059	25
1059	7
1060	8
1060	22
1060	6
1060	25
1060	7
1061	8
1061	22
1061	6
1061	25
1061	7
1062	8
1062	22
1062	6
1062	25
1062	7
1063	8
1063	22
1063	6
1063	25
1063	7
1064	8
1064	22
1064	6
1064	25
1064	7
1065	8
1065	22
1065	6
1065	25
1065	7
1066	8
1066	22
1066	6
1066	25
1066	7
1067	8
1067	22
1067	6
1067	25
1067	7
1068	8
1068	22
1068	6
1068	25
1068	7
1069	8
1069	22
1069	6
1069	25
1069	7
1070	8
1070	22
1070	6
1070	25
1070	7
1071	8
1071	22
1071	6
1071	25
1071	7
1072	8
1072	22
1072	6
1072	25
1072	7
1073	8
1073	22
1073	6
1073	25
1073	7
1074	8
1074	22
1074	6
1074	25
1074	7
1075	8
1075	22
1075	6
1075	25
1075	7
1076	8
1076	22
1076	6
1076	25
1076	7
1077	8
1077	22
1077	6
1077	25
1077	7
1078	8
1078	22
1078	6
1078	25
1078	7
1079	8
1079	22
1079	6
1079	25
1079	7
1080	8
1080	22
1080	6
1080	25
1080	7
1081	8
1081	22
1081	6
1081	25
1081	7
1082	8
1082	22
1082	6
1082	25
1082	7
1083	8
1083	22
1083	6
1083	25
1083	7
1084	8
1084	22
1084	6
1084	25
1084	7
1085	8
1085	22
1085	6
1085	25
1085	7
1086	8
1086	22
1086	6
1086	25
1086	7
1087	8
1087	22
1087	6
1087	25
1087	7
1088	8
1088	22
1088	6
1088	25
1088	7
1089	8
1089	22
1089	6
1089	25
1089	7
1090	8
1090	22
1090	6
1090	25
1090	7
1091	8
1091	22
1091	6
1091	25
1091	7
1092	8
1092	22
1092	6
1092	25
1092	7
1092	9
1093	8
1093	22
1093	6
1093	25
1093	7
1093	9
1094	8
1094	22
1094	6
1094	25
1094	7
1094	9
1095	8
1095	22
1095	6
1095	25
1095	7
1095	9
1096	8
1096	22
1096	6
1096	25
1096	7
1096	9
1097	8
1097	22
1097	6
1097	25
1097	7
1097	9
1098	8
1098	22
1098	6
1098	25
1098	7
1098	9
1099	8
1099	22
1099	6
1099	25
1099	7
1099	9
1100	8
1100	22
1100	6
1100	25
1100	7
1100	9
1101	8
1101	22
1101	6
1101	25
1101	7
1101	9
1102	8
1102	22
1102	6
1102	25
1102	7
1102	9
1103	8
1103	22
1103	6
1103	25
1103	7
1103	9
1104	8
1104	22
1104	6
1104	25
1104	7
1104	9
1105	8
1105	22
1105	6
1105	25
1105	7
1105	9
1106	8
1106	22
1106	6
1106	25
1106	7
1106	9
1107	8
1107	22
1107	6
1107	25
1107	7
1107	9
1108	8
1108	22
1108	6
1108	25
1108	7
1108	9
1109	8
1109	22
1109	6
1109	25
1109	7
1109	9
1110	8
1110	22
1110	6
1110	25
1110	7
1110	9
1111	8
1111	22
1111	6
1111	25
1111	7
1111	9
1112	8
1112	22
1112	6
1112	25
1112	7
1112	9
1113	8
1113	22
1113	6
1113	25
1113	7
1113	9
1114	8
1114	22
1114	6
1114	25
1114	7
1114	9
1115	8
1115	22
1115	6
1115	25
1115	7
1115	9
1116	8
1116	22
1116	6
1116	25
1116	7
1116	9
1117	8
1117	22
1117	6
1117	25
1117	7
1117	9
1118	8
1118	22
1118	6
1118	25
1118	7
1118	9
1119	8
1119	22
1119	6
1119	25
1119	7
1119	9
1120	8
1120	22
1120	6
1120	25
1120	7
1120	9
1121	8
1121	22
1121	6
1121	25
1121	7
1121	9
1122	8
1122	22
1122	6
1122	25
1122	7
1122	9
1123	8
1123	22
1123	6
1123	25
1123	7
1123	9
1124	8
1124	22
1124	6
1124	25
1124	7
1124	9
1125	8
1125	22
1125	6
1125	25
1125	7
1125	9
1126	8
1126	22
1126	6
1126	25
1126	7
1126	9
1127	8
1127	22
1127	6
1127	25
1127	7
1127	9
1128	8
1128	22
1128	6
1128	25
1128	7
1128	9
1129	8
1129	22
1129	6
1129	25
1129	7
1129	9
1130	8
1130	22
1130	6
1130	25
1130	7
1130	9
1131	8
1131	22
1131	6
1131	7
1131	9
1132	8
1132	22
1132	6
1132	25
1132	7
1132	9
1133	8
1133	22
1133	0
1133	25
1133	7
1133	9
1134	8
1134	22
1134	6
1134	7
1134	9
1135	8
1135	22
1135	6
1135	25
1135	7
1135	9
1136	8
1136	22
1136	6
1136	25
1136	7
1136	9
1137	8
1137	22
1137	6
1137	25
1137	7
1137	9
1138	8
1138	22
1138	6
1138	25
1138	7
1138	9
1139	8
1139	22
1139	6
1139	25
1139	7
1139	9
1140	8
1140	22
1140	6
1140	25
1140	7
1140	9
1141	8
1141	22
1141	6
1141	25
1141	7
1141	9
1142	8
1142	22
1142	6
1142	25
1142	7
1142	9
1143	8
1143	22
1143	6
1143	25
1143	7
1143	9
1144	8
1144	22
1144	6
1144	25
1144	7
1144	9
1145	8
1145	22
1145	6
1145	25
1145	7
1145	9
1146	8
1146	22
1146	6
1146	25
1146	7
1146	9
1147	8
1147	22
1147	6
1147	25
1147	7
1147	9
1148	8
1148	22
1148	6
1148	25
1148	7
1148	9
1149	8
1149	22
1149	6
1149	25
1149	7
1149	9
1150	8
1150	22
1150	6
1150	25
1150	7
1150	9
1151	8
1151	22
1151	6
1151	25
1151	7
1151	9
1152	8
1152	22
1152	6
1152	25
1152	7
1152	9
1153	8
1153	22
1153	6
1153	25
1153	7
1153	9
1154	8
1154	22
1154	6
1154	25
1154	7
1154	9
1155	8
1155	22
1155	6
1155	25
1155	7
1155	9
1156	8
1156	22
1156	6
1156	25
1156	7
1156	9
1157	8
1157	22
1157	6
1157	25
1157	7
1157	9
1158	8
1158	22
1158	6
1158	7
1158	9
1159	8
1159	22
1159	6
1159	25
1159	7
1159	9
1160	8
1160	22
1160	6
1160	25
1160	7
1160	9
1161	8
1161	22
1161	6
1161	25
1161	7
1161	9
1162	8
1162	22
1162	6
1162	25
1162	7
1162	9
1163	8
1163	22
1163	6
1163	25
1163	7
1163	9
1164	8
1164	22
1164	6
1164	25
1164	7
1164	9
1165	8
1165	22
1165	6
1165	25
1165	7
1165	9
1166	8
1166	22
1166	6
1166	25
1166	7
1166	9
1167	8
1167	22
1167	6
1167	25
1167	7
1167	9
1168	8
1168	22
1168	6
1168	25
1168	7
1168	9
1169	8
1169	22
1169	6
1169	25
1169	7
1169	9
1170	8
1170	22
1170	6
1170	25
1170	7
1170	9
1171	8
1171	22
1171	6
1171	25
1171	7
1171	9
1172	8
1172	22
1172	6
1172	25
1172	7
1172	9
1173	8
1173	22
1173	6
1173	25
1173	7
1173	9
1174	8
1174	22
1174	6
1174	25
1174	7
1174	9
1175	8
1175	22
1175	6
1175	25
1175	7
1175	9
1176	8
1176	22
1176	6
1176	25
1176	7
1176	9
1177	8
1177	22
1177	6
1177	25
1177	7
1177	9
1178	8
1178	22
1178	6
1178	25
1178	7
1178	9
1179	8
1179	22
1179	6
1179	25
1179	7
1179	9
1180	8
1180	22
1180	6
1180	25
1180	7
1180	9
1181	8
1181	22
1181	6
1181	25
1181	7
1181	9
1182	8
1182	22
1182	6
1182	25
1182	7
1182	9
1183	8
1183	22
1183	6
1183	25
1183	7
1183	9
1184	8
1184	22
1184	6
1184	25
1184	7
1184	9
1185	8
1185	22
1185	6
1185	25
1185	7
1185	9
1186	8
1186	22
1186	6
1186	25
1186	7
1186	9
1187	8
1187	22
1187	6
1187	25
1187	7
1187	9
1188	8
1188	22
1188	6
1188	25
1188	7
1188	9
1189	8
1189	22
1189	6
1189	25
1189	7
1189	9
1190	8
1190	22
1190	6
1190	25
1190	7
1190	9
1191	8
1191	22
1191	6
1191	25
1191	7
1191	9
1192	8
1192	22
1192	6
1192	25
1192	7
1192	9
1193	8
1193	22
1193	6
1193	25
1193	7
1193	9
1194	8
1194	22
1194	0
1194	25
1194	7
1194	9
1195	8
1195	22
1195	6
1195	25
1195	7
1195	9
1196	8
1196	22
1196	6
1196	25
1196	7
1196	9
1197	8
1197	22
1197	6
1197	25
1197	7
1197	9
1198	8
1198	22
1198	6
1198	25
1198	7
1198	9
1199	8
1199	22
1199	6
1199	25
1199	7
1199	9
1200	8
1200	22
1200	6
1200	25
1200	7
1200	9
1201	8
1201	22
1201	6
1201	25
1201	7
1201	9
1202	8
1202	22
1202	6
1202	7
1202	9
1203	8
1203	22
1203	6
1203	25
1203	7
1203	9
1204	8
1204	22
1204	6
1204	25
1204	7
1204	9
1205	8
1205	22
1205	6
1205	25
1205	7
1205	9
1206	8
1206	22
1206	6
1206	25
1206	7
1206	9
1207	8
1207	22
1207	6
1207	25
1207	7
1207	9
1208	8
1208	22
1208	6
1208	25
1208	7
1208	30
1209	8
1209	22
1209	6
1209	25
1209	7
1209	9
1210	8
1210	22
1210	6
1210	25
1210	20
1210	9
1211	8
1211	22
1211	6
1211	25
1211	7
1211	9
1212	8
1212	22
1212	6
1212	25
1212	7
1212	9
1213	8
1213	22
1213	6
1213	25
1213	7
1213	9
1214	8
1214	22
1214	6
1214	25
1214	7
1214	9
1215	8
1215	22
1215	6
1215	25
1215	7
1215	9
1216	8
1216	22
1216	6
1216	25
1216	7
1216	9
1217	8
1217	22
1217	6
1217	25
1217	7
1217	9
1218	8
1218	22
1218	6
1218	25
1218	7
1218	9
1219	8
1219	22
1219	6
1219	25
1219	7
1219	9
1222	8
1222	22
1222	6
1222	25
1222	7
1222	9
1221	8
1221	22
1221	6
1221	25
1221	7
1221	20
1221	9
1221	10
1220	8
1220	22
1220	6
1220	25
1220	7
1220	20
1220	9
1220	10
1223	8
1223	22
1223	6
1223	25
1223	7
1223	9
1224	8
1224	22
1224	6
1224	25
1224	7
1224	9
1225	8
1225	22
1225	6
1225	25
1225	7
1225	10
1226	8
1226	22
1226	6
1226	25
1226	7
1226	9
1227	8
1227	22
1227	6
1227	25
1227	7
1227	10
1228	8
1228	22
1228	6
1228	25
1228	7
1228	9
1229	8
1229	22
1229	6
1229	25
1229	7
1229	9
1230	8
1230	22
1230	6
1230	25
1230	7
1230	9
1231	8
1231	22
1231	6
1231	25
1231	7
1231	9
1232	8
1232	22
1232	6
1232	25
1232	7
1232	9
1233	8
1233	22
1233	6
1233	25
1233	7
1233	9
1234	8
1234	22
1234	6
1234	25
1234	7
1234	9
1235	8
1235	22
1235	6
1235	25
1235	7
1235	9
1236	8
1236	22
1236	6
1236	25
1236	7
1236	9
1237	8
1237	22
1237	6
1237	25
1237	7
1237	9
1238	8
1238	22
1238	6
1238	25
1238	7
1238	9
1241	8
1241	22
1241	6
1241	25
1241	7
1241	9
1240	8
1240	22
1240	6
1240	25
1240	7
1240	9
1242	8
1242	22
1242	6
1242	25
1242	7
1242	9
1239	8
1239	22
1239	6
1239	25
1239	7
1239	9
1243	8
1243	22
1243	6
1243	25
1243	7
1243	9
1244	8
1244	22
1244	6
1244	25
1244	7
1244	9
1245	8
1245	22
1245	6
1245	7
1245	9
1246	8
1246	22
1246	6
1246	25
1246	7
1246	9
1247	8
1247	22
1247	6
1247	25
1247	7
1247	9
1248	8
1248	22
1248	6
1248	25
1248	7
1248	9
1249	8
1249	22
1249	6
1249	25
1249	7
1249	9
1250	8
1250	22
1250	6
1250	25
1250	7
1250	9
1251	8
1251	22
1251	6
1251	25
1251	7
1251	9
1252	8
1252	22
1252	6
1252	25
1252	7
1252	9
1253	8
1253	22
1253	6
1253	25
1253	7
1253	9
1254	8
1254	22
1254	6
1254	25
1254	7
1254	9
1255	8
1255	22
1255	6
1255	25
1255	7
1255	9
1256	8
1256	22
1256	6
1256	25
1256	7
1256	9
1257	8
1257	22
1257	5
1257	25
1257	7
1257	9
1258	5
1259	5
1260	5
1261	5
1262	5
1263	5
1264	5
1265	5
1265	7
1266	5
1266	7
1267	5
1267	7
1268	5
1268	7
1269	5
1269	7
1270	5
1270	7
1271	5
1271	7
1272	5
1272	7
1273	5
1273	7
1274	8
1274	5
1274	7
1275	8
1275	5
1275	7
1276	8
1276	5
1276	7
1277	8
1277	5
1277	7
1278	8
1278	6
1278	7
1279	8
1279	5
1279	7
1280	8
1280	5
1280	7
1281	8
1281	5
1281	7
1282	8
1282	5
1282	7
1283	8
1283	5
1283	7
1284	8
1284	5
1284	7
1285	8
1285	5
1285	7
1286	8
1286	5
1286	7
1287	8
1287	5
1287	7
1288	8
1288	5
1288	7
1289	8
1289	5
1289	7
1290	8
1290	5
1290	7
1291	8
1291	5
1291	7
1292	8
1292	5
1292	7
1293	8
1293	5
1293	7
1294	8
1294	5
1294	7
1295	8
1295	5
1295	7
1296	8
1296	5
1296	7
1297	8
1297	5
1297	7
1298	8
1298	5
1298	7
1299	8
1299	5
1299	7
1300	8
1300	5
1300	7
1301	8
1301	5
1301	7
1302	8
1302	5
1302	7
1303	8
1303	5
1303	7
1304	8
1304	5
1304	7
1305	8
1305	5
1305	7
1306	8
1306	5
1306	7
1307	8
1307	5
1307	7
1308	8
1308	5
1308	7
1309	8
1309	5
1309	7
1310	8
1310	5
1310	7
1311	8
1311	5
1311	7
1312	8
1312	5
1312	7
1313	8
1313	5
1313	7
1314	8
1314	5
1314	7
1315	8
1315	5
1315	7
1316	8
1316	5
1316	7
1317	8
1317	5
1317	7
1318	8
1318	5
1318	7
1319	8
1319	5
1319	7
1320	8
1320	5
1320	7
1321	8
1321	5
1321	7
1322	8
1322	5
1322	7
1323	8
1323	5
1323	7
1324	8
1324	5
1324	7
1325	8
1325	5
1325	7
1326	8
1326	5
1326	7
1327	8
1327	5
1327	7
1328	8
1328	5
1328	7
1329	8
1329	5
1329	7
1330	7
955	7
956	7
1331	7
793	7
1332	4
1332	16
1332	7
832	29
833	29
1333	8
1333	6
1333	7
1334	8
1334	5
1334	7
1335	8
1335	5
1335	7
1336	8
1336	5
1336	9
1337	8
1337	6
1337	7
1338	8
1338	5
1338	7
1339	8
1339	5
1339	7
1340	8
1340	5
1340	7
1341	8
1341	5
1341	7
1342	8
1342	5
1342	7
1343	8
1343	5
1343	7
1344	8
1344	5
1344	7
1345	8
1345	5
1345	7
1346	8
1346	5
1346	7
1347	8
1347	5
1347	7
1348	8
1348	5
1348	7
1349	8
1349	5
1349	7
1350	8
1350	5
1350	7
1351	8
1351	5
1351	7
1352	8
1352	6
1352	7
1353	8
1353	5
1353	7
1354	8
1354	5
1354	7
1355	8
1355	5
1355	7
1356	8
1356	5
1356	7
1357	8
1357	5
1357	7
1358	8
1358	5
1358	7
1359	8
1359	5
1359	7
1360	8
1360	5
1360	7
1361	8
1361	5
1361	7
1362	8
1362	5
1362	7
1363	8
1363	5
1363	7
1364	8
1364	5
1364	7
1365	8
1365	5
1365	7
1366	8
1366	5
1366	7
1367	8
1367	5
1367	7
1368	8
1368	5
1368	7
1369	8
1369	5
1369	7
1370	8
1370	5
1370	7
1371	8
1371	5
1371	7
1372	6
1372	7
1373	6
1373	7
1374	6
1374	7
1375	6
1375	7
1376	6
1376	7
1377	6
1377	7
1378	6
1378	7
1379	6
1379	7
1380	6
1380	7
1381	6
1381	7
1382	6
1382	7
1383	6
1383	7
1384	6
1384	7
1385	6
1385	7
1386	6
1386	7
1387	6
1387	7
1388	6
1388	7
1389	6
1389	7
1390	6
1390	7
1391	6
1391	7
1392	6
1392	7
1393	6
1393	7
1394	6
1394	7
1395	5
1395	7
1396	5
1396	7
1397	5
1397	7
1398	5
1398	7
1399	8
1399	5
1399	7
1400	8
1400	5
1400	7
1401	8
1401	5
1401	7
1402	6
1402	7
1403	6
1403	9
1404	6
1404	9
1405	6
1405	9
969	12
1406	6
1406	7
1406	9
859	7
1402	9
1403	7
1404	7
1405	7
1407	6
1407	7
1408	6
1408	7
1409	6
1409	7
1410	6
1410	7
1411	6
1411	7
1411	9
1411	25
859	25
1402	25
1403	25
1404	25
1405	25
1406	25
1412	6
1412	25
1412	7
1412	9
1413	6
1413	25
1413	7
1413	9
1414	6
1414	25
1414	7
1414	9
1415	6
1415	25
1415	7
1415	9
1416	6
1416	25
1416	7
1416	9
1417	6
1417	25
1417	7
1417	9
1418	6
1418	25
1418	7
1418	9
1419	6
1419	25
1419	7
1419	9
1420	6
1420	25
1420	7
1420	9
1421	6
1421	25
1421	7
1421	9
1422	6
1422	25
1422	7
1422	9
1423	6
1423	25
1423	7
1423	9
1424	6
1424	25
1424	7
1424	9
1425	6
1425	25
1425	7
1425	9
1426	6
1426	25
1426	7
1426	9
1427	6
1427	25
1427	7
1427	9
1428	6
1428	25
1428	7
1428	9
1429	6
1429	25
1429	7
1429	9
1430	6
1430	25
1430	7
1430	9
1431	6
1431	25
1431	7
1431	9
1432	6
1432	7
1432	9
1433	6
1433	25
1433	7
1433	9
1434	6
1434	25
1434	7
1434	9
1435	6
1435	25
1435	7
1435	9
1436	6
1436	25
1436	7
1436	9
1437	6
1437	25
1437	7
1437	9
1438	6
1438	25
1438	7
1438	9
1439	6
1439	25
1439	7
1439	9
1440	6
1440	25
1440	7
1440	9
1441	6
1441	25
1441	7
1441	9
1442	6
1442	25
1442	7
1442	9
1443	6
1443	25
1443	7
1443	9
1444	6
1444	25
1444	7
1444	9
1445	6
1445	25
1445	7
1445	9
1446	6
1446	25
1446	7
1446	9
1447	6
1447	25
1447	7
1447	9
1448	6
1448	25
1448	7
1448	9
1448	10
1449	6
1449	25
1449	7
1449	9
1450	6
1450	25
1450	7
1450	9
1451	6
1451	25
1451	7
1451	9
1452	6
1452	25
1452	7
1452	9
1453	6
1453	25
1453	7
1453	9
1454	6
1454	25
1454	7
1454	9
1455	6
1455	25
1455	7
1455	9
1456	6
1456	25
1456	7
1456	9
1457	6
1457	25
1457	7
1457	9
1458	6
1458	25
1458	7
1458	9
1459	6
1459	25
1459	7
1459	9
1460	6
1460	25
1460	7
1460	9
1461	6
1461	25
1461	7
1461	9
1462	6
1462	25
1462	7
1462	9
1463	6
1463	25
1463	7
1463	9
862	9
1464	6
1464	25
1464	7
1464	9
1465	6
1465	25
1465	7
1465	9
1466	6
1466	25
1466	7
1466	9
1467	6
1467	25
1467	7
1467	9
1468	6
1468	25
1468	7
1468	9
1469	6
1469	25
1469	7
1469	9
1470	6
1470	25
1470	7
1470	9
1471	6
1471	25
1471	7
1471	9
1472	6
1472	25
1472	7
1472	9
1473	6
1473	25
1473	7
1473	9
1474	6
1474	25
1474	7
1474	9
1475	6
1475	25
1475	7
1475	9
1476	6
1476	25
1476	7
1476	9
1477	6
1477	25
1477	7
1477	9
1478	6
1478	25
1478	7
1478	9
1479	6
1479	25
1479	7
1479	9
1480	6
1480	25
1480	7
1480	9
1481	6
1481	25
1481	7
1481	9
1482	6
1482	25
1482	7
1482	9
1483	6
1483	25
1483	7
1483	9
1484	6
1484	25
1484	7
1484	9
1485	6
1485	25
1485	7
1485	9
1486	6
1486	25
1486	7
1486	9
1487	6
1487	25
1487	7
1487	9
1488	6
1488	25
1488	7
1488	9
1489	6
1489	25
1489	7
1489	9
1490	6
1490	25
1490	7
1490	9
1491	6
1491	25
1491	7
1491	9
1492	6
1492	25
1492	7
1492	9
1493	6
1493	25
1493	7
1493	9
1494	6
1494	25
1494	7
1494	9
1495	6
1495	25
1495	7
1495	9
1496	6
1496	25
1496	7
1496	9
1497	6
1497	25
1497	7
1497	9
1498	6
1498	25
1498	7
1498	9
1499	6
1499	25
1499	7
1499	9
1500	6
1500	25
1500	7
1500	9
1501	6
1501	25
1501	7
1501	9
1502	6
1502	25
1502	7
1502	9
1503	6
1503	25
1503	7
1503	9
1504	6
1504	25
1504	7
1504	9
1505	6
1505	25
1505	7
1505	9
1505	10
1506	6
1506	25
1506	7
1506	9
1506	10
1507	6
1507	25
1507	7
1507	9
1507	10
1508	6
1508	25
1508	7
1508	9
1508	10
1509	6
1509	25
1509	7
1509	9
1509	10
1510	6
1510	25
1510	7
1510	9
1510	10
1511	6
1511	25
1511	7
1511	9
1511	10
1512	6
1512	25
1512	7
1512	10
1513	6
1513	25
1513	7
1513	9
1513	10
1514	6
1514	25
1514	7
1514	9
1514	10
1515	6
1515	25
1515	7
1515	9
1515	10
1516	6
1516	25
1516	7
1516	9
1516	10
1517	6
1517	25
1517	7
1517	9
1517	10
1518	6
1518	25
1518	7
1518	9
1518	10
1519	6
1519	25
1519	7
1519	9
1519	10
1520	6
1520	25
1520	7
1520	9
1520	10
1521	6
1521	25
1521	7
1521	9
1521	10
1522	6
1522	25
1522	7
1522	9
1522	10
1523	6
1523	25
1523	7
1523	9
1523	10
1524	6
1524	25
1524	7
1524	9
1524	10
1525	6
1525	25
1525	20
1525	9
1525	10
1526	6
1526	25
1526	7
1526	9
1526	10
1527	6
1527	25
1527	7
1527	9
1527	10
1528	6
1528	25
1528	7
1528	9
1528	10
1529	6
1529	25
1529	7
1529	9
1529	10
1530	6
1530	25
1530	7
1530	9
1530	10
1531	6
1531	25
1531	7
1531	9
1531	10
1532	6
1532	25
1532	7
1532	9
1532	10
1533	29
1533	25
1533	7
1533	9
1533	10
1534	6
1534	25
1534	7
1534	9
1534	10
1535	6
1535	25
1535	7
1535	9
1535	10
1536	6
1536	25
1536	7
1536	9
1536	10
1537	6
1537	25
1537	7
1537	9
1537	10
1538	6
1538	25
1538	7
1538	9
1538	10
1539	6
1539	25
1539	7
1539	9
1539	10
1540	6
1540	25
1540	7
1540	9
1540	10
1541	6
1541	25
1541	7
1541	9
1541	10
1542	6
1542	25
1542	7
1542	9
1542	10
1543	6
1543	25
1543	7
1543	9
1543	10
1544	6
1544	25
1544	7
1544	9
1544	10
1545	6
1545	25
1545	7
1545	9
1545	10
755	4
755	16
757	4
757	16
761	4
761	16
760	4
760	16
759	4
759	16
739	4
739	16
740	4
740	16
747	4
747	16
735	4
735	16
743	4
743	16
756	4
756	16
754	4
754	16
737	4
737	16
778	4
786	4
786	16
775	4
775	16
773	4
773	16
788	4
788	16
787	4
787	16
777	4
777	16
962	4
962	16
836	28
1547	6
1547	25
1547	7
1547	9
1547	10
1548	6
1548	25
1548	7
1548	9
1548	10
1549	6
1549	25
1549	7
1549	9
1549	10
1550	6
1550	25
1550	7
1550	9
1550	10
1551	6
1551	25
1551	7
1551	9
1551	10
1552	6
1552	25
1552	7
1552	9
1552	10
1553	6
1553	25
1553	7
1553	9
1553	10
1554	6
1554	25
1554	7
1554	9
1554	10
1555	6
1555	25
1555	7
1555	9
1555	10
1556	6
1556	25
1556	7
1556	10
1556	17
1557	6
1557	25
1557	7
1557	9
1557	10
1557	17
1558	6
1558	25
1558	7
1558	9
1558	10
1558	17
1559	6
1559	25
1559	7
1559	9
1559	10
1559	17
1560	6
1560	25
1560	7
1560	9
1560	10
1560	17
1561	11
1561	6
1561	25
1561	7
1561	9
1561	10
1561	17
1562	6
1562	25
1562	7
1562	9
1562	10
1562	17
1563	11
1563	6
1563	25
1563	7
1563	9
1563	10
1563	17
1564	6
1564	25
1564	7
1564	9
1564	10
1564	17
1565	6
1565	25
1565	7
1565	20
1565	9
1565	10
1565	17
1566	11
1566	6
1566	25
1566	7
1566	20
1566	9
1566	10
1566	17
1567	12
782	4
783	4
823	4
826	4
825	4
1569	4
1570	4
824	4
1571	4
1573	4
1574	6
1574	25
1574	7
1574	9
1574	10
1574	17
1575	6
1575	25
1575	7
1575	20
1575	9
1575	10
1575	17
1576	11
1576	6
1576	25
1576	7
1576	20
1576	9
1576	10
1576	17
1577	6
1577	25
1577	7
1577	9
1577	10
1577	17
1578	6
1578	25
1578	7
1578	20
1578	9
1578	10
1578	17
1579	11
1579	6
1579	25
1579	7
1579	20
1579	9
1579	10
1579	17
1580	11
1580	6
1580	25
1580	7
1580	20
1580	9
1580	10
1580	17
1581	6
1581	25
1581	7
1581	9
1581	10
1581	17
1582	6
1582	25
1582	7
1582	20
1582	9
1582	10
1582	17
1583	11
1583	6
1583	25
1583	7
1583	20
1583	9
1583	10
1583	17
1584	11
1584	6
1584	25
1584	7
1584	20
1584	9
1584	10
1584	17
1585	6
1585	25
1585	7
1585	20
1585	9
1585	10
1585	17
1586	11
1586	6
1586	25
1586	7
1586	20
1586	9
1586	10
1586	17
1587	6
1587	7
1587	9
1587	10
1587	17
1588	6
1588	25
1588	7
1588	20
1588	9
1588	10
1588	17
1589	11
1589	6
1589	25
1589	7
1589	20
1589	9
1589	10
1589	17
1590	6
1590	25
1590	7
1590	9
1590	10
1590	17
1591	6
1591	25
1591	7
1591	20
1591	9
1591	10
1591	17
1592	11
1592	6
1592	25
1592	7
1592	20
1592	9
1592	10
1592	17
1593	6
1593	25
1593	7
1593	9
1593	10
1593	17
1594	6
1594	25
1594	7
1594	9
1594	10
1594	17
1595	6
1595	25
1595	7
1595	20
1595	9
1595	10
1595	17
1596	6
1596	25
1596	7
1596	20
1596	9
1596	10
1596	17
1597	11
1597	6
1597	25
1597	7
1597	20
1597	9
1597	10
1597	17
1598	11
1598	6
1598	25
1598	7
1598	20
1598	9
1598	10
1598	17
1599	6
1599	25
1599	7
1599	9
1599	10
1599	17
1600	6
1600	25
1600	7
1600	20
1600	9
1600	10
1600	17
1601	11
1601	6
1601	25
1601	7
1601	20
1601	9
1601	10
1601	17
1602	6
1602	25
1602	7
1602	9
1602	10
1602	17
1603	6
1603	25
1603	7
1603	20
1603	9
1603	10
1603	17
1604	11
1604	6
1604	7
1604	20
1604	9
1604	10
1604	17
1605	11
1605	6
1605	25
1605	7
1605	20
1605	9
1605	10
1605	17
1606	11
1606	6
1606	25
1606	7
1606	20
1606	9
1606	10
1606	17
1607	11
1607	6
1607	25
1607	7
1607	20
1607	9
1607	10
1607	17
1608	11
1608	6
1608	25
1608	7
1608	20
1608	9
1608	10
1608	17
1609	11
1609	6
1609	25
1609	7
1609	20
1609	9
1609	10
1609	17
1610	11
1610	6
1610	25
1610	7
1610	20
1610	9
1610	10
1610	17
1610	24
1611	11
1611	6
1611	25
1611	7
1611	20
1611	9
1611	10
1611	17
1611	24
1612	11
1612	6
1612	25
1612	7
1612	20
1612	9
1612	10
1612	17
1613	11
1613	29
1613	25
1613	7
1613	20
1613	9
1613	10
1613	17
1613	24
968	15
965	15
967	15
964	14
980	15
1614	12
1615	12
1616	14
1617	14
1618	14
1619	15
1620	15
1621	15
1622	15
1623	15
1624	15
1625	15
1626	14
1627	15
1628	15
1630	15
1631	15
1632	15
1633	15
1634	15
976	15
1635	15
1636	15
1637	15
1638	15
977	15
1639	15
1640	15
1641	15
1642	15
1643	15
1645	15
1646	15
1647	15
1648	6
1648	25
1648	7
1648	9
1648	10
1648	17
1649	6
1649	25
1649	7
1649	9
1649	10
1649	17
1650	6
1650	25
1650	7
1650	9
1650	10
1650	17
1651	6
1651	25
1651	7
1651	9
1651	10
1651	17
1652	6
1652	25
1652	7
1652	9
1652	10
1652	17
1653	6
1653	25
1653	7
1653	9
1653	10
1653	17
1654	6
1654	25
1654	7
1654	9
1654	10
1654	17
1655	6
1655	25
1655	7
1655	9
1655	10
1655	17
1656	11
1656	6
1656	25
1656	7
1656	20
1656	9
1656	10
1656	17
1657	11
1657	6
1657	25
1657	7
1657	20
1657	9
1657	10
1657	17
1658	11
1658	6
1658	25
1658	7
1658	20
1658	9
1658	10
1658	17
1659	11
1659	6
1659	25
1659	7
1659	20
1659	9
1659	10
1659	17
1660	11
1660	6
1660	25
1660	7
1660	20
1660	9
1660	10
1660	17
1661	11
1661	6
1661	25
1661	7
1661	20
1661	9
1661	10
1661	17
1662	6
1662	25
1662	7
1662	20
1662	9
1662	10
1662	17
1663	11
1663	6
1663	25
1663	20
1663	9
1663	10
1663	17
1664	6
1664	25
1664	7
1664	20
1664	9
1664	10
1664	17
1665	11
1665	6
1665	25
1665	20
1665	9
1665	10
1665	17
1666	6
1666	25
1666	7
1666	20
1666	9
1666	10
1666	17
1667	11
1667	6
1667	25
1667	7
1667	20
1667	9
1667	10
1667	17
1668	6
1668	25
1668	7
1668	20
1668	9
1668	10
1668	17
1669	11
1669	6
1669	25
1669	7
1669	20
1669	9
1669	10
1669	17
1670	6
1670	25
1670	7
1670	20
1670	9
1670	10
1670	17
1671	11
1671	6
1671	25
1671	7
1671	20
1671	9
1671	10
1671	17
1672	6
1672	25
1672	7
1672	20
1672	9
1672	10
1672	17
1673	6
1673	25
1673	7
1673	20
1673	9
1673	10
1673	17
1674	11
1674	6
1674	25
1674	7
1674	20
1674	9
1674	10
1674	17
1673	11
1675	11
1675	6
1675	25
1675	7
1675	20
1675	9
1675	10
1675	17
1676	11
1676	6
1676	25
1676	7
1676	20
1676	9
1676	10
1676	17
1677	11
1677	6
1677	25
1677	7
1677	20
1677	9
1677	10
1677	17
1678	11
1678	6
1678	25
1678	7
1678	20
1678	9
1678	17
1679	11
1679	6
1679	25
1679	7
1679	20
1679	9
1679	10
1679	17
1680	11
1680	6
1680	25
1680	7
1680	20
1680	9
1680	10
1680	17
1681	11
1681	6
1681	25
1681	7
1681	20
1681	9
1681	10
1681	17
1682	11
1682	6
1682	25
1682	7
1682	20
1682	10
1682	17
1683	11
1683	6
1683	25
1683	7
1683	20
1683	9
1683	10
1683	17
1684	11
1684	6
1684	25
1684	7
1684	20
1684	9
1684	10
1684	17
1685	11
1685	6
1685	25
1685	7
1685	20
1685	9
1685	10
1685	17
1685	24
1686	11
1686	6
1686	25
1686	7
1686	20
1686	9
1686	10
1686	17
1686	24
1687	11
1687	6
1687	25
1687	7
1687	20
1687	9
1687	10
1687	17
1688	11
1688	6
1688	25
1688	7
1688	20
1688	9
1688	10
1688	17
1688	24
1689	11
1689	6
1689	25
1689	7
1689	20
1689	9
1689	10
1689	17
1690	11
1690	6
1690	25
1690	7
1690	20
1690	9
1690	10
1690	17
1690	24
1691	11
1691	6
1691	25
1691	7
1691	20
1691	9
1691	10
1691	17
1691	24
1692	11
1692	6
1692	25
1692	7
1692	20
1692	9
1692	10
1692	17
1693	11
1693	6
1693	25
1693	7
1693	20
1693	10
1693	17
1693	24
1694	11
1694	6
1694	25
1694	7
1694	20
1694	9
1694	10
1694	17
1694	24
1695	11
1695	29
1695	25
1695	7
1695	20
1695	9
1695	10
1695	17
1695	24
1696	11
1696	6
1696	25
1696	7
1696	20
1696	9
1696	10
1696	17
1696	24
1697	11
1697	6
1697	25
1697	7
1697	20
1697	9
1697	10
1697	17
1697	18
1697	24
1698	11
1698	6
1698	25
1698	7
1698	20
1698	9
1698	10
1698	17
1698	18
1698	24
1699	11
1699	6
1699	25
1699	7
1699	20
1699	9
1699	10
1699	17
1699	18
1699	24
1700	11
1700	6
1700	25
1700	7
1700	20
1700	9
1700	10
1700	17
1700	18
1700	24
1701	11
1701	6
1701	25
1701	7
1701	20
1701	9
1701	10
1701	17
1701	18
1701	24
1702	11
1702	6
1702	25
1702	7
1702	20
1702	9
1702	10
1702	17
1702	18
1702	24
1703	11
1703	6
1703	25
1703	7
1703	20
1703	9
1703	10
1703	17
1703	18
1703	24
1704	11
1704	6
1704	25
1704	7
1704	20
1704	9
1704	10
1704	17
1704	18
1704	24
1705	11
1705	6
1705	25
1705	7
1705	20
1705	9
1705	10
1705	17
1705	18
1705	24
1706	11
1706	6
1706	25
1706	7
1706	20
1706	9
1706	10
1706	17
1706	18
1707	11
1707	6
1707	25
1707	7
1707	20
1707	9
1707	10
1707	17
1707	18
1708	11
1708	6
1708	25
1708	7
1708	20
1708	9
1708	10
1708	17
1708	18
1709	11
1709	6
1709	25
1709	7
1709	20
1709	9
1709	10
1709	17
1709	18
1710	8
1710	11
1710	6
1710	25
1710	7
1710	9
1710	10
1710	17
1710	18
1711	11
1711	6
1711	25
1711	7
1711	20
1711	9
1711	10
1711	17
1711	18
1712	11
1712	6
1712	25
1712	7
1712	20
1712	9
1712	10
1712	17
1712	19
1712	18
1713	11
1713	6
1713	25
1713	7
1713	20
1713	9
1713	10
1713	17
1713	19
1713	18
1714	11
1714	6
1714	25
1714	7
1714	20
1714	9
1714	10
1714	17
1714	19
1714	18
1715	11
1715	6
1715	25
1715	7
1715	20
1715	9
1715	10
1715	17
1715	19
1715	18
1716	11
1716	6
1716	25
1716	7
1716	20
1716	9
1716	10
1716	17
1716	19
1716	18
1716	24
1717	11
1717	6
1717	25
1717	7
1717	20
1717	9
1717	10
1717	17
1717	19
1717	18
1718	11
1718	6
1718	25
1718	7
1718	20
1718	9
1718	10
1718	17
1718	19
1718	18
1719	11
1719	6
1719	25
1719	7
1719	20
1719	9
1719	10
1719	17
1719	19
1719	18
1719	24
1720	11
1720	6
1720	25
1720	7
1720	20
1720	9
1720	10
1720	17
1720	19
1720	18
1720	24
1721	11
1721	6
1721	25
1721	7
1721	20
1721	9
1721	10
1721	17
1721	19
1721	18
1722	11
1722	6
1722	25
1722	7
1722	20
1722	9
1722	10
1722	17
1722	19
1722	18
1723	11
1723	6
1723	25
1723	7
1723	20
1723	9
1723	10
1723	17
1723	19
1723	18
1723	24
1724	11
1724	6
1724	25
1724	7
1724	20
1724	9
1724	10
1724	17
1724	19
1724	18
1724	24
1725	11
1725	6
1725	25
1725	7
1725	20
1725	9
1725	10
1725	17
1725	19
1725	18
1725	24
1726	11
1726	6
1726	25
1726	7
1726	20
1726	9
1726	10
1726	17
1726	19
1726	18
1726	24
1727	11
1727	6
1727	25
1727	7
1727	20
1727	9
1727	10
1727	17
1727	18
1727	24
1728	11
1728	6
1728	25
1728	7
1728	20
1728	9
1728	10
1728	17
1728	18
1728	24
1729	11
1729	6
1729	25
1729	7
1729	20
1729	9
1729	10
1729	17
1729	19
1729	18
1729	24
1730	11
1730	6
1730	25
1730	7
1730	20
1730	9
1730	10
1730	17
1730	18
1730	24
1731	11
1731	6
1731	25
1731	7
1731	20
1731	9
1731	10
1731	17
1731	18
1731	24
1732	11
1732	6
1732	25
1732	7
1732	20
1732	9
1732	10
1732	17
1732	18
1732	24
1733	11
1733	6
1733	25
1733	7
1733	20
1733	9
1733	10
1733	17
1733	19
1733	18
1733	24
1734	11
1734	6
1734	25
1734	7
1734	20
1734	9
1734	10
1734	17
1734	19
1734	18
1735	11
1735	6
1735	25
1735	7
1735	20
1735	10
1735	17
1735	19
1735	18
1736	11
1736	6
1736	25
1736	7
1736	20
1736	9
1736	10
1736	17
1736	19
1736	18
1737	11
1737	6
1737	25
1737	7
1737	20
1737	9
1737	10
1737	17
1737	19
1737	18
1737	24
1738	11
1738	6
1738	25
1738	7
1738	20
1738	10
1738	17
1738	19
1738	18
1738	24
1739	11
1739	6
1739	25
1739	7
1739	20
1739	9
1739	17
1739	19
1739	18
1739	24
1740	11
1740	6
1740	25
1740	7
1740	20
1740	9
1740	10
1740	17
1740	19
1740	18
1740	24
1741	11
1741	6
1741	25
1741	7
1741	20
1741	9
1741	10
1741	17
1741	19
1741	18
1741	24
1742	11
1742	6
1742	25
1742	7
1742	20
1742	10
1742	17
1742	19
1742	18
1742	24
1743	11
1743	6
1743	25
1743	7
1743	20
1743	9
1743	10
1743	17
1743	19
1743	18
1743	24
1744	11
1744	6
1744	25
1744	7
1744	20
1744	9
1744	10
1744	17
1744	19
1744	18
1744	24
1745	11
1745	6
1745	25
1745	7
1745	20
1745	9
1745	10
1745	17
1745	19
1745	18
1745	24
1746	11
1746	6
1746	25
1746	7
1746	20
1746	9
1746	10
1746	17
1746	19
1746	18
1746	24
1747	11
1747	6
1747	25
1747	7
1747	20
1747	9
1747	10
1747	17
1747	19
1747	18
1747	24
1748	11
1748	6
1748	25
1748	7
1748	20
1748	9
1748	10
1748	17
1748	19
1748	18
1748	24
1749	16
1750	16
1751	16
979	15
983	32
1752	32
982	32
1753	32
1754	32
1755	32
1756	15
1757	15
1758	15
1759	15
1760	15
1761	15
1762	15
1763	15
1764	15
1765	15
1766	15
1767	15
1768	15
1769	27
1770	27
1771	27
1772	27
1773	27
1774	27
1775	27
1776	27
1777	27
1778	27
1779	27
1780	27
1781	27
1782	27
1783	15
972	15
1784	15
1785	15
970	15
978	15
1786	15
1787	15
1788	15
1789	15
1790	15
1791	15
1792	15
1793	15
1794	15
1795	15
1796	14
1797	14
1798	14
1799	14
1800	14
1801	14
1802	14
1803	14
1804	14
1805	14
1806	14
1807	14
1808	14
1809	14
1810	14
1811	14
1811	15
1798	15
1799	15
1800	15
1801	15
1802	15
1803	15
1804	15
1805	15
1806	15
1807	15
1796	15
1797	15
1808	15
1809	15
1810	15
1812	15
1813	15
1814	15
1815	15
1816	15
1817	13
1818	13
1819	13
1820	13
1821	33
1822	33
808	3
1823	3
1824	3
1825	3
808	34
1823	34
1824	34
1825	34
1826	34
1827	34
1828	34
1829	34
963	4
1830	4
1831	4
834	5
1832	5
1832	7
834	7
1833	6
1833	7
1834	5
1834	7
835	8
835	5
835	7
1835	8
1835	5
1835	7
1836	8
1836	5
1836	7
1837	8
1837	5
1837	7
1838	8
1838	5
1838	7
1839	8
1839	5
1839	7
1840	8
1840	5
1840	7
1841	8
1841	5
1841	7
937	8
937	5
937	7
1842	8
1842	5
1842	7
1843	8
1843	5
1843	7
1844	8
1844	5
1844	7
1845	8
1845	5
1845	7
1846	8
1846	5
1846	7
1847	8
1847	5
1847	7
1848	8
1848	5
1848	7
1849	8
1849	5
1849	7
1850	8
1850	5
1850	7
1851	8
1851	5
1851	7
1852	8
1852	5
1852	7
1853	8
1853	5
1853	7
1854	8
1854	5
1854	7
1855	8
1855	5
1855	7
931	8
931	5
931	7
1856	8
1856	5
1856	7
1857	8
1857	5
1857	7
1858	8
1858	5
1858	7
1859	8
1859	5
1859	7
1860	8
1860	5
1860	7
1861	8
1861	5
1861	7
1862	8
1862	5
1862	7
1863	8
1863	5
1863	7
1864	8
1864	5
1864	7
1865	8
1865	5
1865	7
932	6
932	7
932	9
1866	8
1866	5
1866	7
1867	8
1867	5
1867	7
1868	8
1868	5
1868	7
1869	8
1869	5
1869	7
1870	6
1870	7
1870	9
1871	6
1871	7
1871	9
1870	35
1871	35
1872	6
1872	7
1872	9
1873	6
1873	7
1873	9
1873	35
1874	6
1874	7
1874	10
1874	35
769	28
769	36
1875	36
1876	36
1877	36
1878	36
1879	36
1880	36
1881	36
1882	36
1883	36
1884	36
1885	36
1886	36
1887	36
1888	36
1889	36
1890	36
1891	36
1892	36
1893	36
1894	36
1895	36
1896	36
1897	36
1898	36
1899	36
1900	36
710	27
1901	27
1902	27
1903	27
1904	27
1905	27
1906	27
1907	27
1908	27
1909	27
1910	27
1911	27
1912	27
1913	27
1914	27
1915	27
1916	27
1917	27
1918	27
1919	27
1920	27
1921	27
711	27
1922	27
1923	27
1924	27
1925	27
1926	27
1927	27
1928	27
1929	27
712	27
1930	27
1931	27
1932	27
1933	27
1934	27
1935	27
1936	27
1937	27
1938	27
798	4
794	4
1939	4
1940	4
1941	4
1942	4
789	37
1943	37
1944	37
1945	37
1946	37
1947	37
1948	11
1949	37
1950	37
1951	37
1952	37
1953	37
1954	37
1955	37
1956	37
1957	37
791	37
791	7
791	26
1958	37
1958	7
1958	26
1959	37
1959	7
1959	26
1960	37
1960	7
1960	26
1961	37
1961	7
1961	26
1961	21
1962	37
1962	7
1962	26
1962	21
1960	21
791	21
1959	21
1958	21
790	37
790	7
790	26
790	21
1963	37
1963	7
1963	26
1963	21
1964	37
1964	7
1964	26
1964	21
1965	37
1965	7
1965	26
1965	21
1966	37
1966	7
1966	26
1966	21
1967	37
1967	7
1967	26
1967	21
1968	37
1968	7
1968	26
1968	21
1969	37
1969	7
1969	26
1969	21
792	37
792	7
792	26
792	21
804	37
804	7
804	26
804	21
1970	37
1970	7
1970	26
1970	21
1971	37
1971	7
1971	26
1971	21
1972	37
1972	7
1972	26
1972	21
1973	37
1973	7
1973	26
1973	21
1974	37
1974	7
1974	26
1974	21
1975	37
1975	7
1975	26
1975	21
1976	37
1976	7
1976	26
1976	21
1977	37
1977	7
1977	26
1977	21
1978	37
1978	7
1978	26
1978	21
1979	37
1979	7
1979	26
1979	21
1980	37
1980	7
1980	26
1980	21
1981	37
1981	7
1981	26
1981	21
1982	37
1982	7
1982	26
1982	21
1983	37
1983	7
1983	26
1983	21
1984	37
1984	7
1984	26
1984	21
1985	37
1985	7
1985	26
1985	21
1986	37
1986	7
1986	26
1986	21
1987	37
1987	7
1987	26
1987	21
1988	37
1988	7
1988	26
1988	21
1989	37
1989	7
1989	26
1989	21
1990	37
1990	7
1990	26
1990	21
1991	4
1991	16
1992	4
1992	16
1993	4
1993	16
1994	4
1994	16
1995	4
1995	16
1996	4
1996	16
1997	4
1997	16
1998	2
1999	2
2000	2
772	4
2001	4
2002	4
2003	4
2004	4
2005	4
2006	4
2007	4
2008	4
819	4
717	3
2009	4
2010	4
2011	4
2015	5
2016	5
2017	5
2017	7
2018	5
2018	7
2019	5
2019	7
2020	5
2020	7
2021	5
2021	7
2022	5
2022	7
2023	5
2023	7
2024	4
2024	16
2025	4
2025	5
2026	4
2026	16
829	4
831	4
830	4
827	4
2027	4
2028	4
2029	4
2030	4
2030	16
2031	4
2031	16
2032	4
2033	4
2033	16
776	4
776	16
780	4
780	16
2034	4
2034	16
797	4
797	16
799	4
799	16
800	4
800	16
2035	4
2035	16
2036	4
2036	16
709	4
709	16
720	4
720	16
732	4
732	16
729	4
729	16
728	4
728	16
725	4
725	16
796	4
796	16
795	4
795	16
822	5
821	4
781	4
784	4
727	4
753	4
758	4
2037	1
2038	1
2039	1
2040	1
2041	1
2042	1
2043	1
2044	1
2045	1
2046	1
2047	1
2048	1
2049	1
2050	1
2051	1
2052	1
2053	1
2054	6
2054	7
2054	25
2054	9
2054	10
2054	17
2054	18
2054	20
2054	11
2055	6
2055	7
2055	25
2055	9
2055	10
2055	17
2055	18
2055	20
2055	11
2056	6
2056	7
2056	25
2056	9
2056	10
2056	17
2056	18
2056	20
2056	11
2057	6
2057	7
2057	25
2057	9
2057	10
2057	17
2057	18
2057	20
2057	11
2058	6
2058	7
2058	25
2058	9
2058	10
2058	17
2058	18
2058	20
2058	11
2059	6
2059	7
2059	25
2059	9
2059	10
2059	17
2059	18
2059	20
2059	11
2060	6
2060	7
2060	25
2060	9
2060	10
2060	17
2060	18
2060	20
2060	11
2061	6
2061	7
2061	25
2061	9
2061	10
2061	19
2061	18
2061	20
2061	11
2061	24
2062	6
2062	7
2062	25
2062	9
2062	10
2062	17
2062	18
2062	20
2062	11
2062	24
2063	6
2063	7
2063	25
2063	9
2063	10
2063	17
2063	18
2063	20
2063	11
2063	24
2064	6
2064	7
2064	25
2064	9
2064	10
2064	17
2064	18
2064	20
2064	11
2065	6
2065	7
2065	25
2065	9
2065	10
2065	17
2065	18
2065	20
2065	11
2066	6
2066	7
2066	25
2066	9
2066	10
2066	17
2066	18
2066	20
2066	11
2067	29
2067	7
2067	25
2067	9
2067	10
2067	17
2067	18
2067	20
2067	11
2068	6
2068	7
2068	25
2068	9
2068	10
2068	17
2068	18
2068	20
2068	11
2069	6
2069	7
2069	25
2069	9
2069	10
2069	17
2069	18
2069	20
2069	11
2070	6
2070	7
2070	25
2070	9
2070	10
2070	17
2070	18
2070	20
2070	11
2070	24
2072	6
2072	7
2072	25
2072	9
2072	10
2072	17
2072	18
2072	20
2072	11
2073	6
2073	7
2073	25
2073	9
2073	10
2073	17
2073	18
2073	20
2073	11
2073	24
2074	6
2074	7
2074	25
2074	9
2074	10
2074	17
2074	18
2074	20
2074	11
2074	24
2076	6
2076	7
2076	25
2076	9
2076	10
2076	17
2076	18
2076	20
2076	11
2076	24
2077	6
2077	7
2077	25
2077	9
2077	10
2077	17
2077	18
2077	20
2077	11
2077	24
2078	6
2078	7
2078	25
2078	9
2078	10
2078	17
2078	18
2078	20
2078	11
2078	24
2079	6
2079	7
2079	25
2079	9
2079	10
2079	17
2079	18
2079	20
2079	11
2079	24
2080	6
2080	7
2080	25
2080	9
2080	10
2080	17
2080	18
2080	20
2080	11
2080	24
2081	6
2081	7
2081	25
2081	9
2081	10
2081	17
2081	18
2081	20
2081	11
2081	24
2082	6
2082	7
2082	25
2082	9
2082	10
2082	17
2082	18
2082	20
2082	11
2082	24
2083	6
2083	7
2083	25
2083	9
2083	10
2083	17
2083	18
2083	20
2083	11
2083	24
2084	6
2084	7
2084	25
2084	9
2084	10
2084	8
2084	22
2084	20
2084	11
2085	6
2085	7
2085	25
2085	9
2085	10
2085	8
2085	22
2085	20
2085	11
2086	6
2086	7
2086	25
2086	9
2086	10
2086	8
2086	22
2086	20
2086	11
2087	6
2087	7
2087	25
2087	9
2087	10
2087	8
2087	22
2087	20
2087	11
2088	6
2088	7
2088	25
2088	9
2088	10
2088	8
2088	22
2088	20
2088	11
2089	6
2089	7
2089	25
2089	9
2089	10
2089	8
2089	22
2089	20
2089	11
2090	6
2090	7
2090	25
2090	9
2090	10
2090	8
2090	22
2090	20
2090	11
2091	6
2091	25
2091	7
2091	9
2091	10
2091	8
2091	22
2091	20
2091	11
2092	6
2092	7
2092	25
2092	9
2092	10
2092	8
2092	22
2092	20
2092	11
2093	6
2093	7
2093	25
2093	9
2093	10
2093	8
2093	22
2093	20
2093	11
2094	6
2094	7
2094	25
2094	9
2094	10
2094	8
2094	22
2094	20
2094	11
2095	6
2095	7
2095	25
2095	9
2095	10
2095	8
2095	22
2095	20
2095	11
2096	6
2096	7
2096	25
2096	9
2096	10
2096	8
2096	22
2096	20
2096	11
2097	6
2097	7
2097	25
2097	9
2097	10
2097	8
2097	22
2097	20
2097	11
2098	6
2098	7
2098	25
2098	9
2098	10
2098	8
2098	22
2098	20
2098	11
2099	6
2099	7
2099	25
2099	9
2099	10
2099	8
2099	22
2099	20
2099	11
2100	6
2100	7
2100	25
2100	9
2100	10
2100	8
2100	22
2100	20
2100	11
2101	6
2101	7
2101	25
2101	9
2101	10
2101	8
2101	22
2101	20
2101	11
2102	6
2102	7
2102	25
2102	9
2102	10
2102	8
2102	22
2102	20
2102	11
2103	6
2103	7
2103	25
2103	9
2103	10
2103	8
2103	22
2103	20
2103	11
2104	6
2104	7
2104	25
2104	9
2104	10
2104	8
2104	22
2104	20
2104	11
2105	6
2105	7
2105	25
2105	9
2105	10
2105	8
2105	22
2105	20
2105	11
2106	6
2106	7
2106	25
2106	9
2106	10
2106	8
2106	22
2106	20
2106	11
2107	6
2107	7
2107	25
2107	9
2107	10
2107	17
2107	8
2107	22
2107	20
2107	11
2108	6
2108	7
2108	25
2108	9
2108	10
2108	17
2108	8
2108	22
2108	20
2108	11
2109	6
2109	7
2109	25
2109	9
2109	10
2109	17
2109	8
2109	22
2109	20
2109	11
2110	6
2110	7
2110	25
2110	9
2110	10
2110	17
2110	8
2110	22
2110	20
2110	11
2111	6
2111	7
2111	25
2111	9
2111	10
2111	17
2111	8
2111	22
2111	20
2111	11
2112	6
2112	7
2112	25
2112	9
2112	10
2112	8
2112	22
2112	20
2113	6
2113	7
2113	25
2113	9
2113	10
2113	17
2113	8
2113	22
2113	20
2113	11
2114	6
2114	7
2114	25
2114	9
2114	10
2114	8
2114	22
2114	20
2115	6
2115	7
2115	25
2115	9
2115	10
2115	17
2115	8
2115	22
2115	20
2116	6
2116	7
2116	25
2116	9
2116	10
2116	17
2116	8
2116	22
2116	20
2116	11
2117	6
2117	7
2117	25
2117	9
2117	10
2117	8
2117	22
2117	20
2118	6
2118	7
2118	25
2118	9
2118	10
2118	17
2118	8
2118	22
2118	20
2119	6
2119	7
2119	25
2119	9
2119	10
2119	17
2119	8
2119	22
2119	20
2119	11
2120	6
2120	7
2120	25
2120	9
2120	10
2120	8
2120	22
2120	20
2121	6
2121	7
2121	25
2121	9
2121	10
2121	17
2121	8
2121	22
2121	20
2122	6
2122	7
2122	25
2122	9
2122	10
2122	17
2122	8
2122	22
2122	20
2122	11
2123	6
2123	7
2123	25
2123	9
2123	10
2123	8
2123	22
2123	20
2124	6
2124	7
2124	25
2124	9
2124	10
2124	17
2124	8
2124	22
2124	20
2125	6
2125	7
2125	25
2125	9
2125	10
2125	17
2125	8
2125	22
2125	20
2125	11
2126	6
2126	7
2126	25
2126	9
2126	10
2126	8
2126	22
2126	20
2127	6
2127	7
2127	25
2127	9
2127	10
2127	17
2127	8
2127	22
2127	20
2128	6
2128	7
2128	25
2128	9
2128	10
2128	17
2128	8
2128	22
2128	20
2128	11
2129	6
2129	7
2129	25
2129	9
2129	10
2129	17
2129	8
2129	22
2129	20
2129	11
2130	6
2130	7
2130	25
2130	9
2130	10
2130	17
2130	8
2130	22
2130	20
2131	6
2131	7
2131	25
2131	9
2131	10
2131	17
2131	8
2131	22
2131	20
2131	11
2132	6
2132	7
2132	25
2132	9
2132	10
2132	17
2132	8
2132	22
2132	20
2133	6
2133	7
2133	25
2133	9
2133	10
2133	17
2133	8
2133	22
2133	20
2133	11
2134	6
2134	7
2134	25
2134	9
2134	10
2134	17
2134	8
2134	22
2134	20
2134	11
2135	6
2135	7
2135	25
2135	9
2135	10
2135	17
2135	8
2135	22
2135	20
2135	11
2136	6
2136	7
2136	25
2136	9
2136	10
2136	17
2136	8
2136	22
2136	20
2136	11
2137	6
2137	7
2137	25
2137	9
2137	10
2137	17
2137	8
2137	22
2137	20
2137	11
2138	6
2138	7
2138	25
2138	9
2138	10
2138	17
2138	8
2138	22
2138	20
2138	11
2139	6
2139	7
2139	25
2139	9
2139	10
2139	17
2139	8
2139	22
2139	20
2139	11
2140	6
2140	7
2140	25
2140	9
2140	10
2140	17
2140	8
2140	22
2140	20
2140	11
2141	6
2141	7
2141	25
2141	9
2141	10
2141	17
2141	8
2141	22
2141	20
2141	11
2142	6
2142	7
2142	25
2142	9
2142	10
2142	17
2142	8
2142	22
2142	20
2142	11
2143	6
2143	7
2143	25
2143	9
2143	10
2143	17
2143	8
2143	22
2143	20
2143	11
2144	6
2144	7
2144	25
2144	9
2144	10
2144	17
2144	8
2144	22
2144	20
2144	11
2145	6
2145	7
2145	25
2145	9
2145	10
2145	17
2145	8
2145	22
2145	20
2145	11
2146	6
2146	7
2146	25
2146	9
2146	10
2146	17
2146	8
2146	22
2146	20
2146	11
2147	6
2147	7
2147	25
2147	9
2147	10
2147	17
2147	8
2147	22
2147	20
2147	11
2148	6
2148	7
2148	25
2148	9
2148	10
2148	8
2148	22
2148	20
2148	11
2149	6
2149	7
2149	25
2149	9
2149	10
2149	8
2149	22
2149	20
2149	11
2150	6
2150	7
2150	25
2150	9
2150	10
2150	17
2150	8
2150	22
2150	20
2150	11
2151	6
2151	7
2151	25
2151	9
2151	10
2151	17
2151	8
2151	22
2151	20
2151	11
2152	6
2152	7
2152	25
2152	9
2152	10
2152	17
2152	8
2152	22
2152	20
2152	11
2153	6
2153	7
2153	25
2153	9
2153	10
2153	17
2153	8
2153	22
2153	20
2153	11
2154	6
2154	7
2154	25
2154	9
2154	10
2154	17
2154	8
2154	22
2154	20
2154	11
2155	6
2155	7
2155	25
2155	9
2155	10
2155	17
2155	8
2155	22
2155	20
2155	11
2157	6
2157	7
2157	25
2157	9
2157	10
2157	17
2157	8
2157	22
2157	20
2157	11
2158	6
2158	7
2158	25
2158	9
2158	10
2158	17
2158	8
2158	22
2158	20
2158	11
2159	6
2159	7
2159	25
2159	9
2159	10
2159	17
2159	8
2159	22
2159	20
2159	11
2160	6
2160	7
2160	25
2160	9
2160	10
2160	17
2160	8
2160	22
2160	20
2160	11
2161	6
2161	7
2161	25
2161	9
2161	10
2161	17
2161	8
2161	22
2161	20
2161	11
2163	6
2163	7
2163	25
2163	9
2163	10
2163	17
2163	8
2163	22
2163	20
2163	11
2164	6
2164	7
2164	25
2164	9
2164	10
2164	17
2164	8
2164	22
2164	20
2164	11
2165	6
2165	7
2165	25
2165	9
2165	10
2165	17
2165	8
2165	22
2165	20
2165	11
2166	6
2166	7
2166	25
2166	9
2166	10
2166	17
2166	8
2166	22
2166	20
2166	11
2167	6
2167	7
2167	25
2167	9
2167	10
2167	17
2167	8
2167	22
2167	20
2167	11
2168	6
2168	7
2168	25
2168	9
2168	10
2168	17
2168	8
2168	22
2168	20
2168	11
2169	6
2169	7
2169	25
2169	9
2169	10
2169	17
2169	8
2169	22
2169	20
2169	11
2170	6
2170	7
2170	25
2170	9
2170	10
2170	17
2170	8
2170	22
2170	20
2170	11
2171	6
2171	7
2171	25
2171	9
2171	10
2171	17
2171	8
2171	22
2171	20
2171	11
2172	29
2172	7
2172	25
2172	9
2172	10
2172	17
2172	8
2172	22
2172	20
2172	11
2174	6
2174	7
2174	25
2174	9
2174	10
2174	17
2174	8
2174	22
2174	20
2174	11
2175	6
2175	7
2175	25
2175	9
2175	10
2175	17
2175	8
2175	22
2175	20
2175	11
2175	24
2176	6
2176	7
2176	25
2176	9
2176	10
2176	17
2176	8
2176	22
2176	20
2176	11
2176	24
2177	6
2177	7
2177	25
2177	9
2177	10
2177	17
2177	8
2177	22
2177	20
2177	11
2177	24
2178	6
2178	7
2178	25
2178	9
2178	10
2178	17
2178	8
2178	22
2178	20
2178	11
2178	24
2179	6
2179	7
2179	25
2179	9
2179	10
2179	17
2179	8
2179	22
2179	20
2179	11
2179	24
2180	6
2180	7
2180	25
2180	9
2180	10
2180	17
2180	8
2180	22
2180	20
2180	11
2180	24
2181	6
2181	7
2181	25
2181	9
2181	10
2181	17
2181	8
2181	22
2181	20
2181	11
2181	24
2182	6
2182	7
2182	25
2182	9
2182	10
2182	17
2182	8
2182	22
2182	20
2182	11
2182	24
2183	6
2183	7
2183	25
2183	9
2183	10
2183	17
2183	8
2183	22
2183	20
2183	11
2183	24
2184	6
2184	7
2184	25
2184	9
2184	10
2184	17
2184	8
2184	22
2184	20
2184	11
2184	24
2185	6
2185	7
2185	25
2185	9
2185	10
2185	17
2185	8
2185	22
2185	20
2185	11
2185	24
2186	6
2186	7
2186	25
2186	9
2186	10
2186	17
2186	8
2186	22
2186	20
2186	11
2186	24
2187	6
2187	7
2187	25
2187	9
2187	10
2187	17
2187	8
2187	22
2187	20
2187	11
2187	24
2188	6
2188	7
2188	25
2188	9
2188	10
2188	17
2188	8
2188	22
2188	20
2188	11
2188	24
2189	6
2189	7
2189	25
2189	9
2189	10
2189	17
2189	8
2189	22
2189	20
2189	11
2189	24
2191	6
2191	7
2191	25
2191	9
2191	10
2191	17
2191	8
2191	22
2191	20
2191	11
2191	24
2192	6
2192	7
2192	25
2192	9
2192	10
2192	17
2192	8
2192	22
2192	20
2192	11
2192	24
2193	6
2193	7
2193	25
2193	9
2193	10
2193	17
2193	8
2193	22
2193	20
2193	11
2193	24
2194	6
2194	7
2194	25
2194	9
2194	10
2194	17
2194	8
2194	22
2194	20
2194	11
2195	6
2195	7
2195	25
2195	9
2195	10
2195	17
2195	8
2195	22
2195	20
2195	11
2196	6
2196	7
2196	25
2196	9
2196	10
2196	17
2196	8
2196	22
2196	20
2196	11
2197	6
2197	7
2197	25
2197	9
2197	10
2197	17
2197	8
2197	22
2197	20
2197	11
2198	6
2198	7
2198	25
2198	9
2198	10
2198	17
2198	8
2198	22
2198	20
2198	11
2199	6
2199	7
2199	25
2199	9
2199	10
2199	17
2199	8
2199	22
2199	20
2199	11
2200	6
2200	7
2200	25
2200	9
2200	10
2200	17
2200	8
2200	22
2200	20
2200	11
2201	6
2201	7
2201	25
2201	9
2201	10
2201	17
2201	8
2201	22
2201	20
2201	11
2202	6
2202	7
2202	25
2202	9
2202	10
2202	17
2202	8
2202	22
2202	20
2202	11
2203	6
2203	7
2203	25
2203	9
2203	10
2203	17
2203	8
2203	22
2203	20
2203	11
2204	6
2204	7
2204	25
2204	9
2204	10
2204	17
2204	8
2204	22
2204	20
2204	11
2205	6
2205	7
2205	25
2205	9
2205	10
2205	17
2205	8
2205	22
2205	20
2205	11
2206	6
2206	7
2206	25
2206	9
2206	10
2206	17
2206	8
2206	22
2206	20
2206	11
2207	6
2207	7
2207	25
2207	9
2207	10
2207	17
2207	8
2207	22
2207	20
2207	11
2208	6
2208	7
2208	25
2208	9
2208	10
2208	17
2208	8
2208	22
2208	20
2208	11
2209	6
2209	7
2209	25
2209	9
2209	10
2209	17
2209	8
2209	22
2209	20
2209	11
2210	6
2210	7
2210	25
2210	9
2210	10
2210	17
2210	8
2210	22
2210	20
2210	11
2211	6
2211	7
2211	25
2211	9
2211	10
2211	17
2211	8
2211	22
2211	20
2211	11
2212	6
2212	7
2212	25
2212	9
2212	10
2212	17
2212	23
2212	8
2212	22
2212	20
2212	11
2212	24
2213	6
2213	7
2213	25
2213	9
2213	10
2213	17
2213	23
2213	8
2213	22
2213	20
2213	11
2213	24
2215	6
2215	7
2215	25
2215	9
2215	10
2215	17
2215	23
2215	8
2215	22
2215	20
2215	11
2215	24
2216	6
2216	7
2216	25
2216	9
2216	10
2216	17
2216	23
2216	8
2216	22
2216	20
2216	11
2216	24
2217	6
2217	7
2217	25
2217	9
2217	10
2217	17
2217	23
2217	8
2217	22
2217	20
2217	11
2217	24
2218	6
2218	7
2218	25
2218	9
2218	10
2218	17
2218	23
2218	8
2218	22
2218	20
2218	11
2218	24
2219	6
2219	7
2219	25
2219	9
2219	10
2219	8
2219	22
2219	20
2220	6
2220	7
2220	25
2220	9
2220	10
2220	8
2220	22
2220	20
2221	6
2221	7
2221	25
2221	9
2221	10
2221	8
2221	22
2221	20
2222	6
2222	7
2222	25
2222	9
2222	10
2222	8
2222	22
2222	20
2223	6
2223	7
2223	25
2223	9
2223	10
2223	8
2223	22
2223	20
2224	6
2224	7
2224	25
2224	9
2224	10
2224	8
2224	22
2224	20
2225	6
2225	7
2225	25
2225	9
2225	10
2225	8
2225	22
2225	20
2226	6
2226	7
2226	25
2226	9
2226	10
2226	8
2226	22
2226	20
2227	6
2227	7
2227	25
2227	9
2227	10
2227	8
2227	22
2227	20
2228	6
2228	7
2228	25
2228	9
2228	10
2228	8
2228	22
2228	20
2229	6
2229	7
2229	25
2229	9
2229	10
2229	8
2229	22
2229	20
2230	6
2230	7
2230	25
2230	9
2230	10
2230	8
2230	22
2230	20
2231	6
2231	7
2231	25
2231	9
2231	10
2231	8
2231	22
2231	20
2232	6
2232	7
2232	25
2232	9
2232	10
2232	8
2232	22
2232	20
2233	6
2233	7
2233	25
2233	9
2233	10
2233	17
2233	8
2233	22
2233	20
2234	6
2234	7
2234	25
2234	9
2234	10
2234	17
2234	8
2234	22
2234	20
2235	6
2235	7
2235	25
2235	9
2235	10
2235	17
2235	8
2235	22
2235	20
2236	6
2236	7
2236	25
2236	9
2236	10
2236	17
2236	8
2236	22
2236	20
2237	6
2237	7
2237	25
2237	9
2237	10
2237	17
2237	8
2237	22
2237	20
2238	6
2238	7
2238	25
2238	9
2238	10
2238	17
2238	8
2238	22
2238	20
2239	6
2239	7
2239	25
2239	9
2239	10
2239	17
2239	8
2239	22
2239	20
2240	6
2240	7
2240	25
2240	9
2240	10
2240	17
2240	8
2240	22
2240	20
2241	6
2241	7
2241	25
2241	9
2241	10
2241	17
2241	8
2241	22
2241	20
2242	6
2242	7
2242	25
2242	9
2242	10
2242	17
2242	8
2242	22
2242	20
2243	6
2243	7
2243	25
2243	9
2243	10
2243	17
2243	8
2243	22
2243	20
2243	11
2244	6
2244	7
2244	25
2244	9
2244	10
2244	17
2244	8
2244	22
2244	20
2244	11
2245	6
2245	7
2245	25
2245	9
2245	10
2245	17
2245	8
2245	22
2245	20
2245	11
2246	6
2246	7
2246	25
2246	9
2246	10
2246	17
2246	8
2246	22
2246	20
2246	11
2247	6
2247	7
2247	25
2247	9
2247	10
2247	17
2247	8
2247	22
2247	20
2247	11
2248	6
2248	7
2248	25
2248	9
2248	10
2248	17
2248	8
2248	22
2248	20
2248	11
2250	6
2250	7
2250	25
2250	9
2250	10
2250	17
2250	8
2250	22
2250	34
2250	11
2251	6
2251	7
2251	25
2251	9
2251	10
2251	17
2251	8
2251	22
2251	20
2251	11
2252	6
2252	7
2252	25
2252	9
2252	10
2252	17
2252	8
2252	22
2252	20
2252	11
2253	6
2253	7
2253	25
2253	9
2253	10
2253	17
2253	8
2253	22
2253	20
2253	11
2254	6
2254	7
2254	25
2254	9
2254	10
2254	17
2254	8
2254	22
2254	20
2254	11
2255	6
2255	7
2255	25
2255	9
2255	10
2255	17
2255	8
2255	22
2255	20
2255	11
2256	6
2256	7
2256	25
2256	9
2256	10
2256	17
2256	8
2256	22
2256	20
2256	11
2257	6
2257	7
2257	25
2257	9
2257	10
2257	8
2257	22
2257	20
2257	11
2258	6
2258	7
2258	25
2258	9
2258	10
2258	8
2258	22
2258	20
2258	11
2259	6
2259	7
2259	25
2259	9
2259	10
2259	8
2259	22
2259	20
2259	11
2260	6
2260	7
2260	25
2260	9
2260	10
2260	8
2260	22
2260	20
2260	11
2261	6
2261	7
2261	25
2261	9
2261	10
2261	8
2261	22
2261	20
2261	11
2262	6
2262	7
2262	25
2262	9
2262	10
2262	8
2262	22
2262	20
2262	11
2263	6
2263	7
2263	25
2263	9
2263	10
2263	8
2263	22
2263	20
2263	11
2264	6
2264	7
2264	25
2264	9
2264	10
2264	8
2264	22
2264	20
2264	11
2265	6
2265	7
2265	25
2265	9
2265	10
2265	8
2265	22
2265	20
2265	11
2266	6
2266	7
2266	25
2266	9
2266	10
2266	8
2266	22
2266	20
2266	11
2267	6
2267	7
2267	25
2267	9
2267	10
2267	8
2267	22
2267	20
2267	11
2268	6
2268	7
2268	25
2268	9
2268	10
2268	8
2268	22
2268	20
2268	11
2269	6
2269	7
2269	25
2269	9
2269	10
2269	8
2269	22
2269	20
2269	11
2270	6
2270	7
2270	25
2270	9
2270	10
2270	8
2270	22
2270	20
2270	11
2271	6
2271	7
2271	25
2271	9
2271	10
2271	8
2271	22
2271	20
2271	11
2272	6
2272	7
2272	25
2272	9
2272	10
2272	8
2272	22
2272	20
2272	11
2273	6
2273	7
2273	25
2273	9
2273	10
2273	8
2273	22
2273	20
2273	11
2274	6
2274	7
2274	25
2274	9
2274	10
2274	17
2274	8
2274	22
2274	20
2274	11
2275	6
2275	7
2275	25
2275	9
2275	10
2275	17
2275	8
2275	22
2275	20
2275	11
2276	6
2276	7
2276	25
2276	9
2276	10
2276	17
2276	8
2276	22
2276	20
2276	11
2277	6
2277	7
2277	25
2277	9
2277	10
2277	17
2277	8
2277	22
2277	20
2277	11
2278	6
2278	7
2278	25
2278	9
2278	10
2278	17
2278	8
2278	22
2278	20
2278	11
2279	6
2279	7
2279	25
2279	9
2279	10
2279	17
2279	8
2279	22
2279	20
2279	11
2279	24
2280	6
2280	7
2280	25
2280	9
2280	10
2280	17
2280	8
2280	22
2280	20
2280	11
2280	24
2281	6
2281	7
2281	25
2281	9
2281	10
2281	17
2281	8
2281	22
2281	20
2281	11
2281	24
2282	6
2282	7
2282	25
2282	9
2282	10
2282	17
2282	8
2282	22
2282	20
2282	11
2282	24
2283	6
2283	7
2283	25
2283	9
2283	10
2283	17
2283	8
2283	22
2283	20
2283	11
2283	24
2284	6
2284	7
2284	25
2284	9
2284	10
2284	17
2284	8
2284	22
2284	20
2284	11
2284	24
2285	6
2285	7
2285	25
2285	9
2285	10
2285	17
2285	8
2285	22
2285	20
2285	11
2285	24
2286	6
2286	7
2286	25
2286	9
2286	10
2286	17
2286	8
2286	22
2286	20
2286	11
2286	24
2287	6
2287	7
2287	25
2287	9
2287	10
2287	17
2287	8
2287	22
2287	20
2287	11
2287	24
2288	6
2288	7
2288	25
2288	9
2288	10
2288	17
2288	8
2288	22
2288	20
2288	11
2288	24
2289	6
2289	7
2289	25
2289	9
2289	10
2289	17
2289	8
2289	22
2289	20
2289	11
2289	24
2290	6
2290	7
2290	25
2290	9
2290	10
2290	17
2290	8
2290	22
2290	20
2290	11
2290	24
2291	6
2291	7
2291	25
2291	9
2291	10
2291	17
2291	8
2291	22
2291	20
2291	11
2291	24
2292	6
2292	7
2292	25
2292	9
2292	10
2292	17
2292	8
2292	22
2292	20
2292	11
2292	24
2293	6
2293	7
2293	25
2293	9
2293	10
2293	17
2293	8
2293	22
2293	20
2293	11
2293	24
2294	6
2294	7
2294	25
2294	9
2294	10
2294	17
2294	8
2294	22
2294	20
2294	11
2294	24
2295	6
2295	7
2295	25
2295	9
2295	10
2295	17
2295	8
2295	22
2295	20
2295	11
2295	24
2296	6
2296	7
2296	25
2296	9
2296	10
2296	17
2296	8
2296	22
2296	20
2296	11
2296	24
2297	6
2297	7
2297	25
2297	9
2297	10
2297	17
2297	8
2297	22
2297	20
2297	11
2297	24
2298	6
2298	7
2298	25
2298	9
2298	10
2298	17
2298	8
2298	22
2298	20
2298	11
2298	24
2299	6
2299	7
2299	25
2299	9
2299	10
2299	17
2299	8
2299	22
2299	20
2299	11
2299	24
2300	6
2300	7
2300	25
2300	9
2300	10
2300	17
2300	8
2300	22
2300	20
2300	11
2300	24
2301	6
2301	7
2301	25
2301	9
2301	10
2301	17
2301	8
2301	22
2301	20
2301	11
2301	24
2302	6
2302	7
2302	25
2302	9
2302	10
2302	17
2302	8
2302	22
2302	20
2302	11
2302	24
2303	6
2303	7
2303	25
2303	9
2303	10
2303	17
2303	8
2303	22
2303	20
2303	11
2303	24
2304	6
2304	7
2304	25
2304	9
2304	10
2304	17
2304	8
2304	22
2304	20
2304	11
2304	24
2305	6
2305	7
2305	25
2305	9
2305	10
2305	17
2305	8
2305	22
2305	20
2305	11
2305	24
2306	6
2306	7
2306	25
2306	9
2306	10
2306	17
2306	8
2306	22
2306	20
2306	11
2306	24
2307	6
2307	7
2307	25
2307	9
2307	10
2307	17
2307	8
2307	22
2307	20
2307	11
2307	24
2308	6
2308	7
2308	25
2308	9
2308	10
2308	17
2308	8
2308	22
2308	20
2308	11
2308	24
2309	6
2309	7
2309	25
2309	9
2309	10
2309	17
2309	8
2309	22
2309	20
2309	11
2309	24
2310	6
2310	7
2310	25
2310	9
2310	10
2310	17
2310	8
2310	22
2310	20
2310	11
2310	24
2311	6
2311	7
2311	25
2311	9
2311	10
2311	17
2311	8
2311	22
2311	20
2311	11
2311	24
2312	6
2312	7
2312	25
2312	9
2312	10
2312	17
2312	8
2312	22
2312	20
2312	11
2312	24
2313	6
2313	7
2313	25
2313	9
2313	10
2313	17
2313	8
2313	22
2313	20
2313	11
2313	24
2315	6
2315	7
2315	25
2315	9
2315	10
2315	17
2315	8
2315	22
2315	20
2315	11
2315	24
2317	6
2317	7
2317	25
2317	9
2317	10
2317	17
2317	8
2317	22
2317	20
2317	11
2317	24
2318	6
2318	7
2318	25
2318	9
2318	10
2318	17
2318	8
2318	22
2318	20
2318	11
2318	24
2319	6
2319	7
2319	25
2319	9
2319	10
2319	17
2319	8
2319	22
2319	20
2319	11
2319	24
2320	6
2320	7
2320	25
2320	9
2320	10
2320	17
2320	8
2320	22
2320	20
2320	11
2320	24
2321	6
2321	34
2321	25
2321	9
2321	10
2321	17
2321	8
2321	22
2321	20
2321	11
2321	24
2322	6
2322	7
2322	25
2322	9
2322	10
2322	17
2322	8
2322	22
2322	20
2322	11
2322	24
2323	6
2323	7
2323	25
2323	9
2323	10
2323	17
2323	8
2323	22
2323	34
2323	11
2323	24
2324	6
2324	7
2324	25
2324	9
2324	10
2324	17
2324	8
2324	22
2324	20
2324	11
2324	24
2325	6
2325	7
2325	25
2325	9
2325	10
2325	17
2325	8
2325	22
2325	20
2325	11
2325	24
2326	6
2326	7
2326	25
2326	9
2326	10
2326	17
2326	8
2326	22
2326	20
2326	11
2326	24
2327	6
2327	7
2327	25
2327	9
2327	10
2327	17
2327	8
2327	22
2327	20
2327	11
2327	24
2328	6
2328	7
2328	25
2328	9
2328	10
2328	17
2328	8
2328	22
2328	20
2328	11
2328	24
2329	6
2329	7
2329	25
2329	9
2329	10
2329	17
2329	8
2329	22
2329	20
2329	11
2329	24
2330	6
2330	7
2330	25
2330	9
2330	10
2330	17
2330	8
2330	22
2330	20
2330	11
2330	24
2331	6
2331	7
2331	25
2331	9
2331	10
2331	17
2331	8
2331	22
2331	20
2331	11
2331	24
2332	6
2332	7
2332	25
2332	9
2332	10
2333	6
2333	7
2333	25
2333	9
2333	10
2334	6
2334	7
2334	25
2334	9
2334	10
2335	6
2335	7
2335	25
2335	9
2335	10
2336	6
2336	7
2336	25
2336	9
2336	10
2337	6
2337	7
2337	25
2337	9
2337	10
2338	6
2338	7
2338	25
2338	9
2338	10
2339	6
2339	7
2339	25
2339	9
2339	10
2339	20
2340	6
2340	7
2340	25
2340	9
2340	10
2341	6
2341	7
2341	25
2341	9
2341	10
2341	20
2342	0
2343	0
2344	0
2344	29
2345	0
2345	29
2346	0
2347	0
2348	0
2348	29
2349	0
2349	29
59	6
59	7
59	25
59	9
59	10
60	6
60	7
60	25
60	9
60	10
60	20
61	6
61	7
61	25
61	9
61	10
62	4
62	16
64	4
64	16
63	4
63	16
65	4
65	16
66	4
66	16
67	4
67	16
68	4
68	16
69	4
69	16
71	37
71	7
72	37
72	7
72	26
73	37
73	7
73	26
74	37
74	7
74	26
71	26
75	37
75	7
75	26
76	37
76	7
76	26
77	37
77	7
77	26
78	37
78	7
78	26
79	37
79	7
79	26
80	37
80	7
80	26
81	37
81	7
82	37
82	7
83	37
83	7
84	37
84	7
85	37
85	7
86	37
86	7
87	37
87	7
88	37
88	7
89	37
89	7
90	37
90	7
91	37
91	7
92	37
92	7
95	37
95	7
96	37
96	7
97	37
97	7
98	37
98	7
99	37
99	7
100	37
100	7
101	37
101	7
102	37
102	7
103	37
103	7
104	37
104	7
105	37
105	7
106	37
106	7
107	37
107	7
108	37
108	7
109	37
109	7
110	37
110	7
111	37
111	7
112	37
112	7
113	37
113	7
114	37
114	7
115	37
115	7
116	37
116	7
793	37
1331	37
956	37
1330	37
955	37
119	3
120	6
120	7
120	25
120	9
120	10
121	6
121	7
121	25
121	9
121	10
122	6
122	7
122	25
122	9
122	10
123	6
123	7
123	25
123	9
123	10
124	6
124	7
124	25
124	9
124	10
125	6
125	7
125	25
125	9
125	10
126	6
126	7
126	25
126	9
126	10
127	6
127	7
127	25
127	9
127	10
128	6
128	7
128	25
128	9
128	10
129	6
129	7
129	25
129	9
129	10
130	6
130	7
130	25
130	9
130	10
131	6
131	7
131	25
131	9
131	10
132	6
132	7
132	25
132	9
132	10
133	6
133	7
133	25
133	9
133	10
134	6
134	7
134	25
134	9
134	10
135	6
135	7
135	25
135	9
135	10
136	6
136	7
136	25
136	9
136	10
137	6
137	7
137	25
137	9
137	10
138	6
138	7
138	25
138	9
138	10
139	6
139	7
139	25
139	9
139	10
140	6
140	7
140	25
140	9
140	10
141	6
141	7
141	25
141	9
141	10
142	6
142	7
142	25
142	9
142	10
143	6
143	7
143	25
143	9
143	10
144	6
144	7
144	25
144	9
144	10
145	6
145	7
145	25
145	9
145	10
146	6
146	7
146	25
146	9
146	10
147	6
147	7
147	25
147	9
147	10
148	6
148	7
148	25
148	9
148	10
149	6
149	7
149	25
149	9
149	10
150	6
150	7
150	25
150	9
150	10
151	6
151	7
151	25
151	9
151	10
152	6
152	7
152	25
152	9
152	10
153	6
153	7
153	25
153	9
153	10
154	6
154	7
154	25
154	9
154	10
155	6
155	7
155	25
155	9
155	10
156	6
156	7
156	25
156	9
156	10
156	17
156	11
156	20
157	6
157	7
157	25
157	9
157	10
157	17
157	11
157	20
158	6
158	7
158	25
158	9
158	10
158	17
158	11
158	20
159	6
159	7
159	25
159	9
159	10
159	17
159	11
159	20
160	6
160	7
160	25
160	9
160	10
160	17
160	11
160	20
161	6
161	7
161	25
161	9
161	10
161	17
161	11
162	6
162	7
162	25
162	9
162	10
162	17
162	11
163	6
163	7
163	25
163	9
163	10
163	17
163	11
164	6
164	7
164	25
164	9
164	10
164	17
164	11
165	6
165	7
165	25
165	9
165	10
165	17
165	11
166	6
166	7
166	25
166	9
166	10
166	17
166	11
167	6
167	7
167	25
167	9
167	10
167	17
167	11
168	6
168	7
168	25
168	9
168	10
168	17
168	11
168	20
169	6
169	7
169	25
169	9
169	10
169	17
169	11
169	20
170	6
170	7
170	25
170	9
170	10
170	17
170	11
170	20
171	6
171	7
171	25
171	9
171	10
171	17
171	11
171	20
172	6
172	7
172	25
172	9
172	10
172	17
172	11
172	20
173	6
173	7
173	25
173	9
173	10
173	17
173	11
173	20
174	6
174	7
174	25
174	9
174	10
174	17
174	11
174	20
175	6
175	7
175	25
175	9
175	10
175	17
175	11
175	20
176	6
176	7
176	25
176	9
176	10
176	17
176	11
176	20
177	6
177	7
177	25
177	9
177	10
177	17
177	11
177	20
178	6
178	7
178	25
178	9
178	10
178	17
178	11
178	20
179	6
179	7
179	25
179	9
179	10
179	17
179	11
179	20
180	6
180	7
180	25
180	9
180	10
180	17
180	11
180	20
181	6
181	7
181	25
181	9
181	10
181	17
181	11
181	20
182	6
182	7
182	25
182	9
182	10
182	17
182	11
182	20
183	7
184	7
183	5
184	5
185	5
185	7
186	5
186	7
187	5
187	7
188	5
188	7
189	5
189	7
190	5
190	7
191	5
191	7
192	5
192	7
194	5
194	7
197	5
197	7
200	5
200	7
201	5
201	7
202	5
202	7
203	5
203	7
204	5
204	7
205	5
205	7
206	5
206	7
207	5
207	7
208	5
208	7
209	5
209	7
210	5
210	7
211	5
211	7
212	5
212	7
213	5
213	7
214	5
214	7
215	5
215	7
216	5
216	7
429	6
429	7
429	25
429	9
429	10
430	6
430	7
430	25
430	9
430	10
430	20
431	6
431	7
431	25
431	9
431	10
431	20
432	6
432	7
432	25
432	9
432	10
433	6
433	7
433	25
433	9
433	10
434	6
434	7
434	25
434	9
434	10
434	20
435	6
435	7
435	25
435	9
435	10
435	20
436	6
436	7
436	25
436	9
436	10
436	20
437	6
437	7
437	25
437	9
437	10
437	20
438	6
438	7
438	25
438	9
438	10
438	20
439	6
439	7
439	25
439	9
439	10
439	20
440	6
440	7
440	25
440	9
440	10
441	6
441	7
441	25
441	9
441	10
442	6
442	7
442	25
442	9
442	10
446	6
446	7
446	25
446	9
446	10
446	20
447	6
447	7
447	25
447	9
447	10
448	6
448	7
448	25
448	9
448	10
448	20
449	6
449	7
449	25
449	9
449	10
449	20
450	6
450	7
450	25
450	9
450	10
450	20
451	6
451	7
451	25
451	9
451	10
451	20
453	3
454	3
455	3
457	3
456	3
458	3
459	3
460	3
461	3
\.


--
-- Data for Name: processor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processor (id, l1_id, l2_id, l3_id, l1_cache_method_id, l2_cache_ratio_id, l3_cache_ratio_id, core, tdp, process_node) FROM stdin;
990	\N	\N	\N	\N	\N	\N	\N	\N	\N
908	8	12	\N	2	1	\N	SledgeHammer	\N	\N
1062	8	9	\N	2	5	\N	Pluto	48	180
1060	8	10	\N	2	2	\N	Pluto	39	180
1061	8	10	\N	2	5	\N	Pluto	40	180
1078	8	9	\N	2	1	\N	Thunderbird	47	180
1081	8	9	\N	2	1	\N	Thunderbird	54	180
1082	8	9	\N	2	1	\N	Thunderbird	54	180
1083	8	9	\N	2	1	\N	Thunderbird	60	180
1084	8	9	\N	2	1	\N	Thunderbird	63	180
1085	8	9	\N	2	1	\N	Thunderbird	66	180
1086	8	9	\N	2	1	\N	Thunderbird	66	180
1087	8	9	\N	2	1	\N	Thunderbird	66	180
1088	8	9	\N	2	1	\N	Thunderbird	68	180
1089	8	9	\N	2	1	\N	Thunderbird	70	180
1091	8	9	\N	2	1	\N	Thunderbird	72	180
894	8	10	\N	2	2	\N	Argon	42	250
1053	8	10	\N	2	2	\N	Argon	46	250
1057	8	10	\N	2	2	\N	Pluto	31	180
1054	8	10	\N	2	2	\N	Argon	50	250
1058	8	10	\N	2	2	\N	Pluto	34	180
1074	8	9	\N	2	1	\N	Thunderbird	38	180
1059	8	10	\N	2	2	\N	Pluto	36	180
1055	8	10	\N	2	2	\N	Argon	54	250
1067	8	9	\N	2	1	\N	Thunderbird	38	180
1056	8	10	\N	2	2	\N	Argon	50	250
1076	8	9	\N	2	1	\N	Thunderbird	43	180
1068	8	9	\N	2	1	\N	Thunderbird	40	180
1069	8	9	\N	2	1	\N	Thunderbird	42	180
1077	8	9	\N	2	1	\N	Thunderbird	45	180
1063	8	10	\N	2	5	\N	Pluto	50	180
1071	8	9	\N	2	1	\N	Thunderbird	50	180
1079	8	9	\N	2	1	\N	Thunderbird	50	180
1064	8	10	\N	2	3	\N	Orion	60	180
1080	8	9	\N	2	1	\N	Thunderbird	52	180
1072	8	9	\N	2	1	\N	Thunderbird	52	180
1065	8	10	\N	2	3	\N	Orion	62	180
944	8	10	\N	2	1	\N	Barton	60	130
1092	8	9	\N	2	1	\N	Palomino	62	180
899	8	10	\N	2	1	\N	Barton	68	130
948	8	9	\N	2	1	\N	Thoroughbred	45	130
950	8	10	\N	2	1	\N	Barton	45	130
1039	8	7	\N	2	1	\N	Morgan	46	180
1040	8	7	\N	2	1	\N	Morgan	50	180
1041	8	7	\N	2	1	\N	Morgan	54	180
1042	8	7	\N	2	1	\N	Morgan	60	180
1044	8	7	\N	2	1	\N	Applebred	57	130
911	8	7	\N	2	1	\N	Spitfire	27	180
1031	8	7	\N	2	1	\N	Spitfire	29	180
1032	8	7	\N	2	1	\N	Spitfire	31	180
1033	8	7	\N	2	1	\N	Spitfire	33	180
1034	8	7	\N	2	1	\N	Spitfire	35	180
1035	8	7	\N	2	1	\N	Spitfire	37	180
1036	8	7	\N	2	1	\N	Spitfire	39	180
1037	8	7	\N	2	1	\N	Spitfire	41	180
1045	8	7	\N	2	1	\N	Spitfire	\N	180
1046	8	7	\N	2	1	\N	Camaro	25	180
1047	8	7	\N	2	1	\N	Camaro	25	180
1048	8	7	\N	2	1	\N	Camaro	25	180
1049	8	7	\N	2	1	\N	Camaro	25	180
1050	8	7	\N	2	1	\N	Camaro	25	180
1051	8	7	\N	2	1	\N	Camaro	25	180
1052	8	7	\N	2	1	\N	Camaro	25	180
806	7	\N	\N	2	\N	\N	Model 6	17	350
1030	7	9	\N	2	1	\N	Sharptooth	\N	250
1020	5	\N	\N	2	\N	\N	P5	14	800
771	18	\N	\N	1	\N	\N	\N	\N	\N
917	8	8	\N	2	1	\N	Manila	62	90
734	\N	\N	\N	\N	\N	\N	\N	\N	\N
719	\N	\N	\N	\N	\N	\N	\N	\N	\N
991	\N	\N	\N	\N	\N	\N	\N	\N	\N
832	\N	\N	\N	\N	\N	\N	\N	\N	\N
833	\N	\N	\N	\N	\N	\N	\N	\N	\N
818	\N	\N	\N	\N	\N	\N	\N	\N	\N
1008	\N	\N	\N	\N	\N	\N	\N	\N	\N
733	\N	\N	\N	\N	\N	\N	\N	\N	\N
804	7	\N	\N	2	\N	\N	M2	\N	350
930	8	7	\N	2	1	\N	Samuel 2 (C5B)	\N	150
714	\N	\N	\N	\N	\N	\N	\N	\N	1500
985	\N	\N	\N	\N	\N	\N	\N	\N	1500
987	\N	\N	\N	\N	\N	\N	\N	\N	1500
988	\N	\N	\N	\N	\N	\N	\N	\N	1500
1026	5	\N	\N	2	\N	\N	P54CS	\N	350
1024	5	\N	\N	2	\N	\N	P54CS	\N	350
1022	5	\N	\N	2	\N	\N	P54C	\N	600
1025	5	\N	\N	2	\N	\N	P54CS	\N	350
1023	5	\N	\N	2	\N	\N	P54C	\N	600
809	5	\N	\N	2	\N	\N	P54C	\N	600
1029	6	\N	\N	2	\N	\N	P55C	\N	350
1028	6	\N	\N	2	\N	\N	P55C	\N	350
811	6	\N	\N	2	\N	\N	P55C	\N	350
1000	5	10	\N	2	1	\N	P6	38	350
997	5	10	\N	2	1	\N	P6	35	350
814	5	9	\N	2	1	\N	P6	29	500
1004	6	10	\N	2	1	\N	Deschutes	\N	250
1005	6	10	\N	2	1	\N	Deschutes	\N	250
1007	5	\N	\N	2	\N	\N	P24C	\N	600
984	4	\N	\N	1	\N	\N	P24C	\N	600
1014	4	\N	\N	2	\N	\N	P24D	\N	800
1018	4	\N	\N	1	\N	\N	P23	\N	1000
1010	4	\N	\N	1	\N	\N	P4	\N	1000
1012	4	\N	\N	1	\N	\N	P24	\N	800
1013	4	\N	\N	2	\N	\N	P24D	\N	800
1016	4	\N	\N	1	\N	\N	P23	\N	1000
828	4	\N	\N	1	\N	\N	U5S	\N	600
1011	4	\N	\N	1	\N	\N	P4	\N	1000
709	4	\N	\N	1	\N	\N	P4T	\N	\N
910	8	12	\N	2	1	\N	SledgeHammer	89	130
904	9	13	\N	2	1	\N	Windsor	125	90
902	8	10	\N	2	1	\N	Orleans	62	90
906	9	12	\N	2	1	\N	Windsor	89	90
724	4	\N	\N	1	\N	\N	P24	5	800
805	23	\N	\N	2	\N	\N	SSA/5	\N	350
716	\N	\N	\N	\N	\N	\N	\N	\N	1500
993	\N	\N	\N	\N	\N	\N	\N	\N	1500
996	\N	\N	\N	\N	\N	\N	\N	\N	800
755	4	\N	\N	1	\N	\N	\N	2	500
757	4	\N	\N	2	\N	\N	\N	2	500
760	4	\N	\N	1	\N	\N	\N	3	500
774	\N	\N	\N	\N	\N	\N	\N	\N	\N
785	\N	\N	\N	\N	\N	\N	\N	\N	\N
759	4	\N	\N	2	\N	\N	\N	3	500
739	4	\N	\N	2	\N	\N	\N	2	500
740	4	\N	\N	1	\N	\N	\N	2	500
747	4	\N	\N	1	\N	\N	\N	\N	\N
735	4	\N	\N	1	\N	\N	\N	\N	\N
815	\N	\N	\N	\N	\N	\N	\N	\N	\N
816	\N	\N	\N	\N	\N	\N	\N	\N	\N
817	\N	\N	\N	\N	\N	\N	\N	\N	\N
743	4	\N	\N	2	\N	\N	\N	2	\N
836	\N	\N	\N	\N	\N	\N	\N	\N	\N
756	4	\N	\N	2	\N	\N	\N	2	500
801	\N	\N	\N	\N	\N	\N	\N	\N	\N
737	5	\N	\N	2	\N	\N	\N	2	350
754	4	\N	\N	1	\N	\N	\N	\N	\N
949	8	9	\N	2	1	\N	Thoroughbred	16	130
895	8	9	\N	2	1	\N	Thunderbird	36	180
919	7	9	\N	2	1	\N	Model 13	12	180
859	6	10	\N	2	2	\N	Katmai	25	250
864	6	8	\N	2	1	\N	Mendocino	19	250
810	6	9	\N	2	2	\N	Klamath	\N	350
896	8	9	\N	2	1	\N	Thunderbird	38	180
942	8	9	\N	2	1	\N	Palomino	46	180
943	8	9	\N	2	1	\N	Thoroughbred	60	130
951	8	10	\N	2	1	\N	Barton	35	130
952	8	8	\N	2	1	\N	Dublin	62	130
946	8	9	\N	2	1	\N	Corvette	22	180
913	8	7	\N	2	1	\N	Applebred	57	130
957	8	9	\N	2	1	\N	Thoroughbred	9	130
912	8	7	\N	2	1	\N	Morgan	42	180
945	8	7	\N	2	1	\N	Spitfire	\N	180
947	8	7	\N	2	2	\N	Camaro	25	180
915	8	8	\N	2	1	\N	Paris	62	130
918	7	8	\N	2	1	\N	Model 13	16	180
933	6	10	\N	2	1	\N	Drake	31	250
934	6	10	\N	2	1	\N	Tanner	36	250
936	6	9	\N	2	1	\N	Cascades	19	180
935	6	9	\N	2	1	\N	Cascades	19	180
866	6	9	\N	2	1	\N	Coppermine	13	180
867	6	9	\N	2	1	\N	Tualatin	30	130
776	4	\N	\N	2	\N	\N	M7	\N	\N
778	2	\N	\N	1	\N	\N	M5	\N	\N
773	4	\N	\N	1	\N	\N	M6	\N	\N
788	5	\N	\N	2	\N	\N	M1sc	3	650
787	5	\N	\N	2	\N	\N	M1sc	3	650
777	4	\N	\N	1	\N	\N	M9	\N	\N
808	6	\N	\N	\N	\N	\N	Nx586	\N	500
835	7	\N	\N	2	\N	\N	\N	12	250
769	5	\N	\N	1	\N	\N	EV4	\N	750
710	28	\N	\N	\N	\N	\N	68030	3	\N
711	4	\N	\N	\N	\N	\N	68040	8	650
712	5	\N	\N	\N	\N	\N	68060	4	600
798	5	\N	\N	1	\N	\N	\N	\N	\N
794	5	\N	\N	1	\N	\N	\N	\N	\N
789	5	\N	\N	2	\N	\N	M1	\N	650
791	7	\N	\N	2	\N	\N	M2	\N	350
790	7	\N	\N	2	\N	\N	M2	\N	350
792	7	\N	\N	2	\N	\N	M2	\N	350
793	5	\N	\N	2	\N	\N	GXm	\N	350
956	5	\N	\N	2	\N	\N	GXm	\N	350
772	18	\N	\N	1	\N	\N	\N	\N	\N
819	18	\N	\N	1	\N	\N	\N	\N	\N
717	\N	\N	\N	\N	\N	\N	\N	\N	800
783	18	\N	\N	1	\N	\N	\N	\N	\N
823	18	\N	\N	1	\N	\N	\N	\N	\N
782	18	\N	\N	1	\N	\N	\N	\N	\N
826	4	\N	\N	1	\N	\N	\N	\N	\N
824	4	\N	\N	1	\N	\N	\N	\N	\N
825	4	\N	\N	1	\N	\N	\N	\N	\N
1021	5	\N	\N	2	\N	\N	P54C	\N	600
1019	5	\N	\N	2	\N	\N	P24C	\N	600
731	4	\N	\N	1	\N	\N	\N	\N	800
1017	4	\N	\N	1	\N	\N	P23	\N	1000
730	4	\N	\N	1	\N	\N	P23	\N	1000
829	4	\N	\N	1	\N	\N	U5SD	\N	600
831	4	\N	\N	1	\N	\N	U5SX	\N	600
827	4	\N	\N	1	\N	\N	U5S	\N	600
830	4	\N	\N	1	\N	\N	U5S	\N	600
775	4	\N	\N	1	\N	\N	M7	\N	\N
786	4	\N	\N	1	\N	\N	M6	\N	\N
779	4	\N	\N	1	\N	\N	M5	\N	\N
780	4	\N	\N	1	\N	\N	M6	\N	\N
797	4	\N	\N	2	\N	\N	M7	\N	\N
799	4	\N	\N	1	\N	\N	M7	\N	\N
800	4	\N	\N	1	\N	\N	M9	\N	\N
720	4	\N	\N	1	\N	\N	P4T	\N	\N
732	4	\N	\N	1	\N	\N	P4T	\N	\N
729	4	\N	\N	1	\N	\N	P4T	\N	\N
728	4	\N	\N	1	\N	\N	\N	\N	\N
725	4	\N	\N	1	\N	\N	\N	\N	\N
796	4	\N	\N	1	\N	\N	\N	\N	\N
795	4	\N	\N	1	\N	\N	\N	\N	\N
821	4	\N	\N	1	\N	\N	P23T	\N	\N
781	4	\N	\N	1	\N	\N	P23T	\N	\N
727	4	\N	\N	1	\N	\N	\N	\N	800
753	4	\N	\N	1	\N	\N	\N	\N	800
758	4	\N	\N	1	\N	\N	\N	\N	800
916	8	9	\N	2	1	\N	Palermo	62	90
903	8	12	\N	2	1	\N	San Diego	104	90
909	9	13	\N	2	1	\N	Santa Ana	103	90
862	6	9	\N	2	1	\N	Coppermine	13	180
865	6	8	\N	2	1	\N	Coppermine-128	14	180
868	6	9	\N	2	1	\N	Tualatin-256	27	130
872	4	9	\N	2	1	\N	Willamette	58	180
860	5	\N	\N	2	\N	\N	P5	16	800
877	4	8	\N	2	1	\N	Willamette-128	\N	180
873	4	10	\N	2	1	\N	Northwood	\N	130
958	4	10	\N	2	1	\N	Northwood	69	130
878	4	8	\N	2	1	\N	Northwood-128	\N	130
766	5	\N	\N	2	\N	\N	\N	3	350
938	\N	\N	\N	\N	\N	\N	\N	\N	\N
939	\N	\N	\N	\N	\N	\N	\N	\N	\N
940	\N	\N	\N	\N	\N	\N	\N	\N	\N
941	\N	\N	\N	\N	\N	\N	\N	\N	\N
989	\N	\N	\N	\N	\N	\N	\N	\N	\N
992	\N	\N	\N	\N	\N	\N	\N	\N	\N
1009	\N	\N	\N	\N	\N	\N	\N	\N	\N
1107	8	9	\N	2	1	\N	Thoroughbred	52	130
1152	8	9	\N	2	1	\N	Palomino	54	180
1151	8	9	\N	2	1	\N	Palomino	\N	180
1153	8	9	\N	2	1	\N	Palomino	60	180
1155	8	9	\N	2	1	\N	Palomino	66	180
1156	8	9	\N	2	1	\N	Palomino	66	180
1157	8	9	\N	2	\N	\N	Palomino	66	180
1158	8	9	\N	2	1	\N	Palomino	66	180
1160	8	9	\N	2	1	\N	Thoroughbred	60	130
1161	8	9	\N	2	1	\N	Thoroughbred	60	130
1163	8	9	\N	2	1	\N	Thoroughbred	60	130
1164	8	10	\N	2	1	\N	Barton	60	130
1098	8	9	\N	2	1	\N	Palomino	35	180
1100	8	9	\N	2	1	\N	Palomino	35	180
1101	8	9	\N	2	1	\N	Palomino	35	180
1102	8	9	\N	2	1	\N	Palomino	35	180
1094	8	9	\N	2	1	\N	Palomino	66	180
1095	8	9	\N	2	1	\N	Palomino	68	180
1096	8	9	\N	2	1	\N	Palomino	70	180
1097	8	9	\N	2	1	\N	Palomino	72	180
1103	8	9	\N	2	1	\N	Thoroughbred	49	130
1106	8	9	\N	2	1	\N	Thoroughbred	51	130
1104	8	9	\N	2	1	\N	Thoroughbred	51	130
1109	8	9	\N	2	1	\N	Thoroughbred	60	130
1108	8	9	\N	2	1	\N	Thoroughbred	60	130
1110	8	9	\N	2	1	\N	Thoroughbred	60	130
1112	8	9	\N	2	1	\N	Thoroughbred	62	130
1114	8	9	\N	2	1	\N	Thoroughbred	68	130
1113	8	9	\N	2	1	\N	Thoroughbred	65	130
1116	8	9	\N	2	1	\N	Thoroughbred	68	130
1115	8	9	\N	2	1	\N	Thoroughbred	68	130
1117	8	9	\N	2	1	\N	Thoroughbred	68	130
1118	8	9	\N	2	1	\N	Thoroughbred	74	130
1119	8	9	\N	2	1	\N	Thoroughbred	\N	130
1121	8	9	\N	2	1	\N	Thoroughbred	35	130
1122	8	9	\N	2	1	\N	Thoroughbred	35	130
1123	8	9	\N	2	1	\N	Thoroughbred	35	130
1127	8	9	\N	2	1	\N	Thorton	60	130
1126	8	9	\N	2	1	\N	Thorton	60	130
1129	8	9	\N	2	1	\N	Thorton	62	130
1128	8	9	\N	2	1	\N	Thorton	62	130
1132	8	9	\N	2	1	\N	Thorton	68	130
1131	8	9	\N	2	1	\N	Thorton	68	130
1133	8	9	\N	2	1	\N	Thorton	68	130
1135	8	10	\N	2	1	\N	Barton	68	130
1134	8	10	\N	2	1	\N	Barton	68	130
1138	8	10	\N	2	1	\N	Barton	68	130
1137	8	10	\N	2	1	\N	Barton	68	130
1139	8	10	\N	2	1	\N	Barton	68	130
923	4	10	13	2	1	1	Gallatin	111	130
921	5	13	\N	2	1	\N	Prescott-2M	115	90
874	5	12	\N	2	1	\N	Prescott	89	90
959	5	12	\N	2	1	\N	Prescott	89	90
875	5	12	\N	2	1	\N	Prescott	84	90
879	5	9	\N	2	1	\N	Prescott-256	73	90
876	5	13	\N	2	1	\N	Cedar Mill	86	65
880	5	9	\N	2	1	\N	Prescott-256	84	90
881	5	10	\N	2	1	\N	Cedar Mill-512	65	65
886	6	13	\N	2	1	\N	Smithfield	95	90
925	6	14	\N	2	1	\N	Presler	130	65
887	6	14	\N	2	1	\N	Presler	95	65
888	8	13	\N	2	1	\N	Conroe	65	65
889	8	21	\N	2	1	\N	Wolfdale	65	45
926	8	14	\N	2	1	\N	Conroe	75	65
928	9	22	\N	2	1	\N	Yorkfield	130	45
892	9	15	\N	2	1	\N	Kentsfield	95	65
893	9	22	\N	2	1	\N	Yorkfield	95	45
963	4	\N	\N	2	\N	\N	ZFx86	1	\N
834	7	\N	\N	2	\N	\N	\N	11	350
932	8	7	\N	2	1	\N	Nehemiah (C5XL)	15	130
986	\N	\N	\N	\N	\N	\N	\N	\N	1500
813	5	\N	\N	2	\N	\N	P54C	\N	500
869	6	\N	\N	2	\N	\N	P55C	\N	280
861	5	\N	\N	2	\N	\N	P5	\N	350
1006	5	\N	\N	2	\N	\N	P5	\N	350
1003	5	12	\N	2	1	\N	P6	47	350
998	5	9	\N	2	1	\N	P6	32	350
726	5	\N	\N	1	\N	\N	P24C	\N	600
883	8	12	\N	2	1	\N	Wolfdale-3M	65	45
812	6	\N	\N	2	\N	\N	P24T	\N	350
891	8	12	\N	2	1	\N	Allendale	65	65
890	8	13	\N	2	1	\N	Wolfdale-3M	65	45
901	8	10	\N	2	1	\N	ClawHammer	89	130
905	9	12	\N	2	1	\N	Toledo	89	90
960	7	12	\N	2	1	\N	Banias	22	130
961	7	13	\N	2	1	\N	Dothan	21	90
1140	8	10	\N	2	1	\N	Barton	68	130
1141	8	10	\N	2	1	\N	Barton	68	130
1142	8	10	\N	2	1	\N	Barton	68	130
1143	8	10	\N	2	1	\N	Barton	74	130
1145	8	10	\N	2	1	\N	Barton	79	130
1167	8	9	\N	2	1	\N	Corvette	25	180
1169	8	9	\N	2	1	\N	Corvette	35	180
1168	8	9	\N	2	1	\N	Corvette	25	180
1170	8	9	\N	2	1	\N	Corvette	35	180
1171	8	9	\N	2	1	\N	Corvette	35	180
1173	8	9	\N	2	1	\N	Corvette	35	180
1165	8	9	\N	2	1	\N	Corvette	24	180
1166	8	9	\N	2	1	\N	Corvette	24	180
1175	8	9	\N	2	1	\N	Thoroughbred	35	130
1186	8	9	\N	2	1	\N	Thoroughbred	25	130
1174	8	9	\N	2	1	\N	Thoroughbred	35	130
885	7	12	\N	2	1	\N	Dothan-1024	21	90
995	\N	\N	\N	\N	\N	\N	\N	\N	1500
1187	8	9	\N	2	1	\N	Thoroughbred	25	130
1177	8	9	\N	2	1	\N	Thoroughbred	35	130
1179	8	9	\N	2	1	\N	Thoroughbred	35	130
1180	8	9	\N	2	1	\N	Thoroughbred	35	130
1189	8	9	\N	2	1	\N	Thoroughbred	25	130
1181	8	9	\N	2	1	\N	Thoroughbred	35	130
1182	8	9	\N	2	1	\N	Thoroughbred	35	130
1193	8	9	\N	2	1	\N	Thoroughbred	25	130
1183	8	9	\N	2	1	\N	Thoroughbred	35	130
1194	8	9	\N	2	1	\N	Thoroughbred	25	130
1184	8	9	\N	2	1	\N	Thoroughbred	35	130
1185	8	9	\N	2	1	\N	Thoroughbred	35	130
1146	8	10	\N	2	1	\N	Barton	\N	130
1147	8	10	\N	2	1	\N	Barton	\N	130
1149	8	10	\N	2	1	\N	Barton	\N	130
1148	8	10	\N	2	1	\N	Barton	\N	130
1150	8	10	\N	2	1	\N	Barton	\N	130
1178	8	9	\N	2	1	\N	Thoroughbred	35	130
1191	8	9	\N	2	1	\N	Thoroughbred	25	130
1200	8	9	\N	2	1	\N	Thoroughbred	45	130
1214	8	9	\N	2	1	\N	Thoroughbred	16	130
1215	9	9	\N	2	1	\N	Thoroughbred	16	130
1216	8	9	\N	2	\N	\N	Thoroughbred	25	130
1217	8	9	\N	2	1	\N	Thoroughbred	25	130
1218	8	9	\N	2	1	\N	Thoroughbred	35	130
1219	8	9	\N	2	1	\N	Thoroughbred	35	130
1222	8	9	\N	2	1	\N	Thoroughbred	35	130
1235	9	10	\N	2	1	\N	Barton	25	130
1237	8	10	\N	2	1	\N	Barton	25	130
1236	8	10	\N	2	1	\N	Barton	35	130
1206	8	9	\N	2	1	\N	Thoroughbred	35	130
1207	8	9	\N	2	1	\N	Thoroughbred	35	130
1208	8	9	\N	2	1	\N	Thoroughbred	35	130
1195	8	9	\N	2	1	\N	Thoroughbred	45	130
1209	8	9	\N	2	1	\N	Thoroughbred	35	130
1197	8	9	\N	2	1	\N	Thoroughbred	45	130
1196	8	9	\N	2	1	\N	Thoroughbred	45	130
1210	8	9	\N	2	1	\N	Thoroughbred	35	130
1198	8	9	\N	2	1	\N	Thoroughbred	45	130
1211	8	9	\N	2	1	\N	Thoroughbred	35	130
1202	8	9	\N	2	1	\N	Thoroughbred	72	130
1212	8	9	\N	2	1	\N	Thoroughbred	35	130
1199	8	9	\N	2	1	\N	Thoroughbred	45	130
1213	8	9	\N	2	1	\N	Thoroughbred	35	130
1201	8	9	\N	2	1	\N	Thoroughbred	45	130
1203	8	9	\N	2	1	\N	Thoroughbred	72	130
1204	8	9	\N	2	1	\N	Thoroughbred	72	130
1205	8	9	\N	2	1	\N	Thoroughbred	72	130
1232	8	10	\N	2	1	\N	Barton	35	130
1227	8	10	\N	2	1	\N	Barton	72	130
1223	8	10	\N	2	1	\N	Barton	45	130
1233	8	10	\N	2	1	\N	Barton	35	130
1228	8	10	\N	2	1	\N	Barton	72	130
1234	8	10	\N	2	1	\N	Barton	35	130
1224	8	10	\N	2	1	\N	Barton	45	130
1225	8	10	\N	2	1	\N	Barton	45	130
1229	8	10	\N	2	1	\N	Barton	72	130
1231	8	10	\N	2	1	\N	Barton	72	130
1221	8	9	\N	2	1	\N	Dublin	62	130
1220	8	8	\N	2	1	\N	Dublin	62	130
1239	8	10	\N	2	1	\N	Barton	35	130
1240	8	10	\N	2	1	\N	Barton	35	130
1243	8	10	\N	2	1	\N	Barton	35	130
1260	23	\N	\N	2	\N	\N	5k86	12	350
1238	8	10	\N	2	\N	\N	Barton	25	130
1242	8	10	\N	2	1	\N	Barton	27	130
1247	8	9	\N	2	1	\N	Thoroughbred	67	130
1246	8	9	\N	2	1	\N	Thoroughbred	\N	130
1253	8	9	\N	2	1	\N	Thorton	62	130
1248	8	9	\N	2	1	\N	Thoroughbred	62	130
1254	8	9	\N	2	1	\N	Thorton	62	130
1249	8	9	\N	2	1	\N	Thoroughbred	62	130
1251	8	9	\N	2	1	\N	Thoroughbred	62	130
1252	8	9	\N	2	1	\N	Thoroughbred	62	130
1255	8	9	\N	2	1	\N	Thorton	62	130
1256	8	10	\N	2	1	\N	Barton	62	130
1257	8	10	\N	2	1	\N	Barton	64	130
1258	23	\N	\N	2	\N	\N	SSA/5	15	350
1259	23	\N	\N	2	\N	\N	SSA/5	14	350
1262	23	\N	\N	2	\N	\N	5k86	\N	350
1263	23	\N	\N	2	\N	\N	5k86	16	350
1264	23	\N	\N	2	\N	\N	5k86	\N	350
1331	5	\N	\N	2	\N	\N	GXm	\N	350
955	5	\N	\N	2	\N	\N	GXm	\N	350
1265	7	\N	\N	2	\N	\N	Model 6	20	350
1266	7	\N	\N	2	\N	\N	Model 6	28	350
1267	7	\N	\N	2	\N	\N	Model 6	30	350
1269	7	\N	\N	2	\N	\N	Little Foot	15	250
1270	7	\N	\N	2	\N	\N	Little Foot	9	250
1271	7	\N	\N	2	\N	\N	Little Foot	\N	250
1272	7	\N	\N	2	\N	\N	Little Foot	10	250
807	7	\N	\N	2	\N	\N	Chomper	\N	250
1275	7	\N	\N	2	\N	\N	Chomper	\N	250
1276	7	\N	\N	2	\N	\N	Chomper	14	250
1277	7	\N	\N	2	\N	\N	Chomper	17	250
1278	7	\N	\N	2	\N	\N	Chomper	17	250
1279	7	\N	\N	2	\N	\N	Chomper	19	250
1281	7	\N	\N	2	\N	\N	Chomper	20	250
1282	7	\N	\N	2	\N	\N	Chomper	21	250
1283	7	\N	\N	2	\N	\N	Chomper	21	250
1244	8	9	\N	2	1	\N	Thoroughbred	9	130
1188	8	9	\N	2	1	\N	Thoroughbred	25	130
1287	7	\N	\N	2	\N	\N	Chomper	\N	250
1285	7	\N	\N	2	\N	\N	Chomper	17	250
1284	7	\N	\N	2	\N	\N	Chomper	17	250
1288	7	\N	\N	2	\N	\N	Chomper	19	250
1289	7	\N	\N	2	\N	\N	Chomper	\N	250
1290	7	\N	\N	2	\N	\N	Chomper	28	250
1291	7	\N	\N	2	\N	\N	Chomper	20	250
1292	7	\N	\N	2	\N	\N	Chomper	29	250
1294	7	\N	\N	2	\N	\N	Chomper	\N	250
1295	7	\N	\N	2	\N	\N	Chomper	21	250
1297	7	\N	\N	2	\N	\N	Chomper	25	250
1296	7	\N	\N	2	\N	\N	Chomper	\N	250
1315	7	\N	\N	2	\N	\N	Chomper	9	250
1316	7	\N	\N	2	\N	\N	Chomper	15	250
1317	7	\N	\N	2	\N	\N	Chomper	10	250
1318	7	\N	\N	2	\N	\N	Chomper	17	250
1319	7	\N	\N	2	\N	\N	Chomper	17	250
1321	7	\N	\N	2	\N	\N	Chomper	10	250
1325	7	\N	\N	2	\N	\N	Chomper	10	250
1324	7	\N	\N	2	\N	\N	Chomper	10	250
1323	7	\N	\N	2	\N	\N	Chomper	19	250
1322	7	\N	\N	2	\N	\N	Chomper	19	250
1326	7	\N	\N	2	\N	\N	Chomper	20	250
1327	7	\N	\N	2	\N	\N	Chomper	11	250
1328	7	\N	\N	2	\N	\N	Chomper	17	250
1298	7	\N	\N	2	\N	\N	Chomper	9	250
1300	7	\N	\N	2	\N	\N	Chomper	10	250
1299	7	\N	\N	2	\N	\N	Chomper	10	250
1301	7	\N	\N	2	\N	\N	Chomper	11	250
1303	7	\N	\N	2	\N	\N	Chomper	16	250
1304	7	\N	\N	2	\N	\N	Chomper	16	250
1305	7	\N	\N	2	\N	\N	Chomper	16	250
1309	7	\N	\N	2	\N	\N	Chomper	16	250
1308	7	\N	\N	2	\N	\N	Chomper	16	250
1306	7	\N	\N	2	\N	\N	Chomper	16	250
1310	7	\N	\N	2	\N	\N	Chomper	16	250
1311	7	\N	\N	2	\N	\N	Chomper	16	250
1312	7	\N	\N	2	\N	\N	Chomper	16	250
1313	7	\N	\N	2	\N	\N	Chomper	20	250
1334	7	8	\N	2	1	\N	Model 13	16	180
1335	7	8	\N	2	1	\N	Model 13	16	180
1336	7	8	\N	2	1	\N	Model 13	18	180
1337	7	8	\N	2	1	\N	Model 13	18	180
1338	7	8	\N	2	1	\N	Model 13	\N	180
1339	7	8	\N	2	1	\N	Model 13	7	180
1342	7	8	\N	2	1	\N	Model 13	9	180
1341	7	8	\N	2	1	\N	Model 13	16	180
1340	7	8	\N	2	1	\N	Model 13	16	180
1345	7	8	\N	2	1	\N	Model 13	12	180
1344	7	8	\N	2	1	\N	Model 13	17	180
1346	7	8	\N	2	1	\N	Model 13	18	180
1348	7	9	\N	2	1	\N	Sharptooth	27	250
1347	7	9	\N	2	1	\N	Sharptooth	27	250
1273	7	\N	\N	2	\N	\N	Little Foot	\N	250
1176	8	9	\N	2	1	\N	Thoroughbred	35	130
1382	6	\N	\N	2	\N	\N	Covington	18	250
863	6	\N	\N	2	\N	\N	Covington	16	250
1390	6	8	\N	2	1	\N	Mendocino	19	250
1391	6	8	\N	2	1	\N	Mendocino	19	250
1383	6	8	\N	2	1	\N	Mendocino	19	250
1392	6	8	\N	2	1	\N	Mendocino	21	250
1384	6	8	\N	2	1	\N	Mendocino	21	250
1393	6	8	\N	2	1	\N	Mendocino	23	250
1386	6	8	\N	2	1	\N	Mendocino	23	250
1394	6	8	\N	2	1	\N	Mendocino	24	250
1385	6	8	\N	2	1	\N	Mendocino	24	250
1387	6	8	\N	2	1	\N	Mendocino	25	250
1388	6	8	\N	2	1	\N	Mendocino	27	250
1389	6	8	\N	2	1	\N	Mendocino	28	250
1372	6	10	\N	2	2	\N	Klamath	34	350
1374	6	10	\N	2	2	\N	Klamath	38	350
1373	6	10	\N	2	2	\N	Klamath	\N	350
1375	6	10	\N	2	2	\N	Deschutes	19	250
1376	6	10	\N	2	2	\N	Klamath	43	350
1377	6	10	\N	2	2	\N	Deschutes	18	250
1378	6	10	\N	2	2	\N	Deschutes	23	250
1379	6	10	\N	2	2	\N	Deschutes	21	250
1380	6	10	\N	2	2	\N	Deschutes	24	250
1381	6	10	\N	2	2	\N	Deschutes	27	250
1073	8	9	\N	2	1	\N	Thunderbird	54	180
1066	8	10	\N	2	3	\N	Orion	65	180
1090	8	9	\N	2	1	\N	Thunderbird	72	180
1075	8	9	\N	2	1	\N	Thunderbird	40	180
1070	8	9	\N	2	1	\N	Thunderbird	44	180
1159	8	9	\N	2	1	\N	Palomino	\N	180
1154	8	9	\N	2	1	\N	Palomino	62	180
1162	8	9	\N	2	1	\N	Thoroughbred	60	130
897	8	9	\N	2	1	\N	Palomino	60	180
1093	8	9	\N	2	1	\N	Palomino	64	180
898	8	9	\N	2	1	\N	Thoroughbred	48	130
1105	8	9	\N	2	1	\N	Thoroughbred	49	130
1111	8	9	\N	2	1	\N	Thoroughbred	67	130
1120	8	9	\N	2	1	\N	Thoroughbred	35	130
1130	8	9	\N	2	1	\N	Thorton	68	130
1136	8	10	\N	2	1	\N	Barton	68	130
1144	8	10	\N	2	1	\N	Barton	76	130
1241	8	10	\N	2	1	\N	Barton	25	130
1172	8	9	\N	2	1	\N	Corvette	35	180
1192	8	9	\N	2	1	\N	Thoroughbred	25	130
1043	8	7	\N	2	1	\N	Applebred	57	130
1038	8	7	\N	2	1	\N	Morgan	44	180
1245	8	9	\N	2	1	\N	Thoroughbred	25	130
914	8	9	\N	2	1	\N	Thoroughbred	62	130
1250	8	9	\N	2	1	\N	Thoroughbred	62	130
1261	23	\N	\N	2	\N	\N	5k86	14	350
1395	7	\N	\N	2	\N	\N	Little Foot	13	250
1268	7	\N	\N	2	\N	\N	Little Foot	14	250
1396	7	\N	\N	2	\N	\N	Little Foot	12	250
1397	7	\N	\N	2	\N	\N	Little Foot	9	250
1398	7	\N	\N	2	\N	\N	Little Foot	11	250
1274	7	\N	\N	2	\N	\N	Chomper	\N	250
1280	7	\N	\N	2	\N	\N	Chomper	19	250
1286	7	\N	\N	2	\N	\N	Chomper	\N	250
1399	7	\N	\N	2	\N	\N	Chomper	23	250
1400	7	\N	\N	2	\N	\N	Chomper	23	250
1293	7	\N	\N	2	\N	\N	Chomper	21	250
1314	7	\N	\N	2	\N	\N	Chomper	13	250
1320	7	\N	\N	2	\N	\N	Chomper	10	250
1329	7	\N	\N	2	\N	\N	Chomper	17	250
1302	7	\N	\N	2	\N	\N	Chomper	11	250
1307	7	\N	\N	2	\N	\N	Chomper	16	250
1333	7	8	\N	2	1	\N	Model 13	\N	180
1343	7	8	\N	2	1	\N	Model 13	9	180
858	7	9	\N	2	1	\N	Sharptooth	\N	250
1350	7	8	\N	2	1	\N	Sharptooth	18	250
1349	7	9	\N	2	1	\N	Sharptooth	18	250
1351	7	9	\N	2	1	\N	Sharptooth	29	250
1352	7	9	\N	2	1	\N	Sharptooth	20	250
1354	7	9	\N	2	1	\N	Sharptooth	\N	250
1353	7	9	\N	2	1	\N	Sharptooth	\N	250
1356	7	9	\N	2	1	\N	Sharptooth	16	250
1401	7	9	\N	2	1	\N	Sharptooth	16	250
1358	7	9	\N	2	1	\N	Sharptooth	16	250
1357	7	10	\N	2	1	\N	Sharptooth	16	250
1359	7	9	\N	2	1	\N	Sharptooth	16	250
1360	7	9	\N	2	1	\N	Sharptooth	16	250
1124	8	9	\N	2	1	\N	Thoroughbred	\N	130
1361	7	9	\N	2	1	\N	Model 13	16	180
1362	7	9	\N	2	1	\N	Model 13	16	180
1363	7	9	\N	2	1	\N	Model 13	16	180
1365	7	9	\N	2	1	\N	Model 13	9	180
1368	7	9	\N	2	1	\N	Model 13	16	180
1367	7	10	\N	2	1	\N	Model 13	16	180
1364	7	9	\N	2	1	\N	Model 13	9	180
1355	8	9	\N	2	1	\N	Sharptooth	16	250
1369	7	9	\N	2	1	\N	Model 13	17	180
1366	7	9	\N	2	1	\N	Model 13	14	180
1370	7	9	\N	2	1	\N	Model 13	18	180
1371	7	9	\N	2	1	\N	Model 13	19	180
1190	8	9	\N	2	1	\N	Thoroughbred	25	130
1402	6	10	\N	2	2	\N	Katmai	28	250
1403	6	10	\N	2	2	\N	Katmai	29	250
1404	6	10	\N	2	2	\N	Katmai	31	250
1405	6	10	\N	2	2	\N	Katmai	34	250
1406	6	10	\N	2	2	\N	Katmai	34	250
1407	6	12	\N	2	1	\N	Drake	38	250
1408	6	10	\N	2	1	\N	Drake	34	250
1409	6	12	\N	2	1	\N	Drake	43	250
1410	6	13	\N	2	1	\N	Drake	47	250
1411	6	12	\N	2	1	\N	Tanner	44	250
1412	6	13	\N	2	1	\N	Tanner	36	250
1413	6	10	\N	2	1	\N	Tanner	34	250
1414	6	12	\N	2	1	\N	Tanner	34	250
1415	6	13	\N	2	1	\N	Tanner	34	250
1416	6	9	\N	2	1	\N	Cascades	21	180
1417	6	9	\N	2	1	\N	Cascades	21	180
1418	6	12	\N	2	1	\N	Cascades	29	180
1419	6	13	\N	2	1	\N	Cascades	29	180
1420	6	12	\N	2	1	\N	Cascades	29	180
1421	6	13	\N	2	1	\N	Cascades	29	180
1422	6	9	\N	2	1	\N	Cascades	23	180
1423	6	9	\N	2	1	\N	Cascades	23	180
1424	6	9	\N	2	1	\N	Cascades	25	180
1425	6	9	\N	2	1	\N	Cascades	25	180
1426	6	9	\N	2	1	\N	Cascades	29	180
1427	6	9	\N	2	1	\N	Cascades	29	180
1428	6	13	\N	2	1	\N	Cascades	39	180
1429	6	13	\N	2	1	\N	Cascades	39	180
1430	6	9	\N	2	1	\N	Cascades	29	180
1431	6	9	\N	2	1	\N	Cascades	29	180
1432	6	9	\N	2	1	\N	Cascades	31	180
1433	6	9	\N	2	1	\N	Cascades	31	180
1434	6	9	\N	2	1	\N	Coppermine	14	180
1435	6	10	\N	2	1	\N	Tualatin	30	130
1436	6	9	\N	2	1	\N	Tualatin	29	130
1437	6	10	\N	2	1	\N	Tualatin	29	130
1438	6	9	\N	2	1	\N	Tualatin	30	130
1439	6	10	\N	2	1	\N	Tualatin	30	130
1440	6	9	\N	2	1	\N	Tualatin	30	130
1441	6	9	\N	2	1	\N	Tualatin	31	130
1442	6	10	\N	2	1	\N	Tualatin	32	130
1443	6	9	\N	2	1	\N	Coppermine-T	21	180
1444	6	9	\N	2	1	\N	Coppermine-T	26	180
1445	6	9	\N	2	1	\N	Coppermine-T	27	180
1446	6	9	\N	2	1	\N	Coppermine-T	29	180
1447	6	9	\N	2	1	\N	Coppermine-T	29	180
871	4	9	\N	2	1	\N	Willamette	52	180
1448	4	9	\N	2	1	\N	Willamette	55	180
1449	6	9	\N	2	1	\N	Coppermine	14	180
1450	6	9	\N	2	1	\N	Coppermine	16	180
1451	6	9	\N	2	1	\N	Coppermine	16	180
1452	6	9	\N	2	1	\N	Coppermine	17	180
1453	6	9	\N	2	1	\N	Coppermine	17	180
1454	6	9	\N	2	1	\N	Coppermine	18	180
1455	6	9	\N	2	1	\N	Coppermine	19	180
1456	6	9	\N	2	1	\N	Coppermine	19	180
1457	6	9	\N	2	1	\N	Coppermine	21	180
1458	6	9	\N	2	1	\N	Coppermine	21	180
1459	6	9	\N	2	1	\N	Coppermine	26	180
1460	6	9	\N	2	1	\N	Coppermine	27	180
1461	6	9	\N	2	1	\N	Coppermine	30	180
1462	6	9	\N	2	1	\N	Coppermine	33	180
1463	6	9	\N	2	1	\N	Coppermine	33	180
1464	6	9	\N	2	1	\N	Coppermine	14	180
1465	6	9	\N	2	1	\N	Coppermine	14	180
1466	6	9	\N	2	1	\N	Coppermine	16	180
1468	6	9	\N	2	1	\N	Coppermine	17	180
1467	6	9	\N	2	1	\N	Coppermine	16	180
1469	6	9	\N	2	1	\N	Coppermine	17	180
1897	5	24	\N	1	1	\N	EV56	\N	350
1470	6	9	\N	2	1	\N	Coppermine	18	180
1471	6	9	\N	2	1	\N	Coppermine	19	180
1472	6	9	\N	2	1	\N	Coppermine	19	180
1473	6	9	\N	2	1	\N	Coppermine	20	180
1474	6	9	\N	2	1	\N	Coppermine	21	180
1475	6	9	\N	2	1	\N	Coppermine	22	180
1476	6	9	\N	2	1	\N	Coppermine	23	180
1477	6	9	\N	2	1	\N	Coppermine	29	180
1478	6	9	\N	2	1	\N	Coppermine	23	180
1479	6	9	\N	2	1	\N	Coppermine	25	180
1480	6	9	\N	2	1	\N	Coppermine	31	180
1481	6	9	\N	2	1	\N	Coppermine	29	180
1482	6	9	\N	2	1	\N	Coppermine	29	180
1483	6	9	\N	2	1	\N	Coppermine	34	180
1484	6	9	\N	2	1	\N	Coppermine	33	180
1485	6	9	\N	2	1	\N	Coppermine	37	180
1493	6	8	\N	2	1	\N	Coppermine-128	28	180
1491	6	8	\N	2	1	\N	Coppermine-128	25	180
1492	6	8	\N	2	1	\N	Coppermine-128	27	180
1490	6	8	\N	2	1	\N	Coppermine-128	24	180
1489	6	8	\N	2	1	\N	Coppermine-128	23	180
1488	6	8	\N	2	1	\N	Coppermine-128	22	180
1487	6	8	\N	2	1	\N	Coppermine-128	20	180
1486	6	8	\N	2	1	\N	Coppermine-128	20	180
1494	6	8	\N	2	1	\N	Coppermine-128	28	180
1495	6	8	\N	2	1	\N	Coppermine-128	33	180
1496	6	8	\N	2	1	\N	Coppermine-128	34	180
1497	6	8	\N	2	1	\N	Coppermine-128	36	180
1498	6	8	\N	2	1	\N	Coppermine-128	40	180
1499	6	9	\N	2	1	\N	Tualatin-256	28	130
1500	6	9	\N	2	1	\N	Tualatin-256	29	130
1501	6	8	\N	2	1	\N	Tualatin-256	30	130
1502	6	9	\N	2	1	\N	Tualatin-256	34	130
1503	6	9	\N	2	1	\N	Tualatin-256	34	130
1504	6	9	\N	2	1	\N	Tualatin-256	\N	130
1505	4	9	\N	2	1	\N	Willamette	58	180
1506	4	9	\N	2	1	\N	Willamette	61	180
1508	4	9	\N	2	1	\N	Willamette	67	180
1509	4	9	\N	2	1	\N	Willamette	69	180
1510	4	9	\N	2	1	\N	Willamette	72	180
1507	4	9	\N	2	1	\N	Willamette	64	180
1511	4	9	\N	2	1	\N	Willamette	55	180
1512	4	9	\N	2	1	\N	Willamette	61	180
1513	4	9	\N	2	1	\N	Willamette	63	180
1514	4	9	\N	2	1	\N	Willamette	66	180
1515	4	9	\N	2	1	\N	Willamette	73	180
1516	4	9	\N	2	1	\N	Willamette	75	180
1517	4	9	\N	2	1	\N	Willamette-128	\N	180
1518	4	8	\N	2	1	\N	Willamette	63	180
1519	4	8	\N	2	1	\N	Willamette-128	66	180
1520	4	8	\N	2	1	\N	Willamette-128	\N	180
1521	4	8	\N	2	1	\N	Willamette-128	\N	180
1522	4	10	\N	2	1	\N	Northwood	47	130
1523	4	10	\N	2	1	\N	Northwood	\N	130
1524	4	10	\N	2	1	\N	Northwood	\N	130
1525	4	10	\N	2	1	\N	Northwood	54	130
1526	4	10	\N	2	1	\N	Northwood	57	130
1527	4	10	\N	2	1	\N	Northwood	60	130
1528	4	10	\N	2	1	\N	Northwood	61	130
1529	4	10	\N	2	1	\N	Northwood	63	130
1530	4	10	\N	2	1	\N	Northwood	68	130
1531	4	10	\N	2	1	\N	Northwood	\N	130
1532	4	10	\N	2	1	\N	Northwood	69	130
1533	4	10	\N	2	1	\N	Northwood	60	130
1534	4	10	\N	2	1	\N	Northwood	61	130
1535	4	10	\N	2	1	\N	Northwood	66	130
1536	4	10	\N	2	1	\N	Northwood	68	130
1537	4	10	\N	2	1	\N	Northwood	82	130
1538	4	10	\N	2	1	\N	Northwood	66	130
1539	4	10	\N	2	1	\N	Northwood	70	130
1540	4	10	\N	2	1	\N	Northwood	82	130
1541	4	10	\N	2	1	\N	Northwood	82	130
1542	4	10	\N	2	1	\N	Northwood	89	130
1543	4	8	\N	2	1	\N	Northwood-128	59	130
1544	4	8	\N	2	1	\N	Northwood-128	53	130
1545	4	8	\N	2	1	\N	Northwood-128	55	130
761	5	\N	\N	2	\N	\N	\N	2	350
1547	4	8	\N	2	1	\N	Northwood-128	57	130
1548	4	8	\N	2	1	\N	Northwood-128	58	130
1549	4	8	\N	2	1	\N	Northwood-128	60	130
1550	4	8	\N	2	1	\N	Northwood-128	61	130
1551	4	8	\N	2	1	\N	Northwood-128	63	130
1552	4	8	\N	2	1	\N	Northwood-128	67	130
1553	4	8	\N	2	1	\N	Northwood-128	68	130
922	4	10	13	2	1	1	Gallatin	92	130
1554	4	10	13	2	1	1	Gallatin	103	130
1555	4	10	13	2	1	1	Gallatin	110	130
1556	5	10	\N	2	1	\N	Prescott	89	90
1557	5	12	\N	2	1	\N	Prescott	89	90
962	4	\N	\N	1	\N	\N	M7	\N	\N
1558	5	12	\N	2	1	\N	Prescott	89	90
1559	5	12	\N	2	1	\N	Prescott	89	90
1560	5	12	\N	2	1	\N	Prescott	103	90
1561	5	12	\N	2	1	\N	Prescott	103	90
1562	5	12	\N	2	1	\N	Prescott	103	90
1563	5	12	\N	2	1	\N	Prescott	103	90
1564	5	12	\N	2	1	\N	Prescott	84	90
1565	5	12	\N	2	1	\N	Prescott	84	90
1566	5	12	\N	2	1	\N	Prescott	84	90
1574	5	12	\N	2	1	\N	Prescott	84	90
1575	5	12	\N	2	1	\N	Prescott	84	90
1576	5	12	\N	2	1	\N	Prescott	84	90
1577	5	12	\N	2	1	\N	Prescott	84	90
1578	5	12	\N	2	1	\N	Prescott	84	90
1898	23	\N	\N	1	\N	\N	PCA56	\N	350
1579	5	12	\N	2	1	\N	Prescott	84	90
1580	5	12	\N	2	1	\N	Prescott	84	90
1581	5	12	\N	2	1	\N	Prescott	84	90
1582	5	12	\N	2	1	\N	Prescott	84	90
1583	5	12	\N	2	1	\N	Prescott	84	90
1584	5	12	\N	2	1	\N	Prescott	84	90
1585	5	12	\N	2	1	\N	Prescott	84	90
1586	5	12	\N	2	1	\N	Prescott	84	90
1587	5	12	\N	2	1	\N	Prescott	84	90
1588	5	12	\N	2	1	\N	Prescott	84	90
1589	5	12	\N	2	1	\N	Prescott	84	90
1590	5	12	\N	2	1	\N	Prescott	84	90
1591	5	12	\N	2	1	\N	Prescott	84	90
1592	5	12	\N	2	1	\N	Prescott	84	90
1593	5	12	\N	2	1	\N	Prescott	84	90
1594	5	12	\N	2	1	\N	Prescott	115	90
1595	5	12	\N	2	1	\N	Prescott	84	90
1596	5	12	\N	2	1	\N	Prescott	115	90
1597	5	12	\N	2	1	\N	Prescott	84	90
1598	5	12	\N	2	1	\N	Prescott	115	90
1599	5	12	\N	2	1	\N	Prescott	115	90
1600	5	12	\N	2	1	\N	Prescott	115	90
1601	5	12	\N	2	1	\N	Prescott	115	90
1602	5	12	\N	2	1	\N	Prescott	115	90
1603	5	12	\N	2	1	\N	Prescott	115	90
1604	5	12	\N	2	1	\N	Prescott	115	90
1605	5	13	\N	2	1	\N	Prescott-2M	84	90
1606	5	12	\N	2	1	\N	Prescott-2M	84	90
1607	5	12	\N	2	1	\N	Prescott-2M	84	90
1609	5	13	\N	2	1	\N	Prescott-2M	115	90
1610	5	13	\N	2	1	\N	Prescott-2M	115	90
1611	5	13	\N	2	1	\N	Prescott-2M	84	90
1612	5	13	\N	2	1	\N	Prescott-2M	115	90
1613	5	13	\N	2	1	\N	Prescott-2M	115	90
1648	5	9	\N	2	1	\N	Prescott-256	73	90
1649	5	9	\N	2	1	\N	Prescott-256	73	90
1650	5	9	\N	2	1	\N	Prescott-256	73	90
1651	5	9	\N	2	1	\N	Prescott-256	73	90
1652	5	9	\N	2	1	\N	Prescott-256	73	90
1653	5	9	\N	2	1	\N	Prescott-256	73	90
1654	5	9	\N	2	1	\N	Prescott-256	73	90
1655	5	9	\N	2	1	\N	Prescott-256	73	90
1656	5	13	\N	2	1	\N	Cedar Mill	65	65
1657	5	13	\N	2	1	\N	Cedar Mill	86	65
1658	5	13	\N	2	1	\N	Cedar Mill	65	65
1659	5	13	\N	2	1	\N	Cedar Mill	86	65
1660	5	13	\N	2	1	\N	Cedar Mill	65	65
1661	5	13	\N	2	1	\N	Cedar Mill	86	65
1662	5	9	\N	2	1	\N	Prescott-256	84	90
1663	5	9	\N	2	1	\N	Prescott-256	84	90
1664	5	9	\N	2	1	\N	Prescott-256	84	90
1665	5	9	\N	2	1	\N	Prescott-256	84	90
1666	5	9	\N	2	1	\N	Prescott-256	84	90
1667	5	9	\N	2	1	\N	Prescott-256	84	90
1668	5	9	\N	2	1	\N	Prescott-256	84	90
1669	5	9	\N	2	1	\N	Prescott-256	84	90
1670	5	9	\N	2	1	\N	Prescott-256	84	90
1671	5	9	\N	2	1	\N	Prescott-256	84	90
1672	5	9	\N	2	1	\N	Prescott-256	84	90
1673	5	9	\N	2	1	\N	Prescott-256	84	90
1674	5	9	\N	2	1	\N	Prescott-256	84	90
1675	5	10	\N	2	1	\N	Cedar Mill-512	86	65
1676	5	10	\N	2	1	\N	Cedar Mill-512	65	65
1677	5	10	\N	2	1	\N	Cedar Mill-512	86	65
1678	5	10	\N	2	1	\N	Cedar Mill-512	65	65
1679	5	10	\N	2	1	\N	Cedar Mill-512	86	65
1680	5	10	\N	2	1	\N	Cedar Mill-512	65	65
1681	5	10	\N	2	1	\N	Cedar Mill-512	65	65
1682	6	13	\N	2	1	\N	Smithfield	95	90
1683	6	13	\N	2	1	\N	Smithfield	130	90
1684	6	13	\N	2	1	\N	Smithfield	130	90
924	6	13	\N	2	1	\N	Smithfield	130	90
1685	6	14	\N	2	1	\N	Presler	130	65
1686	6	14	\N	2	1	\N	Presler	95	65
1687	6	14	\N	2	1	\N	Presler	95	65
1688	6	14	\N	2	1	\N	Presler	95	65
1689	6	14	\N	2	1	\N	Presler	95	65
1690	6	14	\N	2	1	\N	Presler	95	65
1691	6	14	\N	2	1	\N	Presler	130	65
1692	6	14	\N	2	1	\N	Presler	95	65
1693	6	14	\N	2	1	\N	Presler	95	65
1694	6	14	\N	2	1	\N	Presler	130	65
1695	6	14	\N	2	1	\N	Presler	130	65
1696	6	14	\N	2	1	\N	Presler	95	65
1697	8	14	\N	2	1	\N	Conroe	65	65
1698	8	13	\N	2	1	\N	Conroe	65	65
1699	8	14	\N	2	1	\N	Conroe	65	65
1570	18	\N	\N	1	\N	\N	\N	\N	\N
1571	4	\N	\N	1	\N	\N	\N	\N	\N
1700	8	14	\N	2	1	\N	Conroe	65	65
1701	8	14	\N	2	1	\N	Conroe	65	65
1702	8	14	\N	2	1	\N	Conroe	65	65
1703	8	14	\N	2	1	\N	Conroe	65	65
1704	8	14	\N	2	1	\N	Conroe	65	65
1705	8	14	\N	2	1	\N	Conroe	65	65
1706	8	13	\N	2	1	\N	Allendale	65	65
1707	8	13	\N	2	1	\N	Allendale	65	65
1708	8	13	\N	2	1	\N	Allendale	65	65
1709	8	13	\N	2	1	\N	Allendale	65	65
1710	8	13	\N	2	1	\N	Allendale	65	65
1711	8	13	\N	2	1	\N	Allendale	65	65
1712	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1713	8	20	\N	2	1	\N	Wolfdale-3M	45	45
1714	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1715	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1716	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1717	8	20	\N	2	1	\N	Wolfdale-3M	45	45
1718	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1719	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1720	8	20	\N	2	1	\N	Wolfdale-3M	65	45
1721	8	21	\N	2	1	\N	Wolfdale	65	45
1722	8	20	\N	2	1	\N	Wolfdale	65	45
1723	8	21	\N	2	1	\N	Wolfdale	65	45
1724	8	21	\N	2	1	\N	Wolfdale	65	45
1725	8	21	\N	2	1	\N	Wolfdale	65	45
1726	8	21	\N	2	1	\N	Wolfdale	65	45
927	9	15	\N	2	1	\N	Kentsfield	130	65
1727	9	15	\N	2	1	\N	Kentsfield	130	65
1728	9	15	\N	2	1	\N	Kentsfield	130	65
1729	9	22	\N	2	1	\N	Yorkfield	130	45
1730	9	15	\N	2	1	\N	Kentsfield	105	65
1731	9	15	\N	2	1	\N	Kentsfield	105	65
1732	9	15	\N	2	1	\N	Kentsfield	95	65
1733	9	22	\N	2	1	\N	Yorkfield	65	45
1734	9	14	\N	2	1	\N	Yorkfield-6M	95	45
1735	9	14	\N	2	1	\N	Yorkfield-6M	65	45
1736	9	14	\N	2	1	\N	Yorkfield-6M	95	45
1737	9	14	\N	2	1	\N	Yorkfield-6M	95	45
1738	9	14	\N	2	\N	\N	Yorkfield-6M	95	45
1739	9	14	\N	2	1	\N	Yorkfield-6M	65	45
1740	9	21	\N	2	1	\N	Yorkfield-6M	95	45
1741	9	21	\N	2	1	\N	Yorkfield-6M	95	45
1742	9	21	\N	2	1	\N	Yorkfield-6M	65	45
1743	9	21	\N	2	\N	\N	Yorkfield-6M	95	45
1744	9	21	\N	2	1	\N	Yorkfield-6M	95	45
1745	9	21	\N	2	1	\N	Yorkfield-6M	65	45
1746	9	21	\N	2	1	\N	Yorkfield	95	45
1747	9	21	\N	2	1	\N	Yorkfield	65	45
1748	9	22	\N	2	1	\N	Yorkfield	95	45
1823	6	\N	\N	\N	\N	\N	Nx586	\N	500
1824	6	\N	\N	\N	\N	\N	Nx586	\N	500
1825	6	\N	\N	\N	\N	\N	Nx586	\N	500
1826	6	\N	\N	\N	\N	\N	Nx586	\N	440
1827	6	\N	\N	\N	\N	\N	Nx586	\N	500
1828	6	\N	\N	\N	\N	\N	Nx586	\N	440
1829	6	\N	\N	\N	\N	\N	Nx586	\N	500
1830	4	\N	\N	2	\N	\N	ZFx86	1	\N
1831	4	\N	\N	2	\N	\N	ZFx86	1	\N
1832	7	\N	\N	2	\N	\N	\N	13	350
1833	7	\N	\N	2	\N	\N	\N	15	350
1834	7	\N	\N	2	\N	\N	\N	16	350
1835	7	\N	\N	2	\N	\N	\N	13	250
1836	7	\N	\N	2	\N	\N	\N	14	250
1837	7	\N	\N	2	\N	\N	\N	12	250
1838	7	\N	\N	2	\N	\N	\N	13	250
1839	7	\N	\N	2	\N	\N	\N	14	25
1840	7	\N	\N	2	\N	\N	\N	16	250
1841	7	\N	\N	2	\N	\N	\N	\N	250
937	8	\N	\N	2	\N	\N	Samuel (C5A)	\N	180
1844	8	\N	\N	2	\N	\N	Samuel (C5A)	15	180
1843	8	\N	\N	2	\N	\N	Samuel (C5A)	14	180
1842	8	\N	\N	2	\N	\N	Samuel (C5A)	12	180
929	8	\N	\N	2	\N	\N	Samuel (C5A)	12	180
1845	8	\N	\N	2	\N	\N	Samuel (C5A)	15	180
1846	8	\N	\N	2	\N	\N	Samuel (C5A)	16	180
1847	8	\N	\N	2	\N	\N	Samuel (C5A)	16	180
1848	8	\N	\N	2	\N	\N	Samuel (C5A)	17	180
1849	8	\N	\N	2	\N	\N	Samuel (C5A)	\N	180
1850	8	\N	\N	2	\N	\N	Samuel (C5A)	\N	180
1851	8	\N	\N	2	\N	\N	Samuel (C5A)	\N	180
1852	8	7	\N	2	1	\N	Samuel 2 (C5B)	\N	150
1853	8	7	\N	2	1	\N	Samuel 2 (C5B)	2	150
1854	8	7	\N	2	1	\N	Samuel 2 (C5B)	3	150
1855	8	7	\N	2	1	\N	Samuel 2 (C5B)	3	150
1856	8	7	\N	2	1	\N	Samuel 2 (C5B)	11	150
1857	8	7	\N	2	1	\N	Samuel 2 (C5B)	11	150
1858	8	7	\N	2	1	\N	Samuel 2 (C5B)	13	150
1862	8	7	\N	2	1	\N	Ezra (C5C)	9	130
1860	8	7	\N	2	1	\N	Ezra (C5C)	8	130
931	8	7	\N	2	1	\N	Ezra (C5C)	\N	130
1859	8	7	\N	2	1	\N	Ezra (C5C)	\N	130
1861	8	7	\N	2	1	\N	Ezra-T (C5N)	\N	130
1863	8	7	\N	2	1	\N	Ezra (C5C)	9	130
1864	8	7	\N	2	1	\N	Ezra-T (C5N)	9	130
1865	8	7	\N	2	1	\N	Ezra (C5C)	9	130
1866	8	7	\N	2	1	\N	Ezra (C5C)	10	130
1867	8	7	\N	2	1	\N	Ezra-T (C5N)	10	130
1868	8	7	\N	2	1	\N	Ezra-T (C5N)	10	130
1869	8	7	\N	2	1	\N	Ezra-T (C5N)	10	130
1871	8	7	\N	2	1	\N	Nehemiah (C5P)	15	130
1870	8	7	\N	2	1	\N	Nehemiah (C5P)	15	130
1872	8	7	\N	2	1	\N	Nehemiah (C5P)	14	130
1873	8	7	\N	2	1	\N	Nehemiah (C5P)	17	130
1874	8	7	\N	2	1	\N	Nehemiah (C5P)	19	130
1875	5	\N	\N	1	\N	\N	EV4	\N	750
1876	5	\N	\N	1	\N	\N	EV4	\N	675
1877	5	\N	\N	1	\N	\N	EV4	\N	750
1878	6	\N	\N	1	\N	\N	EV45	\N	500
1881	6	\N	\N	1	\N	\N	EV45	\N	500
1880	6	\N	\N	1	\N	\N	EV45	\N	500
1879	6	\N	\N	1	\N	\N	EV45	\N	500
1882	6	\N	\N	1	\N	\N	EV45	\N	500
1883	5	\N	\N	1	\N	\N	EV4	\N	750
1884	5	24	\N	1	1	\N	EV5	\N	500
1885	5	24	\N	1	1	\N	EV5	\N	500
1886	5	24	\N	1	1	\N	EV5	\N	500
1887	5	24	\N	1	1	\N	EV5	\N	500
1888	5	24	\N	1	1	\N	EV5	\N	500
1890	5	24	\N	1	1	\N	EV56	\N	350
1889	5	24	\N	1	1	\N	EV56	\N	350
1891	5	24	\N	1	1	\N	EV56	\N	350
1892	5	24	\N	1	\N	\N	EV56	\N	350
1893	5	24	\N	1	1	\N	EV56	\N	350
1894	5	24	\N	1	1	\N	EV56	\N	350
1895	5	24	\N	1	1	\N	EV56	\N	350
1896	5	24	\N	1	1	\N	EV56	\N	350
1899	23	\N	\N	1	\N	\N	PCA56	\N	350
1900	23	\N	\N	1	\N	\N	PCA56	\N	350
1901	28	\N	\N	\N	\N	\N	68030	3	800
1902	28	\N	\N	\N	\N	\N	68030	3	\N
1903	28	\N	\N	\N	\N	\N	68030	3	\N
1904	28	\N	\N	\N	\N	\N	68030	3	800
1905	28	\N	\N	\N	\N	\N	68030	3	\N
1906	28	\N	\N	\N	\N	\N	68030	3	800
1907	28	\N	\N	\N	\N	\N	68030	3	\N
1908	28	\N	\N	\N	\N	\N	68030	3	\N
1909	28	\N	\N	\N	\N	\N	68030	3	800
1910	28	\N	\N	\N	\N	\N	68030	3	\N
1911	28	\N	\N	\N	\N	\N	68030	3	800
1912	28	\N	\N	\N	\N	\N	68030	3	\N
1913	28	\N	\N	\N	\N	\N	68030	3	800
1914	28	\N	\N	\N	\N	\N	68030	3	\N
1915	28	\N	\N	\N	\N	\N	68030	3	\N
1916	28	\N	\N	\N	\N	\N	68030	3	\N
1917	28	\N	\N	\N	\N	\N	68030	3	\N
1918	28	\N	\N	\N	\N	\N	68030	3	\N
1919	28	\N	\N	\N	\N	\N	68030	2	800
1920	4	\N	\N	\N	\N	\N	68040	5	650
1921	4	\N	\N	\N	\N	\N	68040	7	650
1922	4	\N	\N	\N	\N	\N	68040	3	650
1923	4	\N	\N	\N	\N	\N	68040	4	650
1924	4	\N	\N	\N	\N	\N	68040	5	650
1925	4	\N	\N	\N	\N	\N	68040	6	650
1926	4	\N	\N	\N	\N	\N	68040	3	650
1927	4	\N	\N	\N	\N	\N	68040	4	650
1928	4	\N	\N	\N	\N	\N	68040	5	650
1929	4	\N	\N	\N	\N	\N	68040	6	650
1930	5	\N	\N	\N	\N	\N	68060	\N	600
1931	5	\N	\N	\N	\N	\N	68060	5	420
1932	5	\N	\N	\N	\N	\N	68060	4	600
1934	5	\N	\N	\N	\N	\N	68060	\N	420
1933	5	\N	\N	\N	\N	\N	68060	5	420
1935	5	\N	\N	\N	\N	\N	68060	4	600
1936	5	\N	\N	\N	\N	\N	68060	\N	600
1937	5	\N	\N	\N	\N	\N	68060	5	420
1938	5	\N	\N	\N	\N	\N	68060	\N	420
1939	5	\N	\N	1	\N	\N	\N	\N	800
1940	5	\N	\N	1	\N	\N	\N	\N	800
1941	5	\N	\N	1	\N	\N	\N	\N	\N
1943	5	\N	\N	2	\N	\N	M1	\N	650
1944	5	\N	\N	2	\N	\N	M1	\N	650
1945	5	\N	\N	2	\N	\N	M1	\N	650
1946	5	\N	\N	2	\N	\N	M1	\N	650
1948	5	\N	\N	2	\N	\N	M1	\N	650
1949	5	\N	\N	2	\N	\N	M1	\N	650
1950	5	\N	\N	2	\N	\N	M1	\N	440
1947	5	\N	\N	2	\N	\N	M1	\N	650
1951	5	\N	\N	2	\N	\N	M1L	\N	500
1952	5	\N	\N	2	\N	\N	M1L	\N	350
1953	5	\N	\N	2	\N	\N	M1L	\N	500
1954	5	\N	\N	2	\N	\N	M1L	\N	350
1955	5	\N	\N	2	\N	\N	M1L	\N	350
1956	5	\N	\N	2	\N	\N	M1L	\N	350
1957	5	\N	\N	2	\N	\N	M1L	\N	350
1958	7	\N	\N	2	\N	\N	M2	\N	350
1959	7	\N	\N	2	\N	\N	M2	\N	350
1960	7	\N	\N	2	\N	\N	M2	\N	350
1961	7	\N	\N	2	\N	\N	M2	\N	350
1962	7	\N	\N	2	\N	\N	M2	\N	350
1963	7	\N	\N	2	\N	\N	M2	\N	350
1964	7	\N	\N	2	\N	\N	M2	\N	350
1965	7	\N	\N	2	\N	\N	M2	\N	350
1966	7	\N	\N	2	\N	\N	M2	\N	250
1967	7	\N	\N	2	\N	\N	M2	\N	250
1968	7	\N	\N	2	\N	\N	M2	\N	250
1969	7	\N	\N	2	\N	\N	M2	\N	250
1970	7	\N	\N	2	\N	\N	M2	\N	350
1971	7	\N	\N	2	\N	\N	M2	\N	350
1972	7	\N	\N	2	\N	\N	M2	\N	350
1973	7	\N	\N	2	\N	\N	M2	\N	350
1974	7	\N	\N	2	\N	\N	M2	\N	350
1975	7	\N	\N	2	\N	\N	M2	\N	350
1976	7	\N	\N	2	\N	\N	M2	\N	350
1977	7	\N	\N	2	\N	\N	M2	\N	350
1978	7	\N	\N	2	\N	\N	M2	\N	350
1979	7	\N	\N	2	\N	\N	M2	\N	350
1980	7	\N	\N	2	\N	\N	M2	\N	180
1981	7	\N	\N	2	\N	\N	M2	\N	350
1982	7	\N	\N	2	\N	\N	M2	\N	350
1983	7	\N	\N	2	\N	\N	M2	\N	180
1984	7	\N	\N	2	\N	\N	M2	\N	350
1985	7	\N	\N	2	\N	\N	M2	\N	250
1986	7	\N	\N	2	\N	\N	M2	\N	250
1988	7	\N	\N	2	\N	\N	M2	\N	180
1987	7	\N	\N	2	\N	\N	M2	\N	180
1989	7	\N	\N	2	\N	\N	M2	\N	180
1990	7	\N	\N	2	\N	\N	M2	\N	180
1332	5	\N	\N	2	\N	\N	GXm	\N	350
1330	5	\N	\N	2	\N	\N	GXm	\N	350
1991	5	\N	\N	2	\N	\N	GX	\N	400
1992	5	\N	\N	2	\N	\N	GX	\N	400
1993	5	\N	\N	2	\N	\N	GX	\N	400
1994	5	\N	\N	2	\N	\N	GX	\N	400
1995	5	\N	\N	2	\N	\N	GXi	\N	350
1996	5	\N	\N	2	\N	\N	GXi	\N	350
1997	5	\N	\N	2	\N	\N	GXi	\N	350
1998	\N	\N	\N	\N	\N	\N	\N	\N	\N
1999	\N	\N	\N	\N	\N	\N	\N	\N	\N
2000	\N	\N	\N	\N	\N	\N	\N	\N	\N
2001	18	\N	\N	1	\N	\N	\N	\N	\N
2002	18	\N	\N	1	\N	\N	\N	\N	\N
2003	18	\N	\N	1	\N	\N	\N	\N	\N
2004	18	\N	\N	1	\N	\N	\N	\N	\N
2005	18	\N	\N	1	\N	\N	\N	\N	\N
2006	18	\N	\N	1	\N	\N	\N	\N	\N
2007	18	\N	\N	1	\N	\N	\N	\N	\N
2008	18	\N	\N	1	\N	\N	\N	\N	\N
2009	18	\N	\N	1	\N	\N	\N	\N	\N
2010	18	\N	\N	1	\N	\N	\N	\N	\N
2011	18	\N	\N	1	\N	\N	\N	\N	\N
1942	5	\N	\N	1	\N	\N	\N	\N	\N
1569	18	\N	\N	1	\N	\N	\N	\N	\N
1573	4	\N	\N	1	\N	\N	\N	\N	\N
1027	5	\N	\N	2	\N	\N	P54CS	\N	350
920	6	\N	\N	2	\N	\N	Tillamook	\N	250
2015	5	\N	\N	2	\N	\N	P54C	\N	500
2016	5	\N	\N	2	\N	\N	P45C	\N	500
2017	6	\N	\N	2	\N	\N	P55C	\N	280
2018	6	\N	\N	2	\N	\N	P55C	\N	280
2019	6	\N	\N	2	\N	\N	P55C	\N	280
2020	5	\N	\N	2	\N	\N	Kirin	7	250
2022	5	\N	\N	2	\N	\N	Lynx	\N	180
2023	5	\N	\N	2	\N	\N	Lynx	11	180
2021	5	\N	\N	2	\N	\N	Kirin	9	250
999	5	9	\N	2	1	\N	P6	35	350
2024	5	\N	\N	2	\N	\N	M1sc	3	650
2025	5	\N	\N	2	\N	\N	M1sc	3	650
2026	5	\N	\N	2	\N	\N	M1sc	3	650
1015	5	\N	\N	1	\N	\N	P24C	\N	600
721	4	\N	\N	1	\N	\N	P4	\N	1000
2027	4	\N	\N	1	\N	\N	U5SD	\N	600
2028	4	\N	\N	1	\N	\N	U5SD	\N	600
2029	4	\N	\N	1	\N	\N	U5SX	\N	600
2030	4	\N	\N	1	\N	\N	M7	\N	\N
2031	4	\N	\N	2	\N	\N	M7	\N	\N
2033	4	\N	\N	1	\N	\N	M7	\N	\N
2032	4	\N	\N	1	\N	\N	M5	\N	\N
2034	4	\N	\N	1	\N	\N	M7	\N	\N
2035	4	\N	\N	2	\N	\N	M9	\N	\N
2036	4	\N	\N	1	\N	\N	M6	\N	\N
822	6	\N	\N	2	\N	\N	P24T	\N	\N
784	4	\N	\N	1	\N	\N	P23T	\N	\N
2037	\N	\N	\N	\N	\N	\N	\N	\N	\N
2038	\N	\N	\N	\N	\N	\N	\N	\N	\N
2039	\N	\N	\N	\N	\N	\N	\N	\N	\N
2040	\N	\N	\N	\N	\N	\N	\N	\N	\N
2041	\N	\N	\N	\N	\N	\N	\N	\N	\N
2042	\N	\N	\N	\N	\N	\N	\N	\N	\N
2043	\N	\N	\N	\N	\N	\N	\N	\N	\N
2044	\N	\N	\N	\N	\N	\N	\N	\N	\N
2045	\N	\N	\N	\N	\N	\N	\N	\N	\N
2046	\N	\N	\N	\N	\N	\N	\N	\N	\N
2047	\N	\N	\N	\N	\N	\N	\N	\N	\N
2048	\N	\N	\N	\N	\N	\N	\N	\N	\N
2049	\N	\N	\N	\N	\N	\N	\N	\N	\N
2050	\N	\N	\N	\N	\N	\N	\N	\N	\N
2051	\N	\N	\N	\N	\N	\N	\N	\N	\N
2052	\N	\N	\N	\N	\N	\N	\N	\N	\N
2053	\N	\N	\N	\N	\N	\N	\N	\N	\N
882	7	10	\N	2	1	\N	Conroe-L	35	65
2054	7	10	\N	2	1	\N	Conroe-L	35	65
2055	7	10	\N	2	\N	\N	Conroe-L	35	65
2057	8	10	\N	2	1	\N	Allendale	65	65
2056	7	10	\N	2	1	\N	Conroe-L	35	65
2058	8	10	\N	2	1	\N	Allendale	65	65
2059	8	10	\N	2	1	\N	Allendale	65	65
2060	8	10	\N	2	1	\N	Allendale	65	65
2061	8	12	\N	2	1	\N	Wolfdale-3M	65	45
2062	8	12	\N	2	1	\N	Wolfdale-3M	65	45
2063	8	12	\N	2	1	\N	Wolfdale-3M	65	45
2064	8	12	\N	2	1	\N	Allendale	65	65
2065	8	12	\N	2	1	\N	Allendale	65	65
2066	8	12	\N	2	1	\N	Allendale	65	65
2067	8	12	\N	2	1	\N	Allendale	65	65
2068	8	12	\N	2	1	\N	Wolfdale-3M	65	45
2069	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2070	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2072	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2073	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2074	8	12	\N	2	1	\N	Wolfdale-3M	65	45
2076	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2077	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2078	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2079	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2080	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2081	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2082	8	13	\N	2	1	\N	Wolfdale-3M	65	45
2083	8	13	\N	2	1	\N	Wolfdale-3M	65	45
900	8	10	\N	2	1	\N	ClawHammer	89	130
2084	8	10	\N	2	1	\N	ClawHammer	89	130
2085	8	12	\N	2	1	\N	ClawHammer	89	130
2086	8	10	\N	2	1	\N	ClawHammer	89	130
2087	8	10	\N	2	1	\N	ClawHammer	89	130
2088	8	12	\N	2	1	\N	ClawHammer	89	130
2089	8	12	\N	2	1	\N	ClawHammer	89	130
2090	8	12	\N	2	1	\N	ClawHammer	89	130
2091	8	10	\N	2	1	\N	ClawHammer	89	130
2092	8	12	\N	2	1	\N	ClawHammer	89	130
2093	8	12	\N	2	1	\N	SledgeHammer	89	130
2094	8	10	\N	2	1	\N	Newcastle	89	130
2095	8	10	\N	2	1	\N	Newcastle	89	130
2096	8	10	\N	2	1	\N	Newcastle	89	130
2097	8	10	\N	2	1	\N	Newcastle	89	130
2098	8	10	\N	2	1	\N	Newcastle	89	130
2099	8	9	\N	2	1	\N	Newcastle	89	130
2100	8	10	\N	2	1	\N	Newcastle	89	130
2101	8	10	\N	2	1	\N	Newcastle	89	130
2102	8	10	\N	2	1	\N	Newcastle	89	130
2103	8	10	\N	2	1	\N	Newcastle	89	130
2104	8	10	\N	2	1	\N	Winchester	67	90
2105	8	10	\N	2	1	\N	Winchester	67	90
2106	8	10	\N	2	1	\N	Winchester	67	90
2107	8	10	\N	2	1	\N	Venice	9	90
2108	8	10	\N	2	1	\N	Venice	51	90
2109	8	10	\N	2	1	\N	Venice	51	90
2110	8	10	\N	2	1	\N	Venice	59	90
2111	8	10	\N	2	1	\N	Venice	67	90
2112	8	9	\N	2	1	\N	Paris	62	130
2113	8	9	\N	2	1	\N	Palermo	62	90
2114	8	9	\N	2	1	\N	Palermo	62	90
2115	8	9	\N	2	1	\N	Palermo	62	90
2116	8	9	\N	2	1	\N	Palermo	62	90
2117	8	8	\N	2	1	\N	Palermo	62	90
2118	8	8	\N	2	1	\N	Palermo	62	90
2119	8	8	\N	2	1	\N	Palermo	62	90
2120	8	8	\N	2	1	\N	Palermo	62	90
2121	8	8	\N	2	1	\N	Palermo	62	90
2122	8	8	\N	2	1	\N	Palermo	62	90
2123	8	9	\N	2	1	\N	Palermo	62	90
2124	8	9	\N	2	1	\N	Palermo	62	90
2125	8	9	\N	2	1	\N	Palermo	62	90
2126	8	8	\N	2	1	\N	Palermo	62	90
2127	8	8	\N	2	1	\N	Palermo	62	90
2128	8	8	\N	2	1	\N	Palermo	62	90
2129	8	9	\N	2	1	\N	Palermo	62	90
953	8	10	\N	2	1	\N	ClawHammer	82	130
2130	8	8	\N	2	1	\N	Palermo	62	90
2131	8	8	\N	2	1	\N	Palermo	62	90
2132	8	9	\N	2	1	\N	Palermo	62	90
2133	8	8	\N	2	1	\N	Palermo	62	90
2134	8	9	\N	2	1	\N	Palermo	62	90
2135	8	10	\N	2	1	\N	Venice	67	90
2136	8	10	\N	2	1	\N	Venice	67	90
2137	8	10	\N	2	1	\N	Venice	67	90
2138	8	10	\N	2	1	\N	Venice	67	90
2139	8	10	\N	2	1	\N	Venice	89	90
2140	8	10	\N	2	1	\N	Manchester	67	90
2141	8	10	\N	2	1	\N	Manchester	67	90
2142	8	10	\N	2	1	\N	San Diego	67	90
2143	8	12	\N	2	1	\N	San Diego	89	90
2144	8	12	\N	2	1	\N	San Diego	89	90
2145	8	12	\N	2	1	\N	Toledo	89	90
2146	8	12	\N	2	1	\N	Toledo	89	90
2147	8	12	\N	2	1	\N	San Diego	104	90
2148	8	12	\N	2	1	\N	ClawHammer	89	130
2149	8	12	\N	2	1	\N	ClawHammer	104	130
2154	9	12	\N	2	1	\N	Toledo	89	90
2152	9	12	\N	2	1	\N	Manchester	89	90
2150	9	10	\N	2	1	\N	Manchester	89	90
2151	9	12	\N	2	1	\N	Manchester	89	90
2153	9	12	\N	2	1	\N	Manchester	110	90
2155	9	13	\N	2	1	\N	Toledo	110	90
2157	9	13	\N	2	1	\N	Toledo	89	90
2158	9	12	\N	2	1	\N	Toledo	110	90
2159	9	13	\N	2	1	\N	Toledo	110	90
2160	9	13	\N	2	1	\N	Toledo	110	90
907	8	12	\N	2	1	\N	Venus	85	90
2161	8	12	\N	2	1	\N	Venus	67	90
2163	8	12	\N	2	1	\N	Venus	85	90
2164	8	12	\N	2	1	\N	Venus	85	90
2165	8	12	\N	2	1	\N	Venus	104	90
2166	8	12	\N	2	1	\N	Venus	104	90
2167	8	12	\N	2	1	\N	Venus	104	90
2168	9	13	\N	2	1	\N	Denmark	110	90
2169	9	13	\N	2	1	\N	Denmark	110	90
2170	9	13	\N	2	1	\N	Denmark	110	90
2171	9	13	\N	2	1	\N	Denmark	110	90
2172	9	13	\N	2	1	\N	Denmark	110	90
2174	9	13	\N	2	1	\N	Denmark	110	90
2175	8	10	\N	2	1	\N	Orleans	62	90
2176	8	10	\N	2	1	\N	Orleans	62	90
2177	8	10	\N	2	1	\N	Orleans	62	90
2178	8	10	\N	2	1	\N	Orleans	62	90
2179	8	12	\N	2	1	\N	Orleans	45	90
2180	8	12	\N	2	1	\N	Orleans	45	90
2181	8	12	\N	2	1	\N	Orleans	45	90
2182	8	10	\N	2	1	\N	Orleans	35	90
2183	8	10	\N	2	1	\N	Lima	15	65
2184	8	10	\N	2	1	\N	Lima	22	65
2185	8	10	\N	2	1	\N	Lima	45	65
2186	8	10	\N	2	1	\N	Lima	45	65
2187	8	10	\N	2	1	\N	Lima	45	65
2188	8	10	\N	2	1	\N	Lima	45	65
2189	8	10	\N	2	1	\N	Lima	45	65
2191	8	10	\N	2	1	\N	Lima	8	65
2192	8	10	\N	2	1	\N	Lima	15	65
2193	8	10	\N	2	1	\N	Lima	25	65
2194	8	9	\N	2	1	\N	Manila	62	90
2195	8	8	\N	2	1	\N	Manila	62	90
2196	8	9	\N	2	1	\N	Manila	62	90
2197	8	8	\N	2	1	\N	Manila	62	90
2198	8	9	\N	2	1	\N	Manila	62	90
2199	8	9	\N	2	1	\N	Manila	62	90
2200	8	9	\N	2	1	\N	Manila	35	90
2201	8	8	\N	2	1	\N	Manila	35	90
2202	8	9	\N	2	1	\N	Manila	35	90
2203	8	8	\N	2	1	\N	Manila	35	90
2204	8	9	\N	2	1	\N	Sparta	45	65
2205	8	9	\N	2	1	\N	Sparta	45	65
2206	8	10	\N	2	1	\N	Sparta	45	65
2207	8	10	\N	2	1	\N	Sparta	45	65
2208	8	10	\N	2	1	\N	Sparta	45	65
2209	9	10	\N	2	1	\N	Brisbane	65	65
2210	9	10	\N	2	1	\N	Brisbane	65	65
2211	9	10	\N	2	1	\N	Brisbane	65	65
2213	8	12	\N	2	1	\N	Sargas	45	45
2212	8	10	\N	2	1	\N	Sargas	45	45
2215	8	12	\N	2	1	\N	Sargas	45	45
2216	8	12	\N	2	1	\N	Sargas	45	45
2218	9	12	\N	2	1	\N	Regor	45	45
2217	9	12	\N	2	1	\N	Regor	45	45
2219	8	8	\N	2	1	\N	Dublin	62	130
2220	8	9	\N	2	1	\N	Dublin	62	130
2221	8	8	\N	2	1	\N	Dublin	62	130
2222	8	8	\N	2	1	\N	Dublin	25	130
2223	8	9	\N	2	1	\N	Dublin	25	130
2224	8	8	\N	2	1	\N	Georgetown	62	90
2225	26	9	\N	2	1	\N	Georgetown	62	90
2226	8	8	\N	2	1	\N	Georgetown	62	90
2227	8	9	\N	2	1	\N	Georgetown	62	90
2228	8	8	\N	2	1	\N	Georgetown	62	90
2229	8	8	\N	2	1	\N	Sonora	25	90
2230	8	9	\N	2	1	\N	Sonora	25	90
2231	8	8	\N	2	1	\N	Sonora	25	90
2232	8	9	\N	2	1	\N	Sonora	25	90
2233	8	8	\N	2	1	\N	Albany	62	90
2234	8	9	\N	2	1	\N	Albany	62	90
2235	8	8	\N	2	1	\N	Albany	62	90
2236	8	9	\N	2	1	\N	Albany	62	90
2237	8	8	\N	2	1	\N	Albany	62	90
2238	8	9	\N	2	1	\N	Roma	25	90
2239	8	8	\N	2	1	\N	Roma	25	90
2240	8	9	\N	2	1	\N	Roma	25	90
2241	8	8	\N	2	1	\N	Roma	25	90
2242	8	9	\N	2	1	\N	Roma	25	90
954	8	10	\N	2	1	\N	Lancaster	35	90
2243	8	12	\N	2	1	\N	Lancaster	35	90
2244	8	10	\N	2	1	\N	Lancaster	35	90
2245	8	12	\N	2	1	\N	Lancaster	35	90
2246	8	12	\N	2	1	\N	Lancaster	35	90
2247	8	12	\N	2	1	\N	Lancaster	35	90
2248	8	10	\N	2	1	\N	Lancaster	35	90
2250	8	12	\N	2	1	\N	Lancaster	35	90
2251	8	10	\N	2	1	\N	Lancaster	25	90
2252	8	12	\N	2	1	\N	Lancaster	25	90
2253	8	10	\N	2	1	\N	Lancaster	25	90
2254	8	12	\N	2	1	\N	Lancaster	25	90
2255	8	12	\N	2	1	\N	Lancaster	25	90
2256	8	12	\N	2	1	\N	Lancaster	25	90
2257	8	12	\N	2	1	\N	ClawHammer	82	130
2258	8	12	\N	2	1	\N	ClawHammer	82	130
2259	8	12	\N	2	1	\N	ClawHammer	82	130
2260	8	12	\N	2	1	\N	ClawHammer	82	130
2261	8	12	\N	2	1	\N	ClawHammer	82	130
2262	8	12	\N	2	1	\N	ClawHammer	62	130
2263	8	12	\N	2	1	\N	ClawHammer	62	130
2264	8	12	\N	2	1	\N	ClawHammer	62	130
2265	8	13	\N	2	1	\N	ClawHammer	62	130
2266	8	10	\N	2	1	\N	ClawHammer	35	130
2267	8	10	\N	2	1	\N	Odessa	82	130
2268	8	10	\N	2	1	\N	Odessa	35	130
2269	8	10	\N	2	1	\N	Odessa	35	130
2270	8	10	\N	2	1	\N	Odessa	35	130
2271	8	10	\N	2	1	\N	Oakville	35	90
2272	8	10	\N	2	1	\N	Oakville	35	90
2273	8	10	\N	2	\N	\N	Oakville	35	90
2274	8	12	\N	2	1	\N	Newark	62	90
2275	8	12	\N	2	\N	\N	Newark	62	90
2276	8	12	\N	2	1	\N	Newark	62	90
2277	8	12	\N	2	1	\N	Newark	62	90
2278	8	12	\N	2	1	\N	Newark	62	90
2279	9	13	\N	2	1	\N	Windsor	89	90
2280	9	12	\N	2	1	\N	Windsor	89	90
2281	9	13	\N	2	1	\N	Windsor	89	90
2282	9	12	\N	2	1	\N	Windsor	89	90
2283	9	13	\N	2	1	\N	Windsor	89	90
2284	9	12	\N	2	1	\N	Windsor	89	90
2285	9	13	\N	2	1	\N	Windsor	89	90
2286	9	12	\N	2	1	\N	Windsor	89	90
2287	9	13	\N	2	1	\N	Windsor	89	90
2288	9	13	\N	2	1	\N	Windsor	125	90
2289	9	13	\N	2	1	\N	Windsor	89	90
2290	9	13	\N	2	1	\N	Windsor	125	90
2291	9	10	\N	2	1	\N	Windsor	65	90
2292	9	12	\N	2	\N	\N	Windsor	65	90
2293	9	13	\N	2	1	\N	Windsor	65	90
2294	9	12	\N	2	1	\N	Windsor	65	90
2295	9	13	\N	2	1	\N	Windsor	65	90
2296	9	12	\N	2	1	\N	Windsor	65	90
2297	9	13	\N	2	1	\N	Windsor	65	90
2298	9	12	\N	2	1	\N	Windsor	65	90
2299	9	13	\N	2	1	\N	Windsor	65	90
2300	9	12	\N	2	1	\N	Windsor	35	90
2301	9	12	\N	2	1	\N	Brisbane	65	65
2302	9	12	\N	2	1	\N	Brisbane	65	65
2303	9	12	\N	2	1	\N	Brisbane	65	65
2304	9	12	\N	2	1	\N	Brisbane	65	65
2305	9	12	\N	2	1	\N	Brisbane	65	65
2306	9	12	\N	2	1	\N	Brisbane	65	65
2307	9	12	\N	2	1	\N	Brisbane	65	65
2308	9	12	\N	2	1	\N	Brisbane	65	65
2309	9	12	\N	2	1	\N	Brisbane	65	65
2310	9	12	\N	2	1	\N	Brisbane	65	65
2311	9	12	\N	2	1	\N	Brisbane	65	65
2312	9	12	\N	2	1	\N	Brisbane	65	65
2313	9	12	\N	2	1	\N	Brisbane	89	65
2315	9	12	\N	2	1	\N	Brisbane	89	65
2317	9	12	\N	2	1	\N	Brisbane	45	65
2318	9	12	\N	2	1	\N	Brisbane	45	65
2319	9	12	\N	2	1	\N	Brisbane	45	65
2320	9	12	\N	2	1	\N	Brisbane	45	65
2321	9	12	\N	2	1	\N	Brisbane	22	65
2322	9	12	\N	2	1	\N	Brisbane	45	65
2323	9	12	\N	2	1	\N	Brisbane	45	65
2324	9	12	\N	2	1	\N	Brisbane	45	65
2325	9	12	\N	2	1	\N	Brisbane	45	65
2326	9	12	\N	2	1	\N	Brisbane	45	65
2327	9	12	\N	2	1	\N	Brisbane	45	65
2328	9	12	\N	2	1	\N	Brisbane	65	65
2329	9	12	\N	2	1	\N	Brisbane	65	65
2330	9	12	\N	2	1	\N	Brisbane	65	65
2331	9	12	\N	2	1	\N	Brisbane	65	65
2332	7	12	\N	2	1	\N	Banias	22	130
2333	7	12	\N	2	1	\N	Banias	25	130
2334	7	12	\N	2	1	\N	Banias	25	130
2335	7	12	\N	2	1	\N	Banias	25	130
2336	7	12	\N	2	1	\N	Banias	25	130
2337	7	12	\N	2	1	\N	Banias	25	130
2338	7	13	\N	2	1	\N	Dothan	21	90
2341	7	13	\N	2	1	\N	Dothan	21	90
2339	7	13	\N	2	1	\N	Dothan	21	90
2340	7	13	\N	2	1	\N	Dothan	21	90
2343	\N	\N	\N	\N	\N	\N	\N	\N	\N
2342	\N	\N	\N	\N	\N	\N	\N	\N	\N
2344	\N	\N	\N	\N	\N	\N	\N	\N	\N
2345	\N	\N	\N	\N	\N	\N	\N	\N	\N
2346	\N	\N	\N	\N	\N	\N	\N	\N	\N
2347	\N	\N	\N	\N	\N	\N	\N	\N	\N
2348	\N	\N	\N	\N	\N	\N	\N	\N	\N
2349	\N	\N	\N	\N	\N	\N	\N	\N	\N
1608	5	13	\N	2	1	\N	Prescott-2M	84	90
59	7	13	\N	2	1	\N	Dothan	21	90
60	7	13	\N	2	1	\N	Dothan	21	90
61	7	13	\N	2	1	\N	Dothan	21	90
62	4	\N	\N	2	\N	\N	\N	\N	\N
63	4	\N	\N	2	\N	\N	\N	\N	\N
64	4	\N	\N	2	\N	\N	\N	\N	\N
65	4	\N	\N	2	\N	\N	\N	\N	\N
66	4	\N	\N	2	\N	\N	\N	\N	\N
67	4	\N	\N	2	\N	\N	\N	\N	\N
68	4	\N	\N	2	\N	\N	\N	\N	\N
69	4	\N	\N	2	\N	\N	\N	\N	\N
72	5	\N	\N	2	\N	\N	GX1	3	180
78	5	\N	\N	2	\N	\N	GX1	4	180
76	5	\N	\N	2	\N	\N	GX1	3	180
75	5	\N	\N	2	\N	\N	GX1	3	180
73	5	\N	\N	2	\N	\N	GX1	3	180
71	5	\N	\N	2	\N	\N	GX1	3	180
80	5	\N	\N	2	\N	\N	GX1	5	180
79	5	\N	\N	2	\N	\N	GX1	5	180
77	5	\N	\N	2	\N	\N	GX1	4	180
74	5	\N	\N	2	\N	\N	GX1	3	180
81	5	\N	\N	2	\N	\N	GXLV	8	250
82	5	\N	\N	2	\N	\N	GXLV	8	250
84	5	\N	\N	2	\N	\N	GXLV	8	250
83	5	\N	\N	2	\N	\N	GXLV	8	250
85	5	\N	\N	2	\N	\N	GXLV	6	250
86	5	\N	\N	2	\N	\N	GXLV	6	250
87	5	5	\N	\N	\N	\N	GXLV	4	250
88	5	\N	\N	2	\N	\N	GXLV	4	250
89	5	\N	\N	2	\N	\N	GXLV	4	250
90	5	\N	\N	2	\N	\N	GXLV	4	250
91	5	\N	\N	2	\N	\N	GXLV	4	250
92	5	\N	\N	2	\N	\N	GXLV	4	250
95	5	\N	\N	2	\N	\N	GXm	\N	350
96	5	\N	\N	2	\N	\N	GXm	\N	350
97	5	\N	\N	2	\N	\N	GXm	\N	350
98	5	\N	\N	2	\N	\N	GXm	\N	350
99	5	\N	\N	2	\N	\N	GXm	\N	350
100	5	\N	\N	2	\N	\N	GXm	\N	350
101	5	\N	\N	2	\N	\N	GXm	\N	350
102	5	\N	\N	2	\N	\N	GXm	\N	350
103	5	\N	\N	2	\N	\N	GXm	\N	350
104	5	\N	\N	2	\N	\N	GXm	\N	350
105	5	\N	\N	2	\N	\N	GXm	\N	350
106	5	\N	\N	2	\N	\N	GXm	\N	350
107	5	\N	\N	2	\N	\N	GXm	\N	350
108	5	\N	\N	2	\N	\N	GXm	\N	350
109	5	\N	\N	2	\N	\N	GXm	\N	350
110	5	\N	\N	2	\N	\N	GXm	\N	350
111	5	\N	\N	2	\N	\N	GXm	\N	350
112	5	\N	\N	2	\N	\N	GXm	\N	350
113	5	\N	\N	2	\N	\N	GXm	\N	350
114	5	\N	\N	2	\N	\N	GXm	\N	350
115	5	\N	\N	2	\N	\N	GXm	\N	350
116	5	\N	\N	2	\N	\N	GXm	\N	350
120	4	9	\N	2	1	\N	Foster	56	180
121	4	9	\N	2	1	\N	Foster	59	180
122	4	9	\N	2	1	\N	Foster	66	180
123	4	9	\N	2	1	\N	Foster	77	180
124	4	9	10	2	1	1	Foster	64	180
125	4	9	10	2	1	1	Foster	68	180
126	4	9	12	2	1	1	Foster	72	180
127	4	10	\N	2	1	\N	Prestonia	55	130
128	4	10	\N	2	1	\N	Prestonia	58	130
129	4	10	\N	2	1	\N	Prestonia	58	130
130	4	10	\N	2	1	\N	Prestonia	61	130
132	4	10	\N	2	1	\N	Prestonia	65	130
131	4	10	\N	2	1	\N	Prestonia	65	130
133	4	10	\N	2	1	\N	Prestonia	60	130
135	4	10	\N	2	1	\N	Prestonia	74	130
134	4	10	\N	2	1	\N	Prestonia	72	130
136	4	10	\N	2	1	\N	Prestonia	74	130
137	4	10	\N	2	1	\N	Prestonia	85	130
138	4	10	\N	2	1	\N	Prestonia	85	130
139	4	10	\N	2	1	\N	Prestonia	30	130
140	4	10	\N	2	1	\N	Prestonia	35	130
141	4	10	\N	2	1	\N	Prestonia	40	130
142	4	10	12	2	1	1	Gallatin	77	130
143	4	10	12	2	1	1	Gallatin	77	130
144	4	10	12	2	1	1	Gallatin	87	130
145	4	10	12	2	1	1	Gallatin	92	130
146	4	10	13	2	1	1	Gallatin	92	130
147	4	10	12	2	1	1	Gallatin	48	130
148	4	10	12	2	1	1	Gallatin	55	130
149	4	10	12	2	1	1	Gallatin	57	130
150	4	10	13	2	1	1	Gallatin	57	130
151	4	10	13	2	1	1	Gallatin	65	130
152	4	10	12	2	1	1	Gallatin	66	130
153	4	10	13	2	1	1	Gallatin	80	130
154	4	10	13	2	1	1	Gallatin	72	130
155	4	10	14	2	1	1	Gallatin	85	130
156	5	12	\N	2	1	\N	Cranford	110	90
157	5	12	\N	2	1	\N	Cranford	110	90
158	5	12	14	2	1	1	Potomac	130	90
159	5	12	15	2	1	1	Potomac	130	90
160	5	12	15	2	1	1	Potomac	130	90
161	5	12	\N	2	1	\N	Nocona	103	90
162	5	12	\N	2	1	\N	Nocona	103	90
163	5	12	\N	2	1	\N	Nocona	103	90
164	5	12	\N	2	1	\N	Nocona	103	90
165	5	12	\N	2	1	\N	Nocona	103	90
166	5	12	\N	2	1	\N	Nocona	103	90
167	5	12	\N	2	1	\N	Nocona	103	90
168	5	12	\N	2	1	\N	Nocona	55	90
169	5	13	\N	2	1	\N	Irwindale	110	90
170	5	13	\N	2	1	\N	Irwindale	110	90
171	5	13	\N	2	1	\N	Irwindale	110	90
172	5	13	\N	2	1	\N	Irwindale	110	90
173	5	13	\N	2	1	\N	Irwindale	110	90
174	5	13	\N	2	1	\N	Irwindale	110	90
175	5	13	\N	2	1	\N	Irwindale	110	90
176	5	13	\N	2	1	\N	Irwindale	110	90
177	5	13	\N	2	1	\N	Irwindale	110	90
178	5	13	\N	2	1	\N	Irwindale	110	90
179	5	13	\N	2	1	\N	Irwindale	110	90
180	5	13	\N	2	1	\N	Irwindale	110	90
181	5	13	\N	2	\N	\N	Irwindale	90	90
182	5	13	\N	2	1	\N	Irwindale	55	90
183	24	\N	\N	2	\N	\N	Crusoe	\N	220
184	24	\N	\N	2	\N	\N	Crusoe	\N	220
185	24	\N	\N	2	\N	\N	Crusoe	\N	220
186	7	9	\N	2	1	\N	Crusoe	6	180
187	7	9	\N	2	1	\N	Crusoe	6	180
188	7	9	\N	2	1	\N	Crusoe	6	180
189	7	9	\N	2	1	\N	Crusoe	7	180
190	8	10	\N	2	1	\N	Crusoe	\N	130
191	7	10	\N	2	1	\N	Crusoe	\N	180
192	7	10	\N	2	1	\N	Crusoe	\N	180
194	7	10	\N	2	1	\N	Crusoe	\N	180
197	7	10	\N	2	1	\N	Crusoe	\N	180
200	7	10	\N	2	1	\N	Crusoe	\N	180
201	8	9	\N	2	1	\N	Crusoe	5	130
202	8	10	\N	2	1	\N	Crusoe	\N	130
203	8	10	\N	2	1	\N	Crusoe	\N	130
204	8	10	\N	2	1	\N	Crusoe	\N	130
205	8	10	\N	2	1	\N	Crusoe	\N	130
206	8	10	\N	2	1	\N	Crusoe	\N	130
207	8	10	\N	2	1	\N	Crusoe	\N	130
208	8	10	\N	2	1	\N	Crusoe	\N	130
209	8	10	\N	2	1	\N	Crusoe	\N	130
210	8	10	\N	2	1	\N	Crusoe	\N	130
211	8	10	\N	2	1	\N	Crusoe	\N	130
213	8	10	\N	2	1	\N	Crusoe	7	130
212	8	10	\N	2	1	\N	Crusoe	7	130
214	8	10	\N	2	1	\N	Crusoe	8	130
215	8	10	\N	2	1	\N	Crusoe	9	130
216	8	10	\N	2	1	\N	Crusoe	10	130
1125	8	9	\N	2	1	\N	Thoroughbred	\N	130
1099	8	9	\N	2	1	\N	Palomino	35	180
1226	8	10	\N	2	1	\N	Barton	53	130
1230	8	10	\N	2	1	\N	Barton	72	130
429	7	13	\N	2	1	\N	Dothan	21	65
430	7	13	\N	2	1	\N	Dothan	21	90
431	7	13	\N	2	1	\N	Dothan	27	90
432	7	13	\N	2	1	\N	Dothan	21	90
433	7	13	\N	2	1	\N	Dothan	21	90
434	7	13	\N	2	1	\N	Dothan	27	90
435	7	13	\N	2	1	\N	Dothan	27	65
436	7	13	\N	2	1	\N	Dothan	27	90
437	7	13	\N	2	1	\N	Dothan	27	90
438	7	13	\N	2	1	\N	Dothan	27	90
439	7	13	\N	2	1	\N	Dothan	27	90
884	7	10	\N	2	1	\N	Banias-512	24	130
440	7	10	\N	2	1	\N	Banias-512	24	130
441	7	10	\N	2	1	\N	Banias-512	24	130
442	7	10	\N	2	1	\N	Banias-512	24	130
446	7	12	\N	2	1	\N	Dothan-1024	21	90
447	7	12	\N	2	1	\N	Dothan-1024	21	90
448	7	12	\N	2	1	\N	Dothan-1024	21	90
449	7	12	\N	2	1	\N	Dothan-1024	21	90
450	7	12	\N	2	1	\N	Dothan-1024	21	90
451	7	12	\N	2	1	\N	Dothan-1024	21	90
453	\N	\N	\N	\N	\N	\N	\N	\N	\N
994	\N	\N	\N	\N	\N	\N	\N	\N	1500
454	\N	\N	\N	\N	\N	\N	\N	\N	1500
455	\N	\N	\N	\N	\N	\N	\N	\N	1500
119	\N	\N	\N	\N	\N	\N	\N	\N	800
456	\N	\N	\N	\N	\N	\N	\N	\N	800
457	\N	\N	\N	\N	\N	\N	\N	\N	800
458	\N	\N	\N	\N	\N	\N	\N	\N	800
459	\N	\N	\N	\N	\N	\N	\N	\N	800
460	\N	\N	\N	\N	\N	\N	\N	\N	800
461	\N	\N	\N	\N	\N	\N	\N	\N	\N
\.


--
-- Data for Name: processor_platform_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processor_platform_type (id, name) FROM stdin;
1	Unidentified
2	286
3	386DX
14	8088
22	386SX
23	8086
49	Socket 563
41	80188
54	80186
55	Z80
10	Pentium Pro
4	486
8	Pentium (P54)
5	486 (DX4)
26	Pentium (P5)
9	Pentium MMX (P55)
29	Pentium M
31	Athlon
25	Pentium III (Coppermine) (FC-PGA)
44	Pentium III (Tualatin) (FC-PGA 2)
45	Celeron (Mendocino) (PPGA)
27	Pentium 4
56	ZFx86
57	68030
58	68040
59	68060
60	Alpha
61	PowerPC 603
42	K6-2 (Super Socket 7)
62	8087
63	287
64	187
65	387DX
66	387SX
67	487SX
48	VIA C3
68	VIA C7
69	Nx587
11	Nx586
53	MediaGXm
70	MediaGX
73	STPC
74	Geode GX1
75	Athlon Mobile
77	Athlon XP
78	Pentium Mobile (P54)
79	Athlon MP
80	Pentium III (Katmai)
81	Pentium II (Deschutes)
12	Pentium II (Klamath)
82	Athlon 64 Mobile
33	Athlon 64
34	Opteron
35	Athlon 64 X2
39	Athlon 64 FX
71	Phenom
72	Phenom II
83	Pentium D
84	Pentium III Xeon (Tanner)
6	Xeon (Foster)
21	Xeon (Prestonia)
86	Xeon (Gallatin)
87	Xeon (Nocona)
88	Xeon (Irwindale)
89	Xeon (Potomac)
85	Pentium III Xeon (Cascades 2.8V)
90	Pentium III Xeon (Cascades 5/12V)
91	Xeon (Cranford)
13	Pentium II Xeon (Drake)
76	Mobile K6-2(+) (Mobile Super Socket 7)
92	Transmeta Crusoe
47	Core 2 Duo (65 nm)
93	Core 2 Quad (65 nm)
94	Core 2 Duo (45 nm)
95	Core 2 Quad (45 nm)
96	WTL4167
97	SiS 55x
\.


--
-- Data for Name: processor_platform_type_processor_platform_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processor_platform_type_processor_platform_type (processor_platform_type_source, processor_platform_type_target) FROM stdin;
\.


--
-- Data for Name: processor_voltage; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.processor_voltage (id, processor_id, value) FROM stdin;
1	714	5
2	716	5
3	719	5
4	721	5
5	724	5
6	726	3.3
7	730	5
8	731	5
9	733	5
10	734	5
11	766	3.45
12	771	5
13	793	2.9
14	804	2.9
15	805	3.5
16	806	2.9
17	807	2.2
18	809	3.3
19	810	2.8
20	811	2.8
21	812	5
22	813	3.3
23	814	3.1
24	818	5
25	828	5
26	832	5
27	833	5
28	858	2.2
29	859	2
30	860	5
31	861	5
33	863	2
34	864	2
35	865	1.5
36	866	1.65
37	867	1.475
38	868	1.475
39	869	3.3
40	871	1.75
41	872	1.75
46	877	1.75
62	894	1.6
63	895	1.7
64	896	1.7
65	897	1.75
66	898	1.6
67	899	1.65
68	900	1.5
69	901	1.5
71	903	1.35
72	904	1.35
75	907	1.35
76	908	1.5
78	910	1.5
79	911	1.6
80	912	1.75
81	913	1.5
82	914	1.6
83	915	1.4
84	916	1.35
86	918	2
87	919	1.7
88	920	1.9
89	921	1.4
91	923	1.525
99	933	2
100	934	2
101	935	2.8
102	936	5
103	942	1.75
104	943	1.6
105	944	1.6
106	945	1.4
107	946	1.4
108	947	1.5
109	948	1.55
110	949	1.2
111	950	1.45
112	951	1.35
114	953	1.5
115	954	1.35
116	955	2.9
117	956	2.9
118	957	1
123	984	3.3
124	985	5
125	986	5
126	987	5
127	988	5
128	989	5
129	990	5
130	991	5
131	992	5
132	993	5
133	994	5
134	995	5
135	996	5
136	997	3.3
137	998	3.3
138	999	3.3
139	1000	3.3
140	1003	3.3
141	1004	3.3
142	1005	3.3
143	1006	5
144	1007	3.3
145	1008	5
146	1009	5
147	1010	5
148	1011	5
149	1012	5
150	1013	5
151	1014	5
152	1015	3.3
153	1016	5
154	1017	5
155	1018	5
156	1019	3.3
157	1020	5
158	1021	3.3
159	1022	3.3
160	1023	3.3
161	1024	3.3
162	1025	3.3
163	1026	3.3
164	1027	3.3
165	1028	2.8
166	1029	2.8
167	1030	2.2
168	1031	1.6
169	1032	1.6
170	1033	1.6
171	1034	1.6
172	1035	1.6
173	1036	1.6
174	1037	1.6
175	1038	1.75
176	1039	1.75
177	1040	1.75
178	1041	1.75
179	1042	1.75
180	1043	1.5
181	1044	1.5
182	1045	1.4
183	1046	1.5
184	1047	1.5
185	1048	1.5
42	873	1.5
119	958	1.475
47	878	1.475
186	1049	1.5
120	959	1.25
44	875	1.25
49	880	1.25
50	881	1.25
92	924	1.2
93	925	1.2
55	887	1.2
56	888	0.85
94	926	0.85
95	927	0.85
96	928	0.85
60	892	0.85
61	893	0.85
97	929	1.8
98	930	1.6
52	883	0.85
51	882	1
59	891	0.85
58	890	0.85
73	905	1.3
70	902	1.25
85	917	1.25
74	906	1.3
77	909	1.3
113	952	0.95
121	960	0.956
122	961	0.988
187	1050	1.5
188	1051	1.5
189	1052	1.5
190	1053	1.6
191	1054	1.6
54	885	1.004
192	1055	1.6
193	1056	1.6
194	1057	1.6
195	1058	1.6
196	1059	1.6
197	1060	1.6
198	1061	1.6
199	1062	1.7
200	1063	1.7
201	1064	1.8
202	1065	1.8
203	1066	1.8
204	1067	1.7
205	1068	1.7
206	1069	1.7
207	1070	1.7
208	1071	1.75
209	1072	1.75
210	1073	1.75
211	1074	1.75
212	1075	1.75
213	1076	1.75
214	1077	1.75
215	1078	1.75
216	1079	1.75
217	1080	1.75
218	1081	1.75
219	1082	1.75
220	1083	1.75
221	1084	1.75
222	1085	1.75
223	1086	1.75
224	1087	1.75
225	1088	1.75
226	1089	1.75
227	1090	1.75
228	1091	1.75
229	1092	1.75
230	1093	1.75
231	1094	1.75
232	1095	1.75
233	1096	1.75
234	1097	1.75
235	1098	1.6
236	1099	1.6
237	1100	1.55
238	1101	1.5
239	1102	1.45
240	1103	1.5
241	1104	1.5
242	1105	1.6
243	1106	1.6
244	1107	1.6
245	1108	1.6
246	1109	1.65
247	1110	1.6
248	1111	1.65
249	1112	1.6
250	1113	1.6
251	1114	1.65
252	1115	1.65
253	1116	1.65
254	1117	1.65
255	1118	1.65
256	1119	1.65
257	1120	1.45
258	1121	1.45
259	1122	1.45
260	1123	1.4
261	1124	1.6
262	1125	1.6
263	1126	1.5
264	1127	1.6
265	1128	1.5
266	1129	1.6
267	1130	1.65
268	1131	1.65
269	1132	1.65
270	1133	1.65
271	1134	1.65
272	1135	1.65
273	1136	1.65
274	1137	1.65
275	1138	1.65
276	1139	1.65
277	1140	1.65
278	1141	1.65
279	1142	1.65
280	1143	1.65
281	1144	1.65
282	1145	1.65
283	1146	1.5
284	1147	1.5
285	1148	1.65
286	1149	1.5
287	1150	1.5
288	1151	1.8
289	1152	1.75
290	1153	1.75
291	1154	1.75
292	1155	1.75
293	1156	1.75
294	1157	1.75
295	1158	1.75
296	1159	1.55
297	1160	1.65
298	1161	1.65
299	1162	1.65
300	1163	1.65
301	1164	1.6
302	1165	1.4
303	1166	1.4
304	1167	1.4
305	1168	1.4
306	1169	1.6
307	1170	1.6
308	1171	1.35
309	1172	1.4
310	1173	1.4
311	1174	1.45
312	1175	1.45
313	1176	1.45
314	1177	1.45
315	1178	1.45
316	1179	1.4
317	1180	1.45
318	1181	1.45
319	1182	1.45
320	1183	1.4
321	1184	1.4
322	1185	1.4
323	1186	1.3
324	1187	1.3
325	1188	1.3
326	1189	1.3
327	1190	1.25
328	1191	1.25
329	1192	1.25
330	1193	1.25
331	1194	1.25
332	1195	1.55
333	1196	1.55
334	1197	1.45
335	1198	1.5
336	1199	1.5
337	1200	1.45
338	1201	1.45
339	1202	1.6
340	1203	1.6
341	1204	1.6
342	1205	1.65
343	1206	1.5
344	1207	1.35
345	1208	1.35
346	1209	1.35
347	1210	1.35
348	1211	1.35
349	1212	1.35
350	1213	1.35
351	1214	1.2
352	1215	1.2
353	1216	1.25
354	1217	1.25
355	1218	1.35
356	1219	1.35
359	1222	1.35
360	1223	1.45
361	1224	1.45
362	1225	1.45
363	1226	1.55
364	1227	1.6
365	1228	1.65
366	1229	1.65
367	1230	1.65
368	1231	1.65
369	1232	1.35
370	1233	1.35
371	1234	1.4
357	1220	0.95
372	1235	1.25
373	1236	1.35
374	1237	1.25
375	1238	1.25
376	1239	1.35
377	1240	1.35
378	1241	1.25
379	1242	1.3
380	1243	1.35
381	1244	1.1
382	1245	1.25
383	1246	1.4
384	1247	1.65
385	1248	1.6
386	1249	1.6
387	1250	1.6
388	1251	1.6
389	1252	1.6
390	1253	1.6
391	1254	1.6
392	1255	1.6
393	1256	1.6
394	1257	1.6
395	1258	3.5
396	1259	3.5
397	1260	3.5
398	1261	3.5
399	1262	3.5
400	1263	3.5
401	1264	3.5
402	1265	2.9
403	1266	3.2
404	1267	3.3
405	1268	2.2
406	1269	2.2
407	1270	2
408	1271	2.1
409	1272	2
410	1273	2.1
411	1274	2.2
412	1275	2.2
413	1276	2.2
414	1277	2.2
415	1278	2.2
416	1279	2.2
417	1280	2.2
418	1281	2.2
419	1282	2.2
420	1283	2.2
421	1284	2.2
422	1285	2.2
423	1286	2.4
424	1287	2.4
425	1288	2.2
426	1289	2.3
427	1290	2.4
428	1291	2.2
429	1292	2.4
430	1293	2.2
431	1294	2.4
432	1295	2.2
433	1296	2.2
434	1297	2.3
435	1298	1.8
436	1299	1.8
437	1300	1.8
438	1301	1.8
439	1302	1.8
440	1303	2.2
441	1304	2.2
442	1305	2.2
443	1306	2.2
444	1307	2.2
445	1308	2
446	1309	2
447	1310	2.1
448	1311	2.1
449	1312	2
450	1313	2.1
451	1314	2.2
452	1315	1.9
453	1316	2.2
454	1317	1.9
455	1318	2.2
456	1319	2.2
457	1320	1.9
458	1321	1.9
459	1322	2.2
460	1323	2.2
461	1324	1.9
462	1325	1.9
463	1326	2.2
464	1327	1.9
465	1328	2.2
466	1329	2.2
467	1330	2.2
468	1331	2.9
469	1332	2.9
470	1333	2.1
471	1334	2
472	1335	2
473	1336	2
474	1337	2
475	1338	2
476	1339	1.5
477	1340	2
478	1341	2
479	1342	1.6
480	1343	1.6
481	1344	2
482	1345	1.7
483	1346	2
484	1347	2.4
485	1348	2.4
486	1349	2.2
487	1350	2.2
488	1351	2.4
489	1352	2.2
490	1353	2.2
491	1354	2.2
492	1355	2.2
493	1356	2.2
494	1357	2
495	1358	2
496	1359	2
497	1360	2
498	1361	2
499	1362	2
500	1363	2
501	1364	1.6
502	1365	1.6
503	1366	1.8
504	1367	2
505	1368	2
506	1369	2
507	1370	2
508	1371	2
509	1372	2.8
510	1373	2.8
511	1374	2.8
512	1375	2
513	1376	2.8
514	1377	2
515	1378	2
516	1379	2
517	1380	2
518	1381	2
519	1382	2
520	1383	2
521	1384	2
522	1385	2
523	1386	2
524	1387	2
525	1388	2
526	1389	2
527	1390	2
528	1391	2
529	1392	2
530	1393	2
531	1394	2
532	1395	2.2
533	1396	2.2
534	1397	2
535	1398	2.1
536	1399	2.2
537	1400	2.2
538	1401	2.2
539	1402	2
540	1403	2
541	1404	2
542	1405	2.05
543	1406	2.05
544	1407	2
545	1408	2
546	1409	2
547	1410	2
548	1411	2
549	1412	2
550	1413	2
551	1414	2
552	1415	2
553	1416	2.8
554	1417	5
555	1418	2.8
556	1419	2.8
557	1420	5
558	1421	5
559	1422	2.8
560	1423	5
561	1424	2.8
562	1425	5
563	1426	2.8
564	1427	5
565	1428	2.8
566	1429	5
567	1430	2.8
568	1431	5
569	1432	2.8
570	1433	5
571	1434	1.65
572	1435	1.475
573	1436	1.475
574	1437	1.45
575	1438	1.475
576	1439	1.45
577	1440	1.475
578	1441	1.475
579	1442	1.45
580	1443	1.75
581	1444	1.75
582	1445	1.75
583	1446	1.75
584	1447	1.75
585	1448	1.75
588	1434	1.7
589	1449	1.65
590	1449	1.7
591	1450	1.65
592	1450	1.7
593	1451	1.65
594	1451	1.7
595	1452	1.65
596	1452	1.7
597	1453	1.65
598	1453	1.7
599	1455	1.65
600	1455	1.7
601	1456	1.65
602	1456	1.7
603	1457	1.65
604	1457	1.7
605	1458	1.65
606	1458	1.7
607	1459	1.65
608	1459	1.7
609	1460	1.65
610	1460	1.7
611	1461	1.7
612	1462	1.7
613	1463	1.7
32	862	1.6
614	1464	1.65
615	1454	1.65
616	1454	1.7
617	1465	1.6
618	1465	1.65
619	1465	1.7
620	1466	1.65
621	1466	1.7
622	1466	1.75
623	1467	1.65
624	1467	1.7
625	1469	1.65
626	1469	1.7
627	1470	1.65
628	1470	1.7
629	1470	1.75
630	1471	1.65
631	1471	1.7
632	1471	1.75
633	1472	1.65
634	1472	1.7
635	1472	1.75
636	1473	1.65
637	1473	1.7
638	1473	1.75
639	1474	1.65
640	1474	1.7
641	1474	1.75
642	1475	1.65
643	1475	1.7
644	1475	1.75
645	1476	1.65
646	1476	1.7
647	1476	1.75
648	1477	1.75
649	1478	1.7
650	1478	1.75
651	1479	1.7
652	1479	1.75
653	1480	1.75
654	1481	1.75
655	1482	1.7
656	1482	1.75
657	1482	1.76
658	1483	1.75
659	1484	1.75
660	1485	1.75
661	865	1.7
662	1486	1.5
663	1486	1.7
664	1486	1.75
665	1487	1.5
666	1487	1.7
667	1487	1.75
668	1488	1.65
669	1488	1.7
670	1488	1.75
671	1489	1.65
672	1489	1.7
673	1489	1.75
674	1490	1.65
675	1490	1.7
676	1490	1.75
677	1491	1.65
678	1491	1.7
679	1491	1.75
680	1492	1.65
681	1492	1.7
682	1492	1.75
683	1493	1.65
684	1493	1.7
685	1493	1.75
686	1494	1.7
687	1494	1.75
688	1495	1.75
689	1496	1.75
690	1497	1.75
691	1498	1.75
692	1499	1.475
693	1500	1.475
694	1501	1.475
695	1501	1.5
696	1502	1.5
697	1503	1.5
698	1504	1.5
699	1448	1.7
700	871	1.7
701	1505	1.7
702	1505	1.75
703	1506	1.75
704	1507	1.75
705	1508	1.75
706	1509	1.75
707	1510	1.75
708	1511	1.75
709	1512	1.75
710	1513	1.75
711	1514	1.75
712	1515	1.75
713	1516	1.75
714	1517	1.75
715	1518	1.75
716	1519	1.75
717	1520	1.75
718	1521	1.75
719	1522	1.475
720	1522	1.5
721	1524	1.525
722	1526	1.475
723	1526	1.525
724	1527	1.475
725	1527	1.525
726	1528	1.475
727	1528	1.525
728	1529	1.475
729	1529	1.525
730	1530	1.475
731	1530	1.55
732	1531	1.55
733	1532	1.475
734	1532	1.525
735	1533	1.475
736	1533	1.525
737	1534	1.475
738	1534	1.525
739	1535	1.475
740	1535	1.525
741	1536	1.475
742	1536	1.525
743	1537	1.475
744	1537	1.55
745	1538	1.475
746	1538	1.525
747	958	1.525
748	1539	1.475
749	1539	1.525
750	1540	1.475
751	1540	1.55
752	1541	1.475
753	1541	1.55
754	1542	1.475
755	1542	1.55
756	1543	1.475
757	1543	1.525
758	878	1.525
759	1545	1.475
760	1545	1.525
761	755	3.3
762	757	3.3
763	761	3.3
764	760	3.3
765	759	3.3
766	739	3.3
767	740	3.3
768	747	5
769	743	3.3
770	756	3.3
771	754	3.3
772	737	3.3
773	778	5
774	786	5
775	775	5
776	773	5
777	788	3.45
778	788	3.6
779	787	3.45
780	787	3.6
781	777	3.45
782	962	3.45
783	836	5
784	1547	1.475
785	1547	1.525
786	1548	1.475
787	1548	1.525
788	1549	1.475
789	1549	1.525
790	1550	1.475
791	1550	1.525
792	1551	1.475
793	1551	1.525
794	1552	1.475
795	1552	1.525
796	1553	1.475
797	1553	1.525
798	922	1.525
90	922	1.475
799	1554	1.475
800	1554	1.6
801	1555	1.525
802	1555	1.6
803	923	1.6
804	1556	1.25
805	1556	1.4
806	874	1.25
807	874	1.4
808	1557	1.25
809	1557	1.4
810	1558	1.25
811	1558	1.4
812	959	1.4
813	1559	1.25
814	1559	1.4
815	1560	1.25
816	1560	1.4
817	1561	1.25
818	1561	1.4
819	1562	1.25
820	1562	1.4
821	1563	1.25
822	1563	1.4
823	875	1.425
824	1564	1.25
825	1564	1.4
826	1565	1.25
827	1565	1.4
828	1566	1.25
829	1566	1.4
830	782	5
831	783	5
833	826	5
834	825	5
835	1569	5
836	823	5
837	1570	5
838	824	5
839	824	3.3
840	1571	5
841	1571	3.3
842	1573	5
843	1573	3.3
844	826	3.3
845	1574	1.25
846	1574	1.4
847	1575	1.25
848	1575	1.4
849	1577	1.25
850	1577	1.4
851	1576	1.25
852	1576	1.4
853	1578	1.25
854	1578	1.4
855	1579	1.25
856	1579	1.4
857	1580	1.25
858	1580	1.4
859	1581	1.25
860	1581	1.4
861	1582	1.25
862	1582	1.4
863	1583	1.25
864	1583	1.4
865	1584	1.25
866	1584	1.4
867	1585	1.25
868	1585	1.4
869	1586	1.25
870	1586	1.4
871	1587	1.25
872	1587	1.4
873	1588	1.25
874	1588	1.4
875	1589	1.25
876	1589	1.4
877	1590	1.25
878	1590	1.425
879	1591	1.25
880	1591	1.425
881	1592	1.25
882	1592	1.425
883	1593	1.25
884	1593	1.425
885	1594	1.25
886	1594	1.425
887	1595	1.25
888	1595	1.425
889	1596	1.25
890	1596	1.425
891	1597	1.25
892	1597	1.425
893	1598	1.25
894	1598	1.425
895	1599	1.25
896	1599	1.425
897	1600	1.25
898	1600	1.425
899	1601	1.25
900	1601	1.425
901	1602	1.25
902	1602	1.425
903	1603	1.25
904	1603	1.425
905	1604	1.25
906	1604	1.425
907	1605	1.25
908	1605	1.4
909	1606	1.25
910	1606	1.4
911	1607	1.25
912	1607	1.4
913	1608	1.25
914	1608	1.425
915	1609	1.25
916	1609	1.4
917	1610	1.25
918	1610	1.4
919	1611	1.25
920	1611	1.4
921	1612	1.25
922	1612	1.4
923	1613	1.25
924	1613	1.4
925	1648	1.25
926	1648	1.4
927	879	1.25
928	879	1.4
929	1649	1.25
930	1649	1.4
931	1650	1.25
932	1650	1.4
933	1651	1.25
934	1651	1.4
935	1652	1.25
936	1652	1.4
937	1653	1.25
938	1653	1.4
939	1654	1.25
940	1654	1.4
941	1655	1.25
942	1655	1.4
943	1656	1.2
944	1656	1.3375
945	1657	1.2
946	1657	1.3375
947	1658	1.2
948	1658	1.3375
949	1659	1.2
950	1659	1.3375
951	1660	1.2
952	1660	1.3375
953	1661	1.2
954	1661	1.3375
955	880	1.4
956	1662	1.25
957	1662	1.4
958	1663	1.25
959	1663	1.4
960	1664	1.25
961	1664	1.4
962	1665	1.25
963	1665	1.4
964	1666	1.25
965	1666	1.4
966	1667	1.25
967	1667	1.4
968	1668	1.25
969	1668	1.4
970	1669	1.25
971	1669	1.4
972	1670	1.25
973	1670	1.4
974	1671	1.25
975	1671	1.4
976	1672	1.25
977	1672	1.4
978	1673	1.25
979	1673	1.4
980	1674	1.25
981	1674	1.4
983	1675	1.25
985	1676	1.25
986	1676	1.325
987	1677	1.25
988	1677	1.325
989	1678	1.25
990	1678	1.325
991	1679	1.25
992	1679	1.325
982	881	1.325
984	1675	1.325
993	1680	1.25
994	1680	1.325
995	1681	1.25
996	1681	1.325
997	886	1.2
998	886	1.4
999	1683	1.2
1000	1683	1.4
1001	1684	1.2
1002	1684	1.4
1003	1682	1.2
1004	1682	1.4
1005	924	1.4
1006	925	1.3375
1007	1685	1.2
1008	1685	1.3375
1009	887	1.3375
1010	1686	1.2
1011	1686	1.3375
1012	1687	1.2
1013	1687	1.3375
1014	1688	1.2
1015	1688	1.3375
1016	1689	1.2
1017	1689	1.3375
1018	1690	1.2
1019	1690	1.3375
1020	1691	1.2
1021	1691	1.3375
1022	1692	1.2
1023	1692	1.3375
1024	1693	1.2
1025	1693	1.3375
1026	1694	1.2
1027	1694	1.3375
1028	1695	1.2
1029	1695	1.3375
1030	1696	1.2
1031	1696	1.3375
1032	888	1.5
1033	1697	0.85
1034	1697	1.5
1035	1698	0.85
1036	1698	1.5
1037	1699	0.85
1038	1699	1.5
1039	1700	0.85
1040	1700	1.5
1041	1701	0.85
1042	1701	1.5
1043	1702	0.85
1044	1702	1.5
1045	1703	0.85
1046	1703	1.5
1047	1704	0.85
1048	1704	1.5
1049	1705	0.85
1050	1705	1.5
1051	1706	0.85
1052	1706	1.5
1053	1707	0.85
1054	1707	1.5
1055	1708	0.85
1056	1708	1.5
1057	1709	0.85
1058	1709	1.5
1059	1710	0.85
1060	1710	1.5
1061	1711	0.85
1062	1711	1.5
1063	1712	0.85
1064	1712	1.3625
1065	1713	0.85
1066	1713	1.3625
1067	1714	0.85
1068	1714	1.3625
1069	1715	0.85
1070	1715	1.3625
1071	1716	0.85
1072	1716	1.3625
1073	1717	0.85
1074	1717	1.3625
1075	1718	0.85
1076	1718	1.3625
1077	1719	0.85
1078	1719	1.3625
1079	1720	0.85
1080	1720	1.3625
1081	889	1.3625
1082	889	0.85
1083	1721	0.85
1084	1721	1.3625
1085	1722	0.85
1086	1722	1.3625
1087	1723	0.85
1088	1723	1.36
1089	1725	0.85
1090	1725	1.3625
1091	1726	0.85
1092	1726	1.3625
1093	926	1.5
1094	927	1.5
1095	1727	0.85
1096	1727	1.5
1097	1728	0.85
1098	1728	1.5
1099	928	1.3625
1100	1729	0.85
1101	1729	1.3625
1102	892	1.5
1103	1730	0.85
1104	1730	1.5
1105	1731	0.85
1106	1731	1.5
1107	1732	0.85
1108	1732	1.5
1109	893	1.3625
1110	1733	0.85
1111	1733	1.3625
1112	1734	0.85
1113	1734	1.3625
1114	1735	0.85
1115	1735	1.3625
1116	1736	0.85
1117	1736	1.3625
1118	1737	0.85
1119	1737	1.3625
1120	1738	0.85
1121	1738	1.3625
1122	1739	0.85
1123	1739	1.3625
1124	1740	0.85
1125	1740	1.3625
1126	1741	0.85
1127	1741	1.3625
1128	1742	0.85
1129	1742	1.3625
1130	1743	0.85
1131	1743	1.3625
1132	1744	0.85
1133	1744	1.3625
1134	1745	0.85
1135	1745	1.3625
1136	1746	0.85
1137	1746	1.3625
1138	1747	0.85
1139	1747	1.3625
1140	1748	0.85
1141	1748	1.3625
1142	1823	4
1143	808	4
1144	1824	4
1145	1825	4
1146	1827	4
1147	1826	4
1148	1828	4
1149	1829	4
1150	963	2.5
1151	1830	2.5
1152	1831	2.5
1276	1943	3.3
1157	1836	3.52
1158	1837	3.52
1159	1835	3.52
1160	1838	3.52
1161	1839	3.52
1162	1840	3.52
1163	1841	2.8
1164	835	3.52
1153	834	3.52
1156	1834	3.52
1154	1832	3.52
1155	1833	3.52
1165	937	1.8
1166	1843	1.8
1167	1844	1.9
1168	1845	2
1169	1846	1.8
1170	1847	1.8
1171	1848	1.8
1172	1849	1.8
1173	1850	1.8
1174	1851	1.8
1175	1852	1.6
1176	1853	1.6
1177	1854	1.6
1178	1854	1.65
1179	1855	1.6
1180	931	1.35
1181	1856	1.6
1182	1857	1.6
1183	1858	1.65
1184	1859	1.35
1185	1860	1.35
1186	1861	1.35
1187	1862	1.35
1188	1863	1.35
1189	1864	1.35
1190	1865	1.35
1191	932	1.25
1192	1866	1.35
1193	1868	1.35
1194	1867	1.35
1195	1842	1.8
1196	1869	1.35
1197	1870	1.25
1198	1871	1.25
1199	1872	1.4
1200	1873	1.45
1201	1874	1.4
1202	769	3.3
1203	1875	3.3
1204	1876	3.3
1205	1877	3.3
1206	1878	3.3
1207	1879	3.3
1208	1880	3.3
1209	1881	3.3
1210	1882	3.3
1211	1884	2.5
1212	1885	2.5
1213	1886	2.5
1214	1887	2.5
1215	1888	2.5
1216	1890	2
1217	1889	2
1218	1891	2
1219	1892	2
1220	1893	2
1221	1894	2
1222	1895	2
1223	1896	2
1224	1897	2
1225	1898	2.5
1226	1899	2.5
1227	1900	2.5
1228	710	5
1229	1901	5
1230	1902	5
1231	1903	5
1232	1904	5
1233	1905	5
1234	1906	5
1235	1907	5
1236	1908	5
1237	1909	5
1238	1910	5
1239	1911	5
1240	1912	5
1241	1913	5
1242	1914	5
1243	1915	5
1244	1916	5
1245	1917	5
1246	1918	5
1247	1919	5
1248	1921	5
1249	1920	5
1250	711	5
1251	1922	5
1252	1923	5
1253	1924	5
1254	1925	5
1255	1926	5
1256	1927	5
1257	1928	5
1258	1929	5
1259	712	3.3
1260	1930	3.3
1261	1931	3.3
1262	1932	3.3
1263	1933	3.3
1264	1934	3.3
1265	1935	3.3
1266	1936	3.3
1267	1937	3.3
1268	1938	3.3
1269	798	5
1270	794	5
1271	1939	5
1272	1940	5
1273	1941	5
1274	1942	5
1275	789	3.3
1277	1944	3.3
1278	1945	3.3
1279	1946	3.3
1280	1947	3.3
1281	1948	3.3
1282	1949	3.3
1283	1950	3.3
1284	1951	2.8
1285	1952	2.8
1286	1953	2.8
1287	1954	2.8
1288	1955	2.8
1289	1956	2.45
1290	1957	2.8
1291	791	2.9
1292	1958	2.9
1293	1959	2.9
1294	1960	2.9
1295	1961	2.9
1296	1962	2.9
1297	790	2.9
1298	1963	2.9
1299	1964	2.7
1300	1965	2.9
1301	1966	2.9
1302	1967	2.9
1303	1969	2.9
1304	1968	2.9
1305	792	2.9
1306	1970	2.9
1307	1971	2.9
1308	1972	2.9
1309	1973	2.9
1310	1974	2
1311	1975	2.9
1312	1976	2.9
1313	1977	2.9
1314	1978	2.9
1315	1979	2.9
1316	1980	2.2
1317	1981	2.9
1318	1982	2.9
1319	1983	2.2
1320	1984	2.9
1321	1985	2.9
1322	1986	2.2
1323	1987	2.2
1324	1988	2.2
1325	1989	2.2
1326	1990	2.2
1327	1991	3.3
1328	1991	3.6
1329	1992	3.3
1330	1992	3.6
1331	1993	3.3
1332	1993	3.6
1333	1994	3.3
1334	1994	3.6
1335	1995	2.9
1336	1996	2.9
1337	1997	2.9
1338	1998	5
1339	1999	5
1340	2000	5
1341	772	5
1342	2001	5
1343	2002	5
1344	2003	5
1345	2006	5
1346	2004	5
1347	2005	5
1348	2007	5
1349	2008	5
1350	717	5
1351	819	5
1352	2009	5
1353	2010	5
1354	2011	5
1358	2016	3.3
1359	2015	3.3
1360	2017	3.3
1361	2018	3.3
1362	2019	3.3
1363	2020	2.8
1364	2021	2.8
1365	2022	2
1366	2023	2
1367	2024	3.45
1368	2024	3.6
1369	2025	3.45
1370	2025	3.6
1371	2026	3.3
1372	829	5
1373	831	5
1374	830	5
1375	827	5
1376	2027	5
1377	2028	5
1378	2029	5
1379	2030	5
1380	2031	5
1381	2032	5
1382	2033	5
1383	776	5
1384	779	5
1385	780	5
1386	2034	3.45
1387	962	3.6
1388	962	4
1389	797	3.45
1390	797	3.6
1391	797	4
1392	799	3.45
1393	799	3.6
1394	799	4
1395	800	3.45
1396	2035	3.45
1397	2036	3.3
1398	709	5
1399	720	5
1400	732	5
1401	729	5
1402	728	5
1403	725	5
1404	796	5
1405	795	5
1406	822	5
1407	821	5
1408	781	5
1409	784	5
1410	727	3.3
1411	727	3.6
1412	727	3
1413	753	3.3
1414	753	3.6
1415	753	3
1416	758	3.3
1417	758	3.6
1418	758	3
1419	2037	5
1420	2038	5
1421	2039	5
1422	2040	5
1423	2041	5
1424	2042	5
1425	2043	5
1426	2044	5
1427	2045	5
1428	2046	5
1429	2047	5
1430	2048	5
1431	2049	5
1432	2050	5
1433	2051	5
1434	2052	5
1435	2053	5
1436	1724	0.85
1437	1724	1.3625
1438	882	1.3375
1442	2055	1.3375
1441	2055	1
1440	2054	1.3375
1439	2054	1
1443	2056	1
1444	2056	1.3375
1445	2057	0.85
1446	2057	1.5
1447	2058	0.85
1448	2058	1.5
1449	2059	0.85
1450	2059	1.5
1451	2060	0.85
1452	2060	1.5
1453	883	1.3625
1454	2061	0.85
1455	2061	1.3625
1456	2062	0.85
1457	2062	1.3625
1458	2063	0.85
1459	2063	1.3625
1460	891	1.5
1461	2064	0.85
1462	2064	1.5
1463	2065	0.85
1464	2065	1.5
1465	2066	0.85
1466	2066	1.5
1467	2067	0.85
1468	2067	1.5
1469	2068	0.85
1470	2068	1.3625
1471	890	1.3625
1472	2070	0.85
1473	2070	1.3625
1474	2069	0.85
1475	2069	1.3625
1478	2072	0.85
1479	2072	1.3625
1480	2073	0.85
1481	2073	1.3625
1484	2074	0.85
1485	2074	1.3625
1486	2076	0.85
1487	2076	1.3625
1488	2077	0.85
1489	2077	1.3625
1490	2078	0.85
1491	2078	1.3625
1492	2079	0.85
1493	2079	1.3625
1496	2081	0.85
1497	2081	1.3625
1495	2080	0.85
1494	2080	1.3625
1498	2082	0.85
1499	2082	1.3625
1500	2083	0.85
1501	2083	1.3625
1502	2084	1.5
1503	2085	1.5
1504	2086	1.5
1505	2087	1.5
1506	2088	1.5
1507	2089	1.5
1508	2090	1.5
1509	2091	1.5
1510	2092	1.5
1511	2093	1.5
1512	2094	1.5
1513	2095	1.5
1514	2096	1.5
1515	2097	1.5
1516	2098	1.5
1517	2099	1.5
1518	2100	1.5
1519	2101	1.5
1520	2102	1.5
1521	2103	1.5
1522	2104	1.4
1523	2105	1.4
1524	2106	1.4
1525	2107	0.9
1526	2108	1.35
1527	2109	1.4
1528	2110	1.4
1529	2111	1.4
1530	2112	1.4
1531	2113	1.4
1532	2114	1.4
1533	2115	1.4
1534	2116	1.4
1535	2117	1.4
1536	2118	1.4
1537	2119	1.4
1538	2120	1.4
1539	2121	1.4
1540	2122	1.4
1541	2123	1.4
1542	2124	1.4
1543	2125	1.4
1544	2126	1.4
1545	2127	1.4
1546	2128	1.4
1547	2129	1.4
1548	2130	1.35
1549	2130	1.4
1550	2131	1.35
1551	2131	1.4
1552	2132	1.35
1553	2132	1.4
1554	916	1.4
1556	2134	1.35
1557	2134	1.4
1558	2133	1.4
1555	2133	1.35
1559	2135	1.35
1560	2135	1.4
1561	2136	1.35
1562	2136	1.4
1563	2137	1.35
1564	2137	1.4
1565	2138	1.35
1566	2138	1.4
1567	2139	1.35
1568	2139	1.4
1569	2140	1.35
1570	2141	1.35
1571	2142	1.35
1572	2142	1.4
1573	2143	1.35
1574	2143	1.4
1575	2144	1.35
1576	2144	1.4
1577	2145	1.35
1578	2146	1.35
1579	903	1.4
1580	2147	1.35
1581	2147	1.4
1582	2148	1.5
1583	2149	1.5
1584	905	1.35
1585	2150	1.3
1586	2150	1.35
1587	2151	1.3
1588	2151	1.35
1589	2152	1.3
1590	2152	1.35
1591	2153	1.3
1592	2153	1.35
1593	2154	1.3
1594	2154	1.35
1595	2155	1.3
1596	2155	1.35
1599	2157	1.3
1600	2157	1.35
1601	2158	1.3
1602	2158	1.35
1603	2159	1.3
1604	2159	1.35
1605	2160	1.35
1606	2160	1.4
1607	2161	1.35
1608	2161	1.4
1609	907	1.4
1612	2163	1.35
1613	2163	1.4
1614	2164	1.35
1615	2164	1.4
1616	2166	1.35
1617	2166	1.4
1618	2167	1.35
1619	2167	1.4
1620	2168	1.3
1621	2168	1.35
1622	2169	1.3
1623	2169	1.35
1624	2170	1.3
1625	2170	1.35
1626	2171	1.3
1627	2171	1.35
1628	2172	1.3
1629	2172	1.35
1630	2165	1.35
1631	2165	1.4
1634	2174	1.35
1635	2174	1.4
1636	904	1.4
1637	902	1.4
1638	2175	1.25
1639	2175	1.4
1640	2176	1.25
1641	2176	1.4
1642	2177	1.25
1643	2177	1.4
1644	2178	1.25
1645	2178	1.4
1646	2179	1.25
1647	2179	1.4
1648	2180	1.25
1649	2180	1.4
1650	2181	1.25
1651	2181	1.4
1652	2182	1.2
1653	2182	1.25
1654	2183	1.2
1655	2183	1.35
1656	2184	1.2
1657	2184	1.35
1658	2185	1.2
1659	2185	1.35
1660	2186	1.25
1661	2186	1.4
1662	2187	1.25
1663	2187	1.4
1664	2188	1.25
1665	2188	1.4
1666	2189	1.25
1667	2189	1.4
1669	2191	0.9
1670	917	1.4
1671	2194	1.25
1672	2194	1.4
1673	2195	1.25
1674	2195	1.4
1675	2196	1.25
1676	2196	1.4
1677	2197	1.25
1678	2197	1.4
1679	2198	1.25
1680	2198	1.4
1681	2199	1.25
1682	2199	1.4
1683	2200	1.2
1684	2200	1.25
1685	2201	1.2
1686	2201	1.25
1687	2202	1.2
1688	2202	1.25
1689	2203	1.2
1690	2203	1.25
1691	2204	1.2
1692	2204	1.4
1693	2205	1.2
1694	2205	1.4
1695	2206	1.2
1696	2206	1.4
1697	2207	1.2
1698	2207	1.4
1699	2208	1.2
1700	2208	1.4
1701	2212	0.825
1702	2212	1.35
1703	906	1.35
1704	909	1.35
1705	2213	0.825
1706	2213	1.35
1709	2215	0.825
1710	2215	1.35
1711	2216	0.825
1712	2216	1.35
1713	2217	0.825
1714	2217	1.35
1715	2218	0.825
1716	2218	1.35
1717	2219	0.95
1718	2219	1.4
1719	2220	0.95
1720	2220	1.4
1721	2221	0.95
1722	2221	1.4
1723	1221	1.4
358	1221	0.95
1724	952	1.4
1725	1220	1.4
1726	2222	0.975
1727	2222	1.25
1728	2223	0.975
1729	2223	1.25
1730	2224	0.95
1731	2224	1.4
1732	2225	0.95
1733	2225	1.4
1734	2226	0.95
1735	2226	1.4
1736	2227	0.95
1737	2227	1.4
1738	2228	0.95
1739	2228	1.4
1740	2229	0.975
1741	2229	1.25
1742	2230	0.975
1746	2232	0.975
1748	2233	0.95
1749	2233	1.4
1842	2298	1.2
1843	2298	1.25
1745	2231	1.25
1744	2231	0.975
1747	2232	1.25
1743	2230	1.25
1750	2234	0.95
1751	2234	1.4
1752	2235	0.95
1753	2235	1.4
1754	2236	0.95
1755	2236	1.4
1756	2237	0.95
1757	2237	1.4
1758	2238	0.95
1759	2238	1.2
1760	2239	0.95
1761	2239	1.2
1762	2240	0.95
1763	2240	1.2
1764	2241	0.95
1765	2241	1.2
1766	2242	0.95
1767	2242	1.2
1768	2243	1.35
1769	2244	1.35
1770	2245	1.35
1771	2246	1.35
1772	2247	1.35
1773	2248	1.35
1775	2250	1.35
1776	2251	1.2
1777	2252	1.2
1778	2253	1.2
1779	2254	1.2
1780	2255	1.2
1781	2256	1.2
1782	2257	1.5
1783	2258	1.5
1784	2259	1.5
1785	2260	1.5
1786	2261	1.5
1787	2262	1.4
1788	2263	1.4
1789	2264	1.4
1790	2265	1.4
1791	2266	1.2
1792	2267	1.8
1793	2268	1.2
1794	2269	1.2
1795	2270	1.2
1796	2271	1.35
1797	2272	1.35
1798	2273	1.35
1799	2274	1.35
1800	2275	1.35
1801	2276	1.35
1802	2277	1.35
1803	2278	1.35
1804	2279	1.3
1805	2279	1.35
1806	2280	1.3
1807	2280	1.35
1808	2281	1.3
1809	2281	1.35
1810	2282	1.3
1811	2282	1.35
1812	2283	1.3
1813	2283	1.35
1814	2284	1.3
1815	2284	1.35
1816	2285	1.3
1817	2285	1.35
1818	2286	1.3
1819	2286	1.35
1820	2287	1.3
1821	2287	1.35
1822	2288	1.35
1823	2288	1.4
1824	2289	1.3
1825	2289	1.35
1826	2290	1.35
1827	2290	1.4
1828	2292	1.2
1829	2292	1.25
1830	2291	1.2
1831	2291	1.25
1832	2293	1.2
1833	2293	1.25
1834	2294	1.2
1835	2294	1.25
1836	2295	1.2
1837	2295	1.25
1838	2296	1.2
1839	2296	1.25
1840	2297	1.2
1841	2297	1.25
1844	2299	1.2
1845	2299	1.25
1846	2300	1.025
1847	2300	1.075
1848	2301	1.25
1849	2301	1.35
1850	2302	1.25
1851	2302	1.35
1852	2303	1.25
1853	2303	1.35
1854	2304	1.25
1855	2304	1.35
1856	2305	1.325
1857	2305	1.375
1858	2306	1.325
1859	2306	1.375
1860	2307	1.325
1861	2307	1.375
1862	2308	1.25
1863	2308	1.35
1864	2309	1.325
1865	2309	1.375
1866	2310	1.325
1867	2310	1.375
1868	2311	1.325
1869	2311	1.375
1870	2312	1.325
1871	2312	1.375
1874	2315	1.1
1875	2315	1.4
1877	2317	1.25
1878	2318	1.25
1879	2319	1.25
1880	2320	1.25
1881	2321	1.15
1882	2321	1.25
1883	2322	1.15
1884	2322	1.25
1885	2323	1.15
1886	2323	1.25
1887	2324	1.15
1888	2324	1.25
1889	2325	1.15
1890	2325	1.25
1891	2326	1.15
1892	2326	1.25
1893	2327	1.1
1894	2327	1.35
1895	2328	1.325
1896	2328	1.375
1897	2329	1.325
1898	2329	1.375
1899	2330	1.3
1900	2330	1.35
1901	2331	1.1
1902	2331	1.35
1903	960	1.388
1904	2332	0.956
1905	2332	1.388
1906	2333	0.956
1908	2334	0.956
1910	2335	0.956
1912	2336	0.956
1914	2337	0.956
1915	2337	1.484
1907	2333	1.484
1909	2334	1.484
1911	2335	1.484
1913	2336	1.484
1916	961	1.34
1917	2338	0.988
1918	2338	1.34
1919	2339	0.988
1920	2339	1.34
1921	2340	0.988
1922	2340	1.34
1923	2341	0.988
1924	2341	1.34
1925	2342	5
1926	2343	5
1927	2344	5
1928	2345	5
1929	2346	5
1930	2347	5
1931	2348	5
1932	2349	5
1934	1544	1.525
1933	1544	1.475
1935	1525	1.525
1936	1525	1.475
1938	921	1.2
45	876	1.2
1937	876	1.3375
1939	59	0.988
1940	59	1.34
1941	60	0.988
1942	60	1.34
1948	62	2.7
1945	62	2.45
1949	64	2.7
1947	64	2.45
1950	63	2.7
1946	63	2.45
1951	65	2.45
1952	65	2.7
1953	67	2.45
1954	67	2.7
1955	66	2.45
1956	66	2.7
1957	68	2.45
1958	68	2.7
1959	69	2.45
1960	69	2.7
1961	71	1.6
1962	72	1.6
1963	73	1.8
1964	74	1.8
1965	75	1.8
1966	77	2
1967	78	2
1968	79	2.2
1969	80	2.2
1970	76	1.8
1971	81	2.9
1972	82	2.9
1973	83	2.9
1974	84	2.9
1975	85	2.5
1976	86	2.5
1977	87	2.2
1978	88	2.2
1979	89	2.2
1980	90	2.2
1981	91	2.2
1982	92	2.2
1983	95	2.9
1984	96	2.9
1985	97	2.9
1986	98	2.9
1987	99	2.9
1988	100	2.9
1989	101	2.9
1990	102	2.9
1991	103	2.2
1992	104	2.9
1993	105	2.9
1994	106	2.9
1995	107	2.9
1996	108	2.9
1997	109	2.9
1998	110	2.9
1999	111	2.9
2000	112	2.9
2001	113	2.9
2002	114	2.9
2003	115	2.9
2004	116	2.9
2005	119	5
2006	120	1.75
2007	121	1.75
2008	122	1.75
2009	123	1.75
2010	124	1.75
2011	125	1.75
2012	126	1.75
2013	127	1.5
2014	129	1.5
2015	128	1.5
2016	130	1.5
2017	132	1.5
2018	131	1.5
2019	133	1.5
2020	134	1.5
2021	135	1.5
2022	136	1.5
2023	137	1.5
2024	138	1.5
2025	139	1.187
2026	139	1.274
2027	140	1.179
2028	140	1.27
2029	141	1.17
2030	141	1.265
2031	142	1.525
2032	143	1.525
2033	144	1.525
2034	145	1.525
2035	146	1.525
2036	147	1.475
2037	148	1.475
2038	149	1.475
2039	150	1.475
2040	151	1.475
2041	152	1.475
2042	153	1.475
2043	154	1.475
2044	155	1.5
2045	156	1.2875
2046	156	1.4
2047	157	1.2875
2048	157	1.4
2049	158	1.25
2050	158	1.4
2051	159	1.25
2052	159	1.4
2053	160	1.25
2054	160	1.4
2055	161	1.287
2056	161	1.4
2057	162	1.287
2058	162	1.4
2059	163	1.287
2060	163	1.4
2061	164	1.287
1944	61	0.988
2062	164	1.4
2063	165	1.287
2064	165	1.4
2065	166	1.287
2066	166	1.4
2067	167	1.287
2068	167	1.4
2069	168	1.1125
2070	168	1.2
2071	169	1.25
2072	169	1.388
2073	170	1.25
2074	170	1.388
2075	171	1.25
2076	171	1.388
2079	173	1.25
2080	173	1.388
2083	175	1.25
2085	176	1.2875
2086	176	1.3875
2084	175	1.3875
2082	174	1.3875
2081	174	1.2875
2078	172	1.3875
2077	172	1.2875
2087	177	1.25
2088	177	1.3875
2089	178	1.2875
2090	178	1.3875
2091	179	1.2875
2092	179	1.3875
2093	180	1.2875
2094	180	1.3875
2095	181	1.2125
2096	181	1.3875
2097	182	1.05
2098	182	1.2
2099	183	1.5
2100	184	1.5
2101	185	1.5
2102	186	1.2
2103	186	1.6
2104	187	1.2
2105	187	1.6
2106	188	1.2
2107	188	1.6
2108	189	1.2
2109	189	1.6
2110	190	0.9
2111	190	1.3
2112	191	1.2
2113	191	1.6
2114	192	1.2
2115	192	1.6
2116	194	1.2
2117	194	1.6
2118	197	1.2
2119	197	1.6
2120	200	1.2
2121	200	1.6
2122	201	0.8
2123	201	1.15
2124	202	0.8
2125	202	1.2
2126	203	0.8
2127	203	1.3
2128	204	0.8
2129	204	1.2
2130	205	0.8
2131	205	1.2
2132	206	0.8
2133	206	1.2
2134	207	0.8
2135	207	1.2
2136	208	0.8
2137	208	1.4
2138	209	0.8
2139	209	1.35
2140	210	0.8
2141	210	1.3
2142	211	0.8
2143	211	1.25
2144	212	0.8
2145	212	1.25
2146	213	0.8
2147	213	1.25
2148	214	0.8
2149	214	1.3
2150	215	0.8
2151	215	1.35
2152	216	0.8
2153	216	1.4
2154	735	5
2156	429	1.34
2158	430	1.34
2161	432	0.988
2162	432	1.34
2159	431	0.988
2155	429	0.988
2157	430	0.988
1943	61	1.34
2163	433	0.988
2165	434	0.988
2167	435	0.988
2169	436	0.988
2170	436	1.372
2168	435	1.356
2166	434	1.356
2160	431	1.356
2164	433	1.356
2171	437	0.988
2172	437	1.404
2173	438	0.988
2174	438	1.356
2175	439	0.988
2176	439	1.356
53	884	1.356
2177	440	1.356
2178	441	1.356
2179	442	1.356
2180	885	1.292
2181	446	1.004
2182	446	1.292
2183	447	1.004
2184	447	1.292
2185	448	1.004
2186	448	1.292
2187	449	1.004
2188	449	1.292
2189	450	1.004
2190	450	1.292
2191	451	1.004
2192	451	1.292
2193	453	5
2194	454	5
2195	455	5
2196	456	5
2197	457	5
2198	458	5
2199	459	5
2200	460	5
2201	461	5
\.


--
-- Data for Name: psuconnector; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.psuconnector (id, name) FROM stdin;
1	AT-Style (P8-P9)
2	ATX 1.x (20-pin ATX)
6	DELL (20-pin)
7	DELL (24-pin)
8	Compaq (24-pin)
3	12V P4 Connector (4-pin P4)
4	ATX 2.x (24-pin ATX)
10	12V EPS Connector (8-pin EPS)
5	AMD GES Main Connector (24-pin GES)
11	AMD GES Aux Connector (8-pin GES)
15	Molex (4-pin)
16	DC Jack (12V)
17	DC Jack (15V)
18	DC Jack (16V)
19	DC Jack (19V)
20	DC Jack (20V)
21	DC Jack (24V)
22	PCIe (6-pin)
23	PCIe (8-pin)
24	Floppy (4-pin)
25	3.3V AUX (6-pin)
26	3.3/5V AUX (6-pin)
27	SATA (15-pin)
9	Unknown
28	OEM/Proprietary
12	Power Mac G3 (B&W, 20-pin) & G4 (PCI/AGP, 20-pin)
13	Power Mac G4 (GB/DA/QS, 22-pin)
14	Power Mac G4 (MDD, 24-pin)
\.

--
-- Data for Name: video_chipset; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.video_chipset (id, manufacturer_id, name, chip_name) FROM stdin;
1	59	\N	\N
2	67	\N	\N
3	69	\N	\N
4	74	\N	\N
5	118	\N	\N
6	119	\N	\N
7	121	\N	\N
8	207	\N	\N
9	281	\N	\N
10	303	\N	\N
11	305	\N	\N
12	344	\N	\N
13	379	\N	\N
14	405	\N	\N
15	406	\N	\N
16	426	\N	\N
17	119	\N	GD5420
18	454	RT3105	\N
20	59	3D Rage Pro Turbo	\N
24	119	\N	GD5436
25	119	\N	GD5428
26	207	810	i752
27	207	740	i740
28	207	815	i752
29	471	Riva 128/128ZX	NV3
30	471	Riva TNT	NV4
32	59	3D Rage	\N
33	59	3D Rage Pro	\N
34	472	Voodoo 3 2000	Avenger
38	344	Trio64V+	86C765
21	344	Trio64	86C764X
39	344	Trio64V2/DX	86C775
40	344	Trio64V2/GX	86C785
41	344	ViRGE	86C325
42	344	ViRGE/DX	86C375
22	344	Trio32	86C732
31	59	3D Rage II/II+	264GT
45	119	Laguna3D PCI	GD5464
46	119	Laguna3D AGP	GD5465
47	344	ViRGE/GX	86C385
48	207	Extreme Graphics	i830/i845
49	207	Extreme Graphics 2	i852/i855/i865
50	379	6326	\N
52	379	540	SiS 300
53	59	3D Rage IIc	\N
54	471	Aladdin TNT2	NV5
55	471	Riva TNT2	NV5
56	471	Riva TNT2 M64	NV5
57	281	G200	MGA-G200
58	281	G200A	MGA-G200A
59	281	G250	MGA-G200A
60	281	G100	MGA-G100A
61	281	Millennium II	MGA-2164W
62	281	Mystique 220	MGA-1164SG
63	281	Mystique	MGA-1064SG
64	281	Millennium	MGA-2064W
65	118	65554	B65554
66	118	65550	F65550
67	118	65548	F65548
68	118	65545	F65545
69	118	65535	F65535
70	118	64300	F64300
71	118	65530	F65530
72	119	\N	GD5480
43	119	\N	GD5434
73	119	\N	GD5446
74	119	\N	GD7548
75	119	\N	GD7543
76	119	\N	GD54M40
77	119	\N	GD5440
78	119	\N	GD54M30
79	119	\N	GD5430
80	119	\N	GD5429
81	119	\N	GD6440
82	119	\N	GD6235
83	119	\N	GD5426
84	119	\N	GD5424
85	119	\N	GD5422
19	344	Vision864	86C864
51	379	530/620	SiS 6326
86	379	5598	SiS 6326
87	379	630/730	SiS 300
88	379	Real256/Real256E/Mirage	SiS 315
89	379	Mirage 2	\N
90	379	Mirage 3	SiS 351
91	344	Savage3D	86C390
92	344	Savage3D	86C391
93	344	ViRGE/GX2	86C357
94	344	Trio3D	86C365
95	344	Trio3D/2X	86C362
96	344	Trio3D/2X	86C368
97	344	Savage4 LT	86C394
98	344	Savage4 GT	86C395
99	344	Savage4 Pro	86C397
100	344	Savage/MX	86C290
101	344	Savage/IX	86C298
102	344	Savage 2000	86C410
105	417	UniChrome/UniChrome Pro	\N
106	379	Xabre 200	\N
107	379	Xabre 400	\N
111	471	GeForce2 MX IGP	NV1A
112	471	GeForce4 MX IGP	NV1F
113	59	Rage XL	\N
114	59	Mobility Rage-M	M
115	486	LynxEM+	SM712
116	486	Lynx3DM+	SM722
117	25	Aladdin 7 ArtX	M1561
118	405	Blade 3D	9880
120	59	Rage LT Pro	\N
121	379	5596	5596
122	379	6205	SiS 6205
119	379	6215	SiS 6215
23	379	\N	tbd
124	344	\N	86C805-P
125	344	\N	86C805
126	344	\N	86C805i
127	344	\N	86C801
128	344	\N	86C801-R
129	344	\N	86C928
130	344	\N	86C924
131	344	\N	86C911A
132	344	\N	86C911
133	344	\N	86C805-Q
134	344	Vision868	86C868-P
135	344	Vision964	86C964-P
136	344	Vision968	86C968-P
137	59	mach32	\N
138	59	mach64 CX	\N
139	59	mach64 GX	\N
44	59	mach64 CT	264CT
37	59	mach64 VT	264VT
36	59	mach64 VT2	264VT2
35	59	mach64 VT4	264VT4
140	472	Voodoo 3 3000	Avenger
141	472	Voodoo 3 3500	Avenger
142	472	Voodoo 3 1000	Avenger
143	472	Voodoo 2	SSTV2
144	472	Voodoo Banshee	Banshee
145	472	Velocity 100	Avenger
146	472	Velocity 200	Avenger
147	472	Voodoo 5 5500	VSA-100
148	472	Voodoo 5 5000	VSA-100
149	472	Voodoo 5 6000	VSA-100
150	472	Voodoo 5 4500	VSA-100
151	472	Voodoo Rush	\N
152	472	Voodoo 1	SST1
153	480	ProMotion aT25	\N
154	480	ProMotion aT3D	\N
155	480	ProMotion aT24	\N
109	480	ProMotion 6422	\N
156	480	ProMotion 6410	\N
157	480	ProMotion 3210	\N
110	405	Blade 3D	PLE133/PLE133T/KLE133
108	479	\N	PVGA2A
158	74	\N	ALG2032+
159	74	ALG2302.A	\N
103	344	ProSavage	86C370/86C377
160	74	\N	ALG2301.B
161	74	\N	ALG2301.A
162	74	\N	ALG2228.A
163	74	\N	ALG2228
164	74	\N	ALG2101
165	406	\N	ET6000
166	406	\N	ET4000/W32i
123	406	\N	ET4000/W32p
167	406	\N	ET4000/W32
168	406	\N	ET4000AX
169	406	\N	ET3000AX
170	406	\N	ET2000
171	406	\N	ET1000-A
172	426	\N	WD9710-MZ
173	426	\N	WD90C24A2-ZZ
174	426	\N	WD90C24A-ZZ
175	426	\N	WD90C33-ZZ
176	426	\N	WD90C31A-ZS
177	426	\N	WD90C31A-LR
178	426	\N	WD90C31-LR
179	426	\N	WD90C30-LR
180	426	\N	WD90C11A-LR
181	426	\N	WD90C11-LR
182	426	\N	WD90C00-JK
183	426	\N	WD90C90-JK
184	479	Verticom HX16/AT	\N
185	479	\N	PVGA1A
186	479	\N	PEGA2A
187	479	\N	PEGA1A
188	446	Power 9100	\N
189	446	Power 9000	\N
190	446	\N	W5186
191	281	G400	MGA-G400
192	281	G400 MAX	MGA-G400A-E
193	281	G450	MGA-G450
194	281	G550	MGA-G550
195	7	\N	M3125
196	7	\N	M3127
197	100	QVision 1024	128084-004
198	100	Advanced VGA	125561-001
199	100	\N	114277-002
200	495	Quadro64	ARK2000MI+
201	495	\N	ARK2000MT
202	495	\N	ARK2000PV
203	495	\N	ARK1000PV
204	495	\N	ARK1000VL
205	496	MagicMedia256ZX	NM2360
206	496	MagicMedia256AV	NM2200
207	496	MagicGraph128ZV+	NM2097
208	496	MagicGraph128XD	NM2160
209	289	SV9000	TVGA9000B
210	289	\N	V26808B4115
211	289	\N	μPD65042GD
212	289	\N	μPD7220A
214	497	Xtec	AGX016
215	497	\N	AGX015
216	497	\N	AGX014
213	497	\N	AGX010
217	305	\N	OTI-64111
218	305	\N	OTI-087X
219	305	\N	OTI-087
220	305	\N	OTI-077
221	305	\N	OTI-067
222	305	\N	OTI-037C
223	471	Riva TNT2 Pro	NV5
224	471	Riva TNT2 Ultra	NV5
225	471	Vanta	NV5
226	471	Vanta LT	NV5
227	471	GeForce 256	NV10
228	471	GeForce2 GTS	NV15
229	471	GeForce2 Pro	NV15
230	471	GeForce2 Ti	NV15
231	471	GeForce2 MX	NV11
232	471	GeForce2 MX/200	NV11
233	471	GeForce2 MX/400	NV11
234	471	GeForce2 Ultra	NV16
235	59	Rage 128 VR	\N
236	59	Rage 128 GL	\N
237	59	Rage 128 Pro	\N
238	59	Rage 128 Ultra	\N
239	59	Rage Fury MAXX	\N
240	59	mach8	\N
241	59	Wonder VGA	\N
242	59	Wonder EGA	\N
243	59	Wonder MDA	\N
244	59	Wonder CGA	\N
245	59	Radeon VE/7000	RV100
246	59	Radeon LE/7100	Rage6/R100
247	59	Radeon SDR/7200	Rage6/R100
248	59	Radeon DDR/7200	Rage6/R100
249	59	Radeon DDR/7500 VIVO	Rage6/R100
250	59	Radeon 7500 LE	RV200
251	59	Radeon 7500	RV200
252	498	Vérité V2200	\N
253	498	Vérité V2100	\N
254	498	Vérité V1000	\N
255	454	\N	RTG3105iEH
256	454	\N	RTG3105iE
257	454	\N	RTG3105i
258	454	\N	RTG3105E
259	454	\N	RTG3105
260	454	\N	RTG3106
261	454	\N	RTG31030
262	454	\N	RTG3103
263	454	\N	RTG3102
264	454	\N	RTG3101
265	405	\N	TVGA8800BR
266	405	\N	TVGA8800CS
267	405	\N	TVGA8900B
268	405	\N	TVGA8900C
269	405	\N	TVGA9000A
270	405	\N	TVGA8900CL
271	405	\N	TVGA8900D
272	405	\N	TVGA9000B
273	405	\N	TVGA9000C
274	405	\N	TVGA9000i
276	405	\N	TVGA9000i-1
277	405	\N	TVGA9000i-2
278	405	\N	TVGA9100B
275	405	\N	TVGA8900D-R
279	405	\N	TVGA9000i-3
280	405	\N	TVGA9200CXr
281	405	\N	TGUI9400CXi
282	405	\N	TGUI9420DGi
283	405	\N	TGUI9440AGi
284	405	\N	TGUI9440
285	405	\N	TGUI9440-1
286	405	\N	TGUI9440-2
287	405	\N	TGUI9440-3
288	405	\N	TVGA9380
289	405	\N	TVGA9385
290	405	\N	TVGA9388
291	405	\N	TGUI9460
292	405	\N	TGUI9470
293	405	\N	TGUI9660
294	405	\N	TGUI9660XGi
295	405	\N	TGUI9680
296	405	\N	TGUI9680-1
297	405	\N	TGUI9680XGi
298	405	\N	Cyber9320
299	405	\N	ProVidia 9682
300	405	\N	ProVidia 9683
301	405	\N	ProVidia 9685
302	405	\N	3DImàge 9750
303	405	\N	3DImàge 9850
304	405	Blade 3D Turbo	9880T
305	405	CyberBlade XP	9900
306	405	Blade T16	9960
307	405	Blade XP	9980
308	405	Blade T64	9970
309	405	\N	Cyber9382
310	405	\N	Cyber9385
311	405	\N	Cyber9388A-1
312	405	\N	Cyber9397
313	405	\N	Cyber9397DVD
314	405	\N	Cyber9525DVD
315	405	\N	Cyber9525DVD
316	405	\N	CyberBlade Ai1
317	405	\N	CyberBlade e4-128
318	405	\N	CyberBlade i1
319	405	CyberBlade i7	\N
321	25	CyberALADDiN-T	M1644T
320	25	CyberALADDiN-P4	CyberBlade XP2/M1672
322	207	752	i752
323	59	Radeon IGP 320	RS200
324	59	Radeon IGP 330	RS200
325	59	Radeon IGP 340	RS200
326	59	Radeon IGP 320M	RS200
327	59	Radeon IGP 340M	RS200
328	59	Radeon IGP 345M	RS200
329	59	Radeon IGP 350M	RS200
330	59	Radeon 8500	R200
331	59	Radeon 8500 LE/9100	R200
332	59	Radeon 9000	RV250
333	59	Radeon 9000 Pro	RV250
334	59	Radeon 9200	RV280
335	59	Radeon 9200 SE	RV250
336	59	Radeon 9250	RV280
337	59	Radeon 9250 SE	RV280
339	59	Radeon 9100 IGP	RS300
338	59	Radeon 9000 IGP	RC350
340	59	Radeon 9100 Pro IGP	RS350
341	59	Radeon 9500	R300
342	59	Radeon 9500 Pro	R300
343	59	Radeon 9700	R300
344	59	Radeon 9700 Pro	R300
345	59	Radeon 9550	RV350
346	59	Radeon 9550 SE	RV350
347	59	Radeon 9600	RV350
348	59	Radeon 9600 SE	RV350
349	59	Radeon 9600 Pro	RV350
350	59	Radeon 9600 XT	RV360
351	59	Radeon 9600 TX	R300
352	59	Radeon 9700 TX	R300
353	59	Radeon 9800	R350
354	59	Radeon 9800 Pro	R350
355	59	Radeon 9800 SE	R350
356	59	Radeon 9800 XL	R350
357	59	Radeon 9800 Pro	R360
358	59	Radeon 9800 XXL	R360
359	59	Radeon 9800 XT	R360
360	59	Radeon X1050	RV350
361	59	Radeon X300	RV370
362	59	Radeon X300 LE	RV370
363	59	Radeon X300 SE	RV370
364	59	Radeon X300 SE HyperMemory	RV370
365	59	Radeon X550	RV370
366	59	Radeon X550 HyperMemory	RV370
367	59	Radeon X600	RV370
368	59	Radeon X600 SE	RV370
370	59	Radeon X1050	RV370
372	59	Radeon X600 XT	RV380
373	59	Radeon X700	RV410
374	59	Radeon X700 Pro	RV410
375	59	Radeon X700 SE	RV410
376	59	Radeon X700 LE	RV410
377	59	Radeon X740 XL	RV410
378	59	Radeon X800 GT	R420/R423/R480
379	59	Radeon X800	R430
380	59	Radeon X800 XL	R430
381	59	Radeon X800 SE	R420/R423/R480
382	59	Radeon X800 GTO	R420/R423/R430/R480
383	59	Radeon X800 Pro	R420/R423
384	59	Radeon X800 XT	R420/R423
385	59	Radeon X800 XT PE	R420/R423
386	59	Radeon X850 Pro	R480/R481
387	59	Radeon X850 XT	R480/R481
371	59	Radeon X850 XT PE	R480/R481
369	59	Radeon X600 Pro	RV370/RV380
388	471	GeForce3	NV20
389	471	GeForce3 Ti200	NV20
390	471	GeForce3 Ti500	NV20
391	471	GeForce4 MX420	NV17
392	471	GeForce4 MX440 SE	NV17
393	471	GeForce4 MX440-8x SE	NV18
394	471	GeForce4 MX4000	NV18
395	471	GeForce4 MX440	NV17
396	471	GeForce4 MX460	NV17
397	471	GeForce4 MX440-8x	NV18
399	471	GeForce4 Ti4200	NV25
400	471	GeForce4 Ti4200-8x	NV28
401	471	GeForce4 Ti4400	NV25
402	471	GeForce4 Ti4600	NV25
403	471	GeForce4 Ti4400-8x/4800 SE	NV28
404	471	GeForce4 Ti4600-8x/4800	NV28
405	471	GeForce FX 5100	NV34
406	471	GeForce FX 5200	NV34
407	471	GeForce FX 5200 Ultra	NV34
408	471	GeForce FX 5500	NV34
409	471	GeForce PCX 5300	NV34
398	471	GeForce PCX 4300	NV18
410	471	GeForce FX 5600	NV31
411	471	GeForce FX 5600 XT	NV31
412	471	GeForce FX 5600 Ultra	NV31
413	471	GeForce FX 5600 Ultra V2	NV31
414	471	GeForce FX 5700	NV36
415	471	GeForce FX 5700 VE	NV36
416	471	GeForce FX 5700 LE	NV36
417	471	GeForce FX 5700 Ultra	NV36
418	471	GeForce FX 5700 Ultra GDDR3	NV36
419	471	GeForce PCX 5750	NV36
420	471	GeForce FX 5800	NV30
421	471	GeForce FX 5800 Ultra	NV30
422	471	GeForce FX 5900	NV35
423	471	GeForce FX 5900 ZT	NV35
424	471	GeForce FX 5900 XT	NV35
425	471	GeForce FX 5900 Ultra	NV35
426	471	GeForce PCX 5900	NV35
427	471	GeForce FX 5950 Ultra	NV38
428	471	GeForce PCX 5950	NV38
429	471	GeForce 6200	NV43
430	471	GeForce 6200	NV44
431	471	GeForce 6200 LE	NV44
432	471	GeForce 6200 TurboCache	NV44
433	471	GeForce 6500	NV44
434	471	GeForce 6600	NV43
435	471	GeForce 6600 GT	NV43
436	471	GeForce 6600 LE	NV43
437	471	GeForce 6800	NV40/NV41/NV42
438	471	GeForce 6800 Ultra	NV40/NV45
439	471	GeForce 6800 Ultra Extreme	NV40
440	471	GeForce 6800 GT	NV40/NV45
441	471	GeForce 6800 GS	NV40/NV42
442	471	GeForce 6800 GTO	NV45
443	471	GeForce 6800 XT	NV40/NV41/NV42
444	471	GeForce 6800 LE	NV40/NV41/NV42
445	121	XpressGRAPHICS	\N
446	417	DeltaChrome	\N
447	417	Chrome 9 HC	\N
448	207	Graphics Media Accelerator 900	GMA 900
450	405	Blade3D	MVP4
451	525	\N	C3
452	119	\N	GD5325
453	479	PVC4	38307C
454	59	Mach64	215CT22200
455	118	SVGA	82C452
449	118	VGA	82C451
456	59	mach 64	88800GX
457	193	HT216	\N
458	193	\N	HT208/C
459	118	69000	B69000
460	74	\N	ALG2032
461	59	Mobility Radeon M6	\N
462	465	\N	STPC Atlas
463	523	\N	CS5530A
464	74	\N	ALI2302
465	479	\N	PVC2
466	119	\N	GD5425
467	119	\N	GD5402
468	67	AVGA2	\N
478	207	Graphics Media Accelerator X4500HD	GMA X4500HD
479	207	Graphics Media Accelerator X4500MHD	GMA X4500MHD
470	207	Graphics Media Accelerator 3000	GMA 3000
471	207	Graphics Media Accelerator 3100	GMA 3100
472	207	Graphics Media Accelerator 3150	GMA 3150
476	207	Graphics Media Accelerator 4500	GMA 4500
469	207	Graphics Media Accelerator 950	GMA 950
473	207	Graphics Media Accelerator X3000	GMA X3000
474	207	Graphics Media Accelerator X3100	GMA X3100
475	207	Graphics Media Accelerator X3500	GMA X3500
477	207	Graphics Media Accelerator X4500	GMA X4500
480	207	Graphics Media Accelerator X4700MHD	GMA X4700MHD
481	471	GeForce 6100	MCP51/MCP61
482	471	GeForce 6150	MCP51/MCP61
483	471	GeForce 6150 SE	MCP51/MCP61
484	69	\N	V5000
104	344	ProSavage8	86C420
485	344	Twister	86C380
486	344	Twister-T	86C381
487	344	Twister-K	86C387
488	405	\N	TGUI9680
489	197	\N	XGA-2
490	1029	MPact 2	LGMP5600
491	1031	\N	TP6508IQ
\.


--
-- Name: audio_chipset_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.audio_chipset_id_seq', 212, true);


--
-- Name: cache_method_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cache_method_id_seq', 1, false);


--
-- Name: cache_ratio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cache_ratio_id_seq', 1, false);


--
-- Name: cache_size_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cache_size_id_seq', 17, true);


--
-- Name: chip_alias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chip_alias_id_seq', 117, true);


--
-- Name: chip_documentation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chip_documentation_id_seq', 10, true);


--
-- Name: chip_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chip_id_seq', 496, true);


--
-- Name: chip_image_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chip_image_id_seq', 146, true);


--
-- Name: chipset_bios_code_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chipset_bios_code_id_seq', 365, true);


--
-- Name: chipset_documentation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chipset_documentation_id_seq', 8, true);


--
-- Name: chipset_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.chipset_id_seq', 1380, true);


--
-- Name: cpu_socket_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cpu_socket_id_seq', 59, true);


--
-- Name: cpu_speed_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cpu_speed_id_seq', 171, true);


--
-- Name: creditor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.creditor_id_seq', 354, true);


--
-- Name: dram_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dram_type_id_seq', 14, true);


--
-- Name: dump_quality_flag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dump_quality_flag_id_seq', 1, false);


--
-- Name: expansion_connector_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.expansion_connector_id_seq', 1, false);


--
-- Name: expansion_slot_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.expansion_slot_id_seq', 51, true);


--
-- Name: form_factor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.form_factor_id_seq', 20, true);


--
-- Name: id_redirection_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.id_redirection_id_seq', 5645, true);


--
-- Name: instruction_set_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.instruction_set_id_seq', 1, false);


--
-- Name: io_port_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.io_port_id_seq', 37, true);


--
-- Name: known_issue_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.known_issue_id_seq', 20, true);


--
-- Name: language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.language_id_seq', 191, false);


--
-- Name: large_file_chipset_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.large_file_chipset_id_seq', 1215, true);


--
-- Name: large_file_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.large_file_id_seq', 75, true);


--
-- Name: large_file_media_type_flag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.large_file_media_type_flag_id_seq', 70, true);


--
-- Name: large_file_motherboard_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.large_file_motherboard_id_seq', 85, true);


--
-- Name: large_file_os_flag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.large_file_os_flag_id_seq', 387, true);


--
-- Name: license_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.license_id_seq', 1, false);


--
-- Name: manual_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.manual_id_seq', 11986, true);


--
-- Name: manufacturer_bios_manufacturer_code_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.manufacturer_bios_manufacturer_code_id_seq', 790, true);


--
-- Name: manufacturer_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.manufacturer_id_seq', 1033, true);


--
-- Name: max_ram_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.max_ram_id_seq', 75, true);


--
-- Name: media_type_flag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.media_type_flag_id_seq', 12, true);


--
-- Name: motherboard_alias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motherboard_alias_id_seq', 3512, true);


--
-- Name: motherboard_bios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motherboard_bios_id_seq', 19730, true);


--
-- Name: motherboard_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motherboard_id_seq', 10512, true);


--
-- Name: motherboard_image_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motherboard_image_id_seq', 14579, true);


--
-- Name: motherboard_image_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.motherboard_image_type_id_seq', 5, false);


--
-- Name: os_family_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.os_family_id_seq', 1, true);


--
-- Name: os_flag_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.os_flag_id_seq', 100, true);


--
-- Name: processor_platform_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.processor_platform_type_id_seq', 97, true);


--
-- Name: processor_voltage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.processor_voltage_id_seq', 2201, true);


--
-- Name: psuconnector_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.psuconnector_id_seq', 28, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_id_seq', 13, true);


--
-- Name: video_chipset_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.video_chipset_id_seq', 491, true);


--
-- Name: audio_chipset audio_chipset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio_chipset
    ADD CONSTRAINT audio_chipset_pkey PRIMARY KEY (id);


--
-- Name: cache_method cache_method_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_method
    ADD CONSTRAINT cache_method_pkey PRIMARY KEY (id);


--
-- Name: cache_ratio cache_ratio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_ratio
    ADD CONSTRAINT cache_ratio_pkey PRIMARY KEY (id);


--
-- Name: cache_size cache_size_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_size
    ADD CONSTRAINT cache_size_pkey PRIMARY KEY (id);


--
-- Name: chip_alias chip_alias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_alias
    ADD CONSTRAINT chip_alias_pkey PRIMARY KEY (id);


--
-- Name: chip_documentation chip_documentation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_documentation
    ADD CONSTRAINT chip_documentation_pkey PRIMARY KEY (id);


--
-- Name: chip_image chip_image_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_image
    ADD CONSTRAINT chip_image_pkey PRIMARY KEY (id);


--
-- Name: chip chip_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip
    ADD CONSTRAINT chip_pkey PRIMARY KEY (id);


--
-- Name: chipset_bios_code chipset_bios_code_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_bios_code
    ADD CONSTRAINT chipset_bios_code_pkey PRIMARY KEY (id);


--
-- Name: chipset_chipset_part chipset_chipset_part_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_chipset_part
    ADD CONSTRAINT chipset_chipset_part_pkey PRIMARY KEY (chipset_id, chipset_part_id);


--
-- Name: chipset_documentation chipset_documentation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_documentation
    ADD CONSTRAINT chipset_documentation_pkey PRIMARY KEY (id);


--
-- Name: chipset_part chipset_part_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_part
    ADD CONSTRAINT chipset_part_pkey PRIMARY KEY (id);


--
-- Name: chipset chipset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset
    ADD CONSTRAINT chipset_pkey PRIMARY KEY (id);


--
-- Name: coprocessor coprocessor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coprocessor
    ADD CONSTRAINT coprocessor_pkey PRIMARY KEY (id);


--
-- Name: cpu_socket cpu_socket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cpu_socket
    ADD CONSTRAINT cpu_socket_pkey PRIMARY KEY (id);


--
-- Name: cpu_socket_processor_platform_type cpu_socket_processor_platform_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cpu_socket_processor_platform_type
    ADD CONSTRAINT cpu_socket_processor_platform_type_pkey PRIMARY KEY (cpu_socket_id, processor_platform_type_id);


--
-- Name: cpu_speed cpu_speed_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cpu_speed
    ADD CONSTRAINT cpu_speed_pkey PRIMARY KEY (id);


--
-- Name: creditor creditor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.creditor
    ADD CONSTRAINT creditor_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: dram_type dram_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dram_type
    ADD CONSTRAINT dram_type_pkey PRIMARY KEY (id);


--
-- Name: dump_quality_flag dump_quality_flag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dump_quality_flag
    ADD CONSTRAINT dump_quality_flag_pkey PRIMARY KEY (id);


--
-- Name: expansion_connector expansion_connector_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expansion_connector
    ADD CONSTRAINT expansion_connector_pkey PRIMARY KEY (id);


--
-- Name: expansion_slot expansion_slot_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.expansion_slot
    ADD CONSTRAINT expansion_slot_pkey PRIMARY KEY (id);


--
-- Name: form_factor form_factor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.form_factor
    ADD CONSTRAINT form_factor_pkey PRIMARY KEY (id);


--
-- Name: id_redirection id_redirection_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.id_redirection
    ADD CONSTRAINT id_redirection_pkey PRIMARY KEY (id);


--
-- Name: instruction_set_instruction_set instruction_set_instruction_set_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instruction_set_instruction_set
    ADD CONSTRAINT instruction_set_instruction_set_pkey PRIMARY KEY (instruction_set_source, instruction_set_target);


--
-- Name: instruction_set instruction_set_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instruction_set
    ADD CONSTRAINT instruction_set_pkey PRIMARY KEY (id);


--
-- Name: io_port io_port_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.io_port
    ADD CONSTRAINT io_port_pkey PRIMARY KEY (id);


--
-- Name: known_issue known_issue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.known_issue
    ADD CONSTRAINT known_issue_pkey PRIMARY KEY (id);


--
-- Name: language language_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.language
    ADD CONSTRAINT language_pkey PRIMARY KEY (id);


--
-- Name: large_file_chipset large_file_chipset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_chipset
    ADD CONSTRAINT large_file_chipset_pkey PRIMARY KEY (id);


--
-- Name: large_file_language large_file_language_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_language
    ADD CONSTRAINT large_file_language_pkey PRIMARY KEY (large_file_id, language_id);


--
-- Name: large_file_media_type_flag large_file_media_type_flag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_media_type_flag
    ADD CONSTRAINT large_file_media_type_flag_pkey PRIMARY KEY (id);


--
-- Name: large_file_motherboard large_file_motherboard_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_motherboard
    ADD CONSTRAINT large_file_motherboard_pkey PRIMARY KEY (id);


--
-- Name: large_file_os_flag large_file_os_flag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_os_flag
    ADD CONSTRAINT large_file_os_flag_pkey PRIMARY KEY (id);


--
-- Name: large_file large_file_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file
    ADD CONSTRAINT large_file_pkey PRIMARY KEY (id);


--
-- Name: license license_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.license
    ADD CONSTRAINT license_pkey PRIMARY KEY (id);


--
-- Name: manual manual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manual
    ADD CONSTRAINT manual_pkey PRIMARY KEY (id);


--
-- Name: manufacturer_bios_manufacturer_code manufacturer_bios_manufacturer_code_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manufacturer_bios_manufacturer_code
    ADD CONSTRAINT manufacturer_bios_manufacturer_code_pkey PRIMARY KEY (id);


--
-- Name: manufacturer manufacturer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manufacturer
    ADD CONSTRAINT manufacturer_pkey PRIMARY KEY (id);


--
-- Name: max_ram max_ram_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.max_ram
    ADD CONSTRAINT max_ram_pkey PRIMARY KEY (id);


--
-- Name: media_type_flag media_type_flag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.media_type_flag
    ADD CONSTRAINT media_type_flag_pkey PRIMARY KEY (id);


--
-- Name: motherboard_alias motherboard_alias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_alias
    ADD CONSTRAINT motherboard_alias_pkey PRIMARY KEY (id);


--
-- Name: motherboard_bios motherboard_bios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_bios
    ADD CONSTRAINT motherboard_bios_pkey PRIMARY KEY (id);


--
-- Name: motherboard_cache_size motherboard_cache_size_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cache_size
    ADD CONSTRAINT motherboard_cache_size_pkey PRIMARY KEY (motherboard_id, cache_size_id);


--
-- Name: motherboard_coprocessor motherboard_coprocessor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_coprocessor
    ADD CONSTRAINT motherboard_coprocessor_pkey PRIMARY KEY (motherboard_id, coprocessor_id);


--
-- Name: motherboard_cpu_socket motherboard_cpu_socket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_socket
    ADD CONSTRAINT motherboard_cpu_socket_pkey PRIMARY KEY (motherboard_id, cpu_socket_id);


--
-- Name: motherboard_cpu_speed motherboard_cpu_speed_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_speed
    ADD CONSTRAINT motherboard_cpu_speed_pkey PRIMARY KEY (motherboard_id, cpu_speed_id);


--
-- Name: motherboard_dram_type motherboard_dram_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_dram_type
    ADD CONSTRAINT motherboard_dram_type_pkey PRIMARY KEY (motherboard_id, dram_type_id);


--
-- Name: motherboard_expansion_slot motherboard_expansion_slot_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_expansion_slot
    ADD CONSTRAINT motherboard_expansion_slot_pkey PRIMARY KEY (motherboard_id, expansion_slot_id);


--
-- Name: motherboard_id_redirection motherboard_id_redirection_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_id_redirection
    ADD CONSTRAINT motherboard_id_redirection_pkey PRIMARY KEY (id);


--
-- Name: motherboard_image motherboard_image_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image
    ADD CONSTRAINT motherboard_image_pkey PRIMARY KEY (id);


--
-- Name: motherboard_image_type motherboard_image_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image_type
    ADD CONSTRAINT motherboard_image_type_pkey PRIMARY KEY (id);


--
-- Name: motherboard_io_port motherboard_io_port_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_io_port
    ADD CONSTRAINT motherboard_io_port_pkey PRIMARY KEY (motherboard_id, io_port_id);


--
-- Name: motherboard_known_issue motherboard_known_issue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_known_issue
    ADD CONSTRAINT motherboard_known_issue_pkey PRIMARY KEY (motherboard_id, known_issue_id);


--
-- Name: motherboard_max_ram motherboard_max_ram_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_max_ram
    ADD CONSTRAINT motherboard_max_ram_pkey PRIMARY KEY (motherboard_id, max_ram_id);


--
-- Name: motherboard motherboard_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT motherboard_pkey PRIMARY KEY (id);


--
-- Name: motherboard_processor motherboard_processor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor
    ADD CONSTRAINT motherboard_processor_pkey PRIMARY KEY (motherboard_id, processor_id);


--
-- Name: motherboard_processor_platform_type motherboard_processor_platform_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor_platform_type
    ADD CONSTRAINT motherboard_processor_platform_type_pkey PRIMARY KEY (motherboard_id, processor_platform_type_id);


--
-- Name: motherboard_psuconnector motherboard_psuconnector_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_psuconnector
    ADD CONSTRAINT motherboard_psuconnector_pkey PRIMARY KEY (motherboard_id, psuconnector_id);


--
-- Name: os_family os_family_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_family
    ADD CONSTRAINT os_family_pkey PRIMARY KEY (id);


--
-- Name: os_flag_os_family os_flag_os_family_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_flag_os_family
    ADD CONSTRAINT os_flag_os_family_pkey PRIMARY KEY (os_flag_id, os_family_id);


--
-- Name: os_flag os_flag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_flag
    ADD CONSTRAINT os_flag_pkey PRIMARY KEY (id);


--
-- Name: processing_unit_cpu_socket processing_unit_cpu_socket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_cpu_socket
    ADD CONSTRAINT processing_unit_cpu_socket_pkey PRIMARY KEY (processing_unit_id, cpu_socket_id);


--
-- Name: processing_unit_instruction_set processing_unit_instruction_set_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_instruction_set
    ADD CONSTRAINT processing_unit_instruction_set_pkey PRIMARY KEY (processing_unit_id, instruction_set_id);


--
-- Name: processing_unit processing_unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit
    ADD CONSTRAINT processing_unit_pkey PRIMARY KEY (id);


--
-- Name: processor processor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT processor_pkey PRIMARY KEY (id);


--
-- Name: processor_platform_type processor_platform_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_platform_type
    ADD CONSTRAINT processor_platform_type_pkey PRIMARY KEY (id);


--
-- Name: processor_platform_type_processor_platform_type processor_platform_type_processor_platform_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_platform_type_processor_platform_type
    ADD CONSTRAINT processor_platform_type_processor_platform_type_pkey PRIMARY KEY (processor_platform_type_source, processor_platform_type_target);


--
-- Name: processor_voltage processor_voltage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_voltage
    ADD CONSTRAINT processor_voltage_pkey PRIMARY KEY (id);


--
-- Name: psuconnector psuconnector_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.psuconnector
    ADD CONSTRAINT psuconnector_pkey PRIMARY KEY (id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: video_chipset video_chipset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.video_chipset
    ADD CONSTRAINT video_chipset_pkey PRIMARY KEY (id);


--
-- Name: idx_10386ab129ea72e8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10386ab129ea72e8 ON public.large_file_media_type_flag USING btree (large_file_id);


--
-- Name: idx_10386ab1d04f219c; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10386ab1d04f219c ON public.large_file_media_type_flag USING btree (media_type_flag_id);


--
-- Name: idx_10dbbec46511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10dbbec46511e8a3 ON public.manual USING btree (motherboard_id);


--
-- Name: idx_10dbbec482f1baf4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10dbbec482f1baf4 ON public.manual USING btree (language_id);


--
-- Name: idx_10fb0bc882f1baf4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10fb0bc882f1baf4 ON public.chip_documentation USING btree (language_id);


--
-- Name: idx_10fb0bc8a588adb3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_10fb0bc8a588adb3 ON public.chip_documentation USING btree (chip_id);


--
-- Name: idx_1a6a4483a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1a6a4483a23b42d ON public.audio_chipset USING btree (manufacturer_id);


--
-- Name: idx_1d67f57836f0f0c7; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1d67f57836f0f0c7 ON public.chipset_chipset_part USING btree (chipset_part_id);


--
-- Name: idx_1d67f578bc1433b9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1d67f578bc1433b9 ON public.chipset_chipset_part USING btree (chipset_id);


--
-- Name: idx_1ded74e6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1ded74e6511e8a3 ON public.motherboard_max_ram USING btree (motherboard_id);


--
-- Name: idx_1ded74e9457a0e1; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1ded74e9457a0e1 ON public.motherboard_max_ram USING btree (max_ram_id);


--
-- Name: idx_1f72dc5e8f3a8393; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1f72dc5e8f3a8393 ON public.processing_unit USING btree (speed_id);


--
-- Name: idx_1f72dc5ed932f451; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1f72dc5ed932f451 ON public.processing_unit USING btree (fsb_id);


--
-- Name: idx_1f72dc5effe6496f; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_1f72dc5effe6496f ON public.processing_unit USING btree (platform_id);


--
-- Name: idx_25dd4d5fa23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_25dd4d5fa23b42d ON public.chipset USING btree (manufacturer_id);


--
-- Name: idx_27036c4d44ebdbab; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_27036c4d44ebdbab ON public.motherboard_coprocessor USING btree (coprocessor_id);


--
-- Name: idx_27036c4d6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_27036c4d6511e8a3 ON public.motherboard_coprocessor USING btree (motherboard_id);


--
-- Name: idx_27d7f081a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_27d7f081a23b42d ON public.os_flag USING btree (manufacturer_id);


--
-- Name: idx_29c046501c944943; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c046501c944943 ON public.processor USING btree (l3_cache_ratio_id);


--
-- Name: idx_29c046502d259658; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c046502d259658 ON public.processor USING btree (l1_cache_method_id);


--
-- Name: idx_29c046504b77eeb7; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c046504b77eeb7 ON public.processor USING btree (l1_id);


--
-- Name: idx_29c0465059c24159; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c0465059c24159 ON public.processor USING btree (l2_id);


--
-- Name: idx_29c04650b2fcd8d2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c04650b2fcd8d2 ON public.processor USING btree (l2_cache_ratio_id);


--
-- Name: idx_29c04650e17e263c; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_29c04650e17e263c ON public.processor USING btree (l3_id);


--
-- Name: idx_2be8fd2137bac19a; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2be8fd2137bac19a ON public.motherboard_processor USING btree (processor_id);


--
-- Name: idx_2be8fd216511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2be8fd216511e8a3 ON public.motherboard_processor USING btree (motherboard_id);


--
-- Name: idx_2cd1411c6b6a65a0; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2cd1411c6b6a65a0 ON public.cpu_socket_processor_platform_type USING btree (cpu_socket_id);


--
-- Name: idx_2cd1411ca90b5cbc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_2cd1411ca90b5cbc ON public.cpu_socket_processor_platform_type USING btree (processor_platform_type_id);


--
-- Name: idx_30ffe83e816c6140; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_30ffe83e816c6140 ON public.motherboard_id_redirection USING btree (destination_id);


--
-- Name: idx_37260f5c6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_37260f5c6511e8a3 ON public.motherboard_expansion_slot USING btree (motherboard_id);


--
-- Name: idx_37260f5c85c5d58e; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_37260f5c85c5d58e ON public.motherboard_expansion_slot USING btree (expansion_slot_id);


--
-- Name: idx_417baded6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_417baded6511e8a3 ON public.motherboard_processor_platform_type USING btree (motherboard_id);


--
-- Name: idx_417badeda90b5cbc; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_417badeda90b5cbc ON public.motherboard_processor_platform_type USING btree (processor_platform_type_id);


--
-- Name: idx_473d2a6a29ea72e8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_473d2a6a29ea72e8 ON public.large_file_language USING btree (large_file_id);


--
-- Name: idx_473d2a6a82f1baf4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_473d2a6a82f1baf4 ON public.large_file_language USING btree (language_id);


--
-- Name: idx_52daada12b9b9ee5; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_52daada12b9b9ee5 ON public.os_flag_os_family USING btree (os_family_id);


--
-- Name: idx_52daada18abd126a; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_52daada18abd126a ON public.os_flag_os_family USING btree (os_flag_id);


--
-- Name: idx_555107202a211d31; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_555107202a211d31 ON public.motherboard_io_port USING btree (io_port_id);


--
-- Name: idx_555107206511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_555107206511e8a3 ON public.motherboard_io_port USING btree (motherboard_id);


--
-- Name: idx_6263703c82f1baf4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6263703c82f1baf4 ON public.chipset_documentation USING btree (language_id);


--
-- Name: idx_6263703cbc1433b9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6263703cbc1433b9 ON public.chipset_documentation USING btree (chipset_id);


--
-- Name: idx_6781b3ac4aaf3610; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6781b3ac4aaf3610 ON public.motherboard_cache_size USING btree (cache_size_id);


--
-- Name: idx_6781b3ac6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6781b3ac6511e8a3 ON public.motherboard_cache_size USING btree (motherboard_id);


--
-- Name: idx_6a5a3b8d32096f65; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6a5a3b8d32096f65 ON public.motherboard_known_issue USING btree (known_issue_id);


--
-- Name: idx_6a5a3b8d6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6a5a3b8d6511e8a3 ON public.motherboard_known_issue USING btree (motherboard_id);


--
-- Name: idx_6da11f9fbc1433b9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6da11f9fbc1433b9 ON public.chipset_bios_code USING btree (chipset_id);


--
-- Name: idx_6da11f9fe209fba6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6da11f9fe209fba6 ON public.chipset_bios_code USING btree (bios_manufacturer_id);


--
-- Name: idx_7f7a0f2b3cb32b0f; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2b3cb32b0f ON public.motherboard USING btree (video_chipset_id);


--
-- Name: idx_7f7a0f2b900d537d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2b900d537d ON public.motherboard USING btree (max_video_ram_id);


--
-- Name: idx_7f7a0f2ba23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2ba23b42d ON public.motherboard USING btree (manufacturer_id);


--
-- Name: idx_7f7a0f2bbc1433b9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2bbc1433b9 ON public.motherboard USING btree (chipset_id);


--
-- Name: idx_7f7a0f2bbc4062b4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2bbc4062b4 ON public.motherboard USING btree (audio_chipset_id);


--
-- Name: idx_7f7a0f2bcd887eaf; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_7f7a0f2bcd887eaf ON public.motherboard USING btree (form_factor_id);


--
-- Name: idx_85a962606511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_85a962606511e8a3 ON public.motherboard_dram_type USING btree (motherboard_id);


--
-- Name: idx_85a96260b1e0c110; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_85a96260b1e0c110 ON public.motherboard_dram_type USING btree (dram_type_id);


--
-- Name: idx_8bf3b2736511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_8bf3b2736511e8a3 ON public.motherboard_cpu_socket USING btree (motherboard_id);


--
-- Name: idx_8bf3b2736b6a65a0; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_8bf3b2736b6a65a0 ON public.motherboard_cpu_socket USING btree (cpu_socket_id);


--
-- Name: idx_8c8cd216398716cd; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_8c8cd216398716cd ON public.large_file USING btree (dump_quality_flag_id);


--
-- Name: idx_992235c6a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_992235c6a23b42d ON public.manufacturer_bios_manufacturer_code USING btree (manufacturer_id);


--
-- Name: idx_992235c6e209fba6; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_992235c6e209fba6 ON public.manufacturer_bios_manufacturer_code USING btree (bios_manufacturer_id);


--
-- Name: idx_9e92b1326511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_9e92b1326511e8a3 ON public.motherboard_bios USING btree (motherboard_id);


--
-- Name: idx_9e92b132a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_9e92b132a23b42d ON public.motherboard_bios USING btree (manufacturer_id);


--
-- Name: idx_a5925a66e53a5cf8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a5925a66e53a5cf8 ON public.instruction_set_instruction_set USING btree (instruction_set_target);


--
-- Name: idx_a5925a66fcdf0c77; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a5925a66fcdf0c77 ON public.instruction_set_instruction_set USING btree (instruction_set_source);


--
-- Name: idx_a713cf6b6511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a713cf6b6511e8a3 ON public.motherboard_cpu_speed USING btree (motherboard_id);


--
-- Name: idx_a713cf6b8da8b6e5; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_a713cf6b8da8b6e5 ON public.motherboard_cpu_speed USING btree (cpu_speed_id);


--
-- Name: idx_aa29bcbba23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_aa29bcbba23b42d ON public.chip USING btree (manufacturer_id);


--
-- Name: idx_bc595800929cc919; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_bc595800929cc919 ON public.processing_unit_instruction_set USING btree (instruction_set_id);


--
-- Name: idx_bc59580093e55c96; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_bc59580093e55c96 ON public.processing_unit_instruction_set USING btree (processing_unit_id);


--
-- Name: idx_bd0db1996511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_bd0db1996511e8a3 ON public.motherboard_psuconnector USING btree (motherboard_id);


--
-- Name: idx_bd0db199d6871168; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_bd0db199d6871168 ON public.motherboard_psuconnector USING btree (psuconnector_id);


--
-- Name: idx_c030a4f2a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_c030a4f2a23b42d ON public.video_chipset USING btree (manufacturer_id);


--
-- Name: idx_c7bbb9a9a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_c7bbb9a9a23b42d ON public.chip_alias USING btree (manufacturer_id);


--
-- Name: idx_c7bbb9a9a588adb3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_c7bbb9a9a588adb3 ON public.chip_alias USING btree (chip_id);


--
-- Name: idx_c873b20c29ea72e8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_c873b20c29ea72e8 ON public.large_file_os_flag USING btree (large_file_id);


--
-- Name: idx_c873b20c8abd126a; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_c873b20c8abd126a ON public.large_file_os_flag USING btree (os_flag_id);


--
-- Name: idx_ca790fd229ea72e8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ca790fd229ea72e8 ON public.large_file_chipset USING btree (large_file_id);


--
-- Name: idx_ca790fd2bc1433b9; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ca790fd2bc1433b9 ON public.large_file_chipset USING btree (chipset_id);


--
-- Name: idx_d614e2fe37bac19a; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_d614e2fe37bac19a ON public.processor_voltage USING btree (processor_id);


--
-- Name: idx_db937a2b6b6a65a0; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_db937a2b6b6a65a0 ON public.processing_unit_cpu_socket USING btree (cpu_socket_id);


--
-- Name: idx_db937a2b93e55c96; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_db937a2b93e55c96 ON public.processing_unit_cpu_socket USING btree (processing_unit_id);


--
-- Name: idx_df408ab96511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_df408ab96511e8a3 ON public.motherboard_alias USING btree (motherboard_id);


--
-- Name: idx_df408ab9a23b42d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_df408ab9a23b42d ON public.motherboard_alias USING btree (manufacturer_id);


--
-- Name: idx_e3ead662460f904b; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e3ead662460f904b ON public.chip_image USING btree (license_id);


--
-- Name: idx_e3ead662a588adb3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e3ead662a588adb3 ON public.chip_image USING btree (chip_id);


--
-- Name: idx_e3ead662df91ac92; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e3ead662df91ac92 ON public.chip_image USING btree (creditor_id);


--
-- Name: idx_e989be6729ea72e8; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e989be6729ea72e8 ON public.large_file_motherboard USING btree (large_file_id);


--
-- Name: idx_e989be676511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e989be676511e8a3 ON public.large_file_motherboard USING btree (motherboard_id);


--
-- Name: idx_fb11e572460f904b; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fb11e572460f904b ON public.motherboard_image USING btree (license_id);


--
-- Name: idx_fb11e5726511e8a3; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fb11e5726511e8a3 ON public.motherboard_image USING btree (motherboard_id);


--
-- Name: idx_fb11e572df91ac92; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fb11e572df91ac92 ON public.motherboard_image USING btree (creditor_id);


--
-- Name: idx_fb11e572f987c2c1; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_fb11e572f987c2c1 ON public.motherboard_image USING btree (motherboard_image_type_id);


--
-- Name: idx_ffe4afe1eb5c3a2d; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ffe4afe1eb5c3a2d ON public.processor_platform_type_processor_platform_type USING btree (processor_platform_type_target);


--
-- Name: idx_ffe4afe1f2b96aa2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_ffe4afe1f2b96aa2 ON public.processor_platform_type_processor_platform_type USING btree (processor_platform_type_source);


--
-- Name: uniq_3d0ae6dc3ee4b093; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_3d0ae6dc3ee4b093 ON public.manufacturer USING btree (short_name);


--
-- Name: uniq_3d0ae6dc5e237e06; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_3d0ae6dc5e237e06 ON public.manufacturer USING btree (name);


--
-- Name: uniq_8d93d649f85e0677; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON public."user" USING btree (username);


--
-- Name: large_file_media_type_flag fk_10386ab129ea72e8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_media_type_flag
    ADD CONSTRAINT fk_10386ab129ea72e8 FOREIGN KEY (large_file_id) REFERENCES public.large_file(id);


--
-- Name: large_file_media_type_flag fk_10386ab1d04f219c; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_media_type_flag
    ADD CONSTRAINT fk_10386ab1d04f219c FOREIGN KEY (media_type_flag_id) REFERENCES public.media_type_flag(id);


--
-- Name: manual fk_10dbbec46511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manual
    ADD CONSTRAINT fk_10dbbec46511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: manual fk_10dbbec482f1baf4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manual
    ADD CONSTRAINT fk_10dbbec482f1baf4 FOREIGN KEY (language_id) REFERENCES public.language(id);


--
-- Name: chip_documentation fk_10fb0bc882f1baf4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_documentation
    ADD CONSTRAINT fk_10fb0bc882f1baf4 FOREIGN KEY (language_id) REFERENCES public.language(id);


--
-- Name: chip_documentation fk_10fb0bc8a588adb3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_documentation
    ADD CONSTRAINT fk_10fb0bc8a588adb3 FOREIGN KEY (chip_id) REFERENCES public.chip(id);


--
-- Name: audio_chipset fk_1a6a4483a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.audio_chipset
    ADD CONSTRAINT fk_1a6a4483a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: chipset_chipset_part fk_1d67f57836f0f0c7; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_chipset_part
    ADD CONSTRAINT fk_1d67f57836f0f0c7 FOREIGN KEY (chipset_part_id) REFERENCES public.chipset_part(id) ON DELETE CASCADE;


--
-- Name: chipset_chipset_part fk_1d67f578bc1433b9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_chipset_part
    ADD CONSTRAINT fk_1d67f578bc1433b9 FOREIGN KEY (chipset_id) REFERENCES public.chipset(id) ON DELETE CASCADE;


--
-- Name: motherboard_max_ram fk_1ded74e6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_max_ram
    ADD CONSTRAINT fk_1ded74e6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_max_ram fk_1ded74e9457a0e1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_max_ram
    ADD CONSTRAINT fk_1ded74e9457a0e1 FOREIGN KEY (max_ram_id) REFERENCES public.max_ram(id);


--
-- Name: processing_unit fk_1f72dc5e8f3a8393; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit
    ADD CONSTRAINT fk_1f72dc5e8f3a8393 FOREIGN KEY (speed_id) REFERENCES public.cpu_speed(id);


--
-- Name: processing_unit fk_1f72dc5ebf396750; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit
    ADD CONSTRAINT fk_1f72dc5ebf396750 FOREIGN KEY (id) REFERENCES public.chip(id) ON DELETE CASCADE;


--
-- Name: processing_unit fk_1f72dc5ed932f451; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit
    ADD CONSTRAINT fk_1f72dc5ed932f451 FOREIGN KEY (fsb_id) REFERENCES public.cpu_speed(id);


--
-- Name: processing_unit fk_1f72dc5effe6496f; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit
    ADD CONSTRAINT fk_1f72dc5effe6496f FOREIGN KEY (platform_id) REFERENCES public.processor_platform_type(id);


--
-- Name: chipset fk_25dd4d5fa23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset
    ADD CONSTRAINT fk_25dd4d5fa23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: motherboard_coprocessor fk_27036c4d44ebdbab; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_coprocessor
    ADD CONSTRAINT fk_27036c4d44ebdbab FOREIGN KEY (coprocessor_id) REFERENCES public.coprocessor(id) ON DELETE CASCADE;


--
-- Name: motherboard_coprocessor fk_27036c4d6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_coprocessor
    ADD CONSTRAINT fk_27036c4d6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: os_flag fk_27d7f081a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_flag
    ADD CONSTRAINT fk_27d7f081a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: processor fk_29c046501c944943; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c046501c944943 FOREIGN KEY (l3_cache_ratio_id) REFERENCES public.cache_ratio(id);


--
-- Name: processor fk_29c046502d259658; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c046502d259658 FOREIGN KEY (l1_cache_method_id) REFERENCES public.cache_method(id);


--
-- Name: processor fk_29c046504b77eeb7; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c046504b77eeb7 FOREIGN KEY (l1_id) REFERENCES public.cache_size(id);


--
-- Name: processor fk_29c0465059c24159; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c0465059c24159 FOREIGN KEY (l2_id) REFERENCES public.cache_size(id);


--
-- Name: processor fk_29c04650b2fcd8d2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c04650b2fcd8d2 FOREIGN KEY (l2_cache_ratio_id) REFERENCES public.cache_ratio(id);


--
-- Name: processor fk_29c04650bf396750; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c04650bf396750 FOREIGN KEY (id) REFERENCES public.chip(id) ON DELETE CASCADE;


--
-- Name: processor fk_29c04650e17e263c; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor
    ADD CONSTRAINT fk_29c04650e17e263c FOREIGN KEY (l3_id) REFERENCES public.cache_size(id);


--
-- Name: motherboard_processor fk_2be8fd2137bac19a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor
    ADD CONSTRAINT fk_2be8fd2137bac19a FOREIGN KEY (processor_id) REFERENCES public.processor(id) ON DELETE CASCADE;


--
-- Name: motherboard_processor fk_2be8fd216511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor
    ADD CONSTRAINT fk_2be8fd216511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: cpu_socket_processor_platform_type fk_2cd1411c6b6a65a0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cpu_socket_processor_platform_type
    ADD CONSTRAINT fk_2cd1411c6b6a65a0 FOREIGN KEY (cpu_socket_id) REFERENCES public.cpu_socket(id) ON DELETE CASCADE;


--
-- Name: cpu_socket_processor_platform_type fk_2cd1411ca90b5cbc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cpu_socket_processor_platform_type
    ADD CONSTRAINT fk_2cd1411ca90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES public.processor_platform_type(id) ON DELETE CASCADE;


--
-- Name: motherboard_id_redirection fk_30ffe83e816c6140; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_id_redirection
    ADD CONSTRAINT fk_30ffe83e816c6140 FOREIGN KEY (destination_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_id_redirection fk_30ffe83ebf396750; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_id_redirection
    ADD CONSTRAINT fk_30ffe83ebf396750 FOREIGN KEY (id) REFERENCES public.id_redirection(id) ON DELETE CASCADE;


--
-- Name: motherboard_expansion_slot fk_37260f5c6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_expansion_slot
    ADD CONSTRAINT fk_37260f5c6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_expansion_slot fk_37260f5c85c5d58e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_expansion_slot
    ADD CONSTRAINT fk_37260f5c85c5d58e FOREIGN KEY (expansion_slot_id) REFERENCES public.expansion_slot(id);


--
-- Name: motherboard_processor_platform_type fk_417baded6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor_platform_type
    ADD CONSTRAINT fk_417baded6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_processor_platform_type fk_417badeda90b5cbc; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_processor_platform_type
    ADD CONSTRAINT fk_417badeda90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES public.processor_platform_type(id) ON DELETE CASCADE;


--
-- Name: large_file_language fk_473d2a6a29ea72e8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_language
    ADD CONSTRAINT fk_473d2a6a29ea72e8 FOREIGN KEY (large_file_id) REFERENCES public.large_file(id) ON DELETE CASCADE;


--
-- Name: large_file_language fk_473d2a6a82f1baf4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_language
    ADD CONSTRAINT fk_473d2a6a82f1baf4 FOREIGN KEY (language_id) REFERENCES public.language(id) ON DELETE CASCADE;


--
-- Name: coprocessor fk_4d944cd6bf396750; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coprocessor
    ADD CONSTRAINT fk_4d944cd6bf396750 FOREIGN KEY (id) REFERENCES public.chip(id) ON DELETE CASCADE;


--
-- Name: os_flag_os_family fk_52daada12b9b9ee5; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_flag_os_family
    ADD CONSTRAINT fk_52daada12b9b9ee5 FOREIGN KEY (os_family_id) REFERENCES public.os_family(id) ON DELETE CASCADE;


--
-- Name: os_flag_os_family fk_52daada18abd126a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.os_flag_os_family
    ADD CONSTRAINT fk_52daada18abd126a FOREIGN KEY (os_flag_id) REFERENCES public.os_flag(id) ON DELETE CASCADE;


--
-- Name: motherboard_io_port fk_555107202a211d31; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_io_port
    ADD CONSTRAINT fk_555107202a211d31 FOREIGN KEY (io_port_id) REFERENCES public.io_port(id);


--
-- Name: motherboard_io_port fk_555107206511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_io_port
    ADD CONSTRAINT fk_555107206511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: chipset_documentation fk_6263703c82f1baf4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_documentation
    ADD CONSTRAINT fk_6263703c82f1baf4 FOREIGN KEY (language_id) REFERENCES public.language(id);


--
-- Name: chipset_documentation fk_6263703cbc1433b9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_documentation
    ADD CONSTRAINT fk_6263703cbc1433b9 FOREIGN KEY (chipset_id) REFERENCES public.chipset(id);


--
-- Name: motherboard_cache_size fk_6781b3ac4aaf3610; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cache_size
    ADD CONSTRAINT fk_6781b3ac4aaf3610 FOREIGN KEY (cache_size_id) REFERENCES public.cache_size(id) ON DELETE CASCADE;


--
-- Name: motherboard_cache_size fk_6781b3ac6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cache_size
    ADD CONSTRAINT fk_6781b3ac6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_known_issue fk_6a5a3b8d32096f65; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_known_issue
    ADD CONSTRAINT fk_6a5a3b8d32096f65 FOREIGN KEY (known_issue_id) REFERENCES public.known_issue(id) ON DELETE CASCADE;


--
-- Name: motherboard_known_issue fk_6a5a3b8d6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_known_issue
    ADD CONSTRAINT fk_6a5a3b8d6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: chipset_bios_code fk_6da11f9fbc1433b9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_bios_code
    ADD CONSTRAINT fk_6da11f9fbc1433b9 FOREIGN KEY (chipset_id) REFERENCES public.chipset(id);


--
-- Name: chipset_bios_code fk_6da11f9fe209fba6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_bios_code
    ADD CONSTRAINT fk_6da11f9fe209fba6 FOREIGN KEY (bios_manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: motherboard fk_7f7a0f2b3cb32b0f; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2b3cb32b0f FOREIGN KEY (video_chipset_id) REFERENCES public.video_chipset(id);


--
-- Name: motherboard fk_7f7a0f2b900d537d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2b900d537d FOREIGN KEY (max_video_ram_id) REFERENCES public.max_ram(id);


--
-- Name: motherboard fk_7f7a0f2ba23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2ba23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: motherboard fk_7f7a0f2bbc1433b9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2bbc1433b9 FOREIGN KEY (chipset_id) REFERENCES public.chipset(id);


--
-- Name: motherboard fk_7f7a0f2bbc4062b4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2bbc4062b4 FOREIGN KEY (audio_chipset_id) REFERENCES public.audio_chipset(id);


--
-- Name: motherboard fk_7f7a0f2bcd887eaf; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard
    ADD CONSTRAINT fk_7f7a0f2bcd887eaf FOREIGN KEY (form_factor_id) REFERENCES public.form_factor(id);


--
-- Name: motherboard_dram_type fk_85a962606511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_dram_type
    ADD CONSTRAINT fk_85a962606511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_dram_type fk_85a96260b1e0c110; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_dram_type
    ADD CONSTRAINT fk_85a96260b1e0c110 FOREIGN KEY (dram_type_id) REFERENCES public.dram_type(id) ON DELETE CASCADE;


--
-- Name: motherboard_cpu_socket fk_8bf3b2736511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_socket
    ADD CONSTRAINT fk_8bf3b2736511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_cpu_socket fk_8bf3b2736b6a65a0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_socket
    ADD CONSTRAINT fk_8bf3b2736b6a65a0 FOREIGN KEY (cpu_socket_id) REFERENCES public.cpu_socket(id) ON DELETE CASCADE;


--
-- Name: large_file fk_8c8cd216398716cd; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file
    ADD CONSTRAINT fk_8c8cd216398716cd FOREIGN KEY (dump_quality_flag_id) REFERENCES public.dump_quality_flag(id);


--
-- Name: manufacturer_bios_manufacturer_code fk_992235c6a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manufacturer_bios_manufacturer_code
    ADD CONSTRAINT fk_992235c6a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: manufacturer_bios_manufacturer_code fk_992235c6e209fba6; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.manufacturer_bios_manufacturer_code
    ADD CONSTRAINT fk_992235c6e209fba6 FOREIGN KEY (bios_manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: motherboard_bios fk_9e92b1326511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_bios
    ADD CONSTRAINT fk_9e92b1326511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_bios fk_9e92b132a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_bios
    ADD CONSTRAINT fk_9e92b132a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: instruction_set_instruction_set fk_a5925a66e53a5cf8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instruction_set_instruction_set
    ADD CONSTRAINT fk_a5925a66e53a5cf8 FOREIGN KEY (instruction_set_target) REFERENCES public.instruction_set(id) ON DELETE CASCADE;


--
-- Name: instruction_set_instruction_set fk_a5925a66fcdf0c77; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instruction_set_instruction_set
    ADD CONSTRAINT fk_a5925a66fcdf0c77 FOREIGN KEY (instruction_set_source) REFERENCES public.instruction_set(id) ON DELETE CASCADE;


--
-- Name: motherboard_cpu_speed fk_a713cf6b6511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_speed
    ADD CONSTRAINT fk_a713cf6b6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_cpu_speed fk_a713cf6b8da8b6e5; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_cpu_speed
    ADD CONSTRAINT fk_a713cf6b8da8b6e5 FOREIGN KEY (cpu_speed_id) REFERENCES public.cpu_speed(id) ON DELETE CASCADE;


--
-- Name: chip fk_aa29bcbba23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip
    ADD CONSTRAINT fk_aa29bcbba23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: chipset_part fk_aab5aea3bf396750; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chipset_part
    ADD CONSTRAINT fk_aab5aea3bf396750 FOREIGN KEY (id) REFERENCES public.chip(id) ON DELETE CASCADE;


--
-- Name: processing_unit_instruction_set fk_bc595800929cc919; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_instruction_set
    ADD CONSTRAINT fk_bc595800929cc919 FOREIGN KEY (instruction_set_id) REFERENCES public.instruction_set(id) ON DELETE CASCADE;


--
-- Name: processing_unit_instruction_set fk_bc59580093e55c96; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_instruction_set
    ADD CONSTRAINT fk_bc59580093e55c96 FOREIGN KEY (processing_unit_id) REFERENCES public.processing_unit(id) ON DELETE CASCADE;


--
-- Name: video_chipset fk_c030a4f2a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.video_chipset
    ADD CONSTRAINT fk_c030a4f2a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: chip_alias fk_c7bbb9a9a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_alias
    ADD CONSTRAINT fk_c7bbb9a9a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: chip_alias fk_c7bbb9a9a588adb3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_alias
    ADD CONSTRAINT fk_c7bbb9a9a588adb3 FOREIGN KEY (chip_id) REFERENCES public.chip(id);


--
-- Name: large_file_os_flag fk_c873b20c29ea72e8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_os_flag
    ADD CONSTRAINT fk_c873b20c29ea72e8 FOREIGN KEY (large_file_id) REFERENCES public.large_file(id);


--
-- Name: large_file_os_flag fk_c873b20c8abd126a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_os_flag
    ADD CONSTRAINT fk_c873b20c8abd126a FOREIGN KEY (os_flag_id) REFERENCES public.os_flag(id);


--
-- Name: large_file_chipset fk_ca790fd229ea72e8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_chipset
    ADD CONSTRAINT fk_ca790fd229ea72e8 FOREIGN KEY (large_file_id) REFERENCES public.large_file(id);


--
-- Name: large_file_chipset fk_ca790fd2bc1433b9; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_chipset
    ADD CONSTRAINT fk_ca790fd2bc1433b9 FOREIGN KEY (chipset_id) REFERENCES public.chipset(id);


--
-- Name: processor_voltage fk_d614e2fe37bac19a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_voltage
    ADD CONSTRAINT fk_d614e2fe37bac19a FOREIGN KEY (processor_id) REFERENCES public.processor(id);


--
-- Name: processing_unit_cpu_socket fk_db937a2b6b6a65a0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_cpu_socket
    ADD CONSTRAINT fk_db937a2b6b6a65a0 FOREIGN KEY (cpu_socket_id) REFERENCES public.cpu_socket(id) ON DELETE CASCADE;


--
-- Name: processing_unit_cpu_socket fk_db937a2b93e55c96; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processing_unit_cpu_socket
    ADD CONSTRAINT fk_db937a2b93e55c96 FOREIGN KEY (processing_unit_id) REFERENCES public.processing_unit(id) ON DELETE CASCADE;


--
-- Name: motherboard_psuconnector fk_df1d9f996511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_psuconnector
    ADD CONSTRAINT fk_df1d9f996511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id) ON DELETE CASCADE;


--
-- Name: motherboard_psuconnector fk_df1d9f99d6871168; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_psuconnector
    ADD CONSTRAINT fk_df1d9f99d6871168 FOREIGN KEY (psuconnector_id) REFERENCES public.psuconnector(id) ON DELETE CASCADE;


--
-- Name: motherboard_alias fk_df408ab96511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_alias
    ADD CONSTRAINT fk_df408ab96511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_alias fk_df408ab9a23b42d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_alias
    ADD CONSTRAINT fk_df408ab9a23b42d FOREIGN KEY (manufacturer_id) REFERENCES public.manufacturer(id);


--
-- Name: chip_image fk_e3ead662460f904b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_image
    ADD CONSTRAINT fk_e3ead662460f904b FOREIGN KEY (license_id) REFERENCES public.license(id);


--
-- Name: chip_image fk_e3ead662a588adb3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_image
    ADD CONSTRAINT fk_e3ead662a588adb3 FOREIGN KEY (chip_id) REFERENCES public.chip(id);


--
-- Name: chip_image fk_e3ead662df91ac92; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chip_image
    ADD CONSTRAINT fk_e3ead662df91ac92 FOREIGN KEY (creditor_id) REFERENCES public.creditor(id);


--
-- Name: large_file_motherboard fk_e989be6729ea72e8; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_motherboard
    ADD CONSTRAINT fk_e989be6729ea72e8 FOREIGN KEY (large_file_id) REFERENCES public.large_file(id);


--
-- Name: large_file_motherboard fk_e989be676511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.large_file_motherboard
    ADD CONSTRAINT fk_e989be676511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_image fk_fb11e572460f904b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image
    ADD CONSTRAINT fk_fb11e572460f904b FOREIGN KEY (license_id) REFERENCES public.license(id);


--
-- Name: motherboard_image fk_fb11e5726511e8a3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image
    ADD CONSTRAINT fk_fb11e5726511e8a3 FOREIGN KEY (motherboard_id) REFERENCES public.motherboard(id);


--
-- Name: motherboard_image fk_fb11e572df91ac92; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image
    ADD CONSTRAINT fk_fb11e572df91ac92 FOREIGN KEY (creditor_id) REFERENCES public.creditor(id);


--
-- Name: motherboard_image fk_fb11e572f987c2c1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motherboard_image
    ADD CONSTRAINT fk_fb11e572f987c2c1 FOREIGN KEY (motherboard_image_type_id) REFERENCES public.motherboard_image_type(id);


--
-- Name: processor_platform_type_processor_platform_type fk_ffe4afe1eb5c3a2d; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_platform_type_processor_platform_type
    ADD CONSTRAINT fk_ffe4afe1eb5c3a2d FOREIGN KEY (processor_platform_type_target) REFERENCES public.processor_platform_type(id) ON DELETE CASCADE;


--
-- Name: processor_platform_type_processor_platform_type fk_ffe4afe1f2b96aa2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.processor_platform_type_processor_platform_type
    ADD CONSTRAINT fk_ffe4afe1f2b96aa2 FOREIGN KEY (processor_platform_type_source) REFERENCES public.processor_platform_type(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

