# --------------------------------------------------------
#
# Schema for Ventrilo
#
# --------------------------------------------------------


# Table table_one
CREATE TABLE ventrilo_table_one (
    table_one_key  INT NOT NULL AUTO_INCREMENT,
    table_one_char CHAR(32),
    table_one_text TEXT,


    table_two_key  INT,
# Foreign Keys
#	FOREIGN KEY (table_two_key) REFERENCES table_two(table_two_key),

# keys
    PRIMARY KEY (table_one_key)
)
    ENGINE = ISAM;


# Table table_two
CREATE TABLE ventrilo_table_two (
    table_two_key  INT NOT NULL AUTO_INCREMENT,
    table_two_char CHAR(32),
    table_two_text TEXT,


# keys
    PRIMARY KEY (table_two_key)
)
    ENGINE = ISAM;


# This table holds any configuration settings for the module
CREATE TABLE ventrilo_config (
    config_id                        INT NOT NULL,
    config_main_server               TEXT,
    config_server                    TEXT,
    config_server_label              TEXT,
    config_server_color              TEXT,
    config_main_ExternalServer       TEXT,
    config_main_ExternalServer_label TEXT,
    config_main_ExternalServer_color TEXT,
    config_cmdhost                   TEXT,
    config_cmdport                   TEXT,
    config_webport                   TEXT,
    config_cmdpass                   TEXT,
    config_cmdhost2                  TEXT,
    config_cmdport2                  TEXT,
    config_webport2                  TEXT,
    config_cmdpass2                  TEXT,
    number_of_servers                TEXT,
    colorrow1                        TEXT,
    colorrow2                        TEXT,
    colorlobby                       TEXT,
    colorlobbyhead                   TEXT,
    colorlobbyuser                   TEXT,
    colorrowserver1                  TEXT,
    colorrowserver2                  TEXT,
    colortitleserver1                TEXT,
    colortitleserver2                TEXT,
    displayinternal                  TEXT,

    PRIMARY KEY (config_id)
)
    ENGINE = ISAM;

# Set defaults, if necessary.
INSERT INTO ventrilo_config (config_id, config_main_server, config_server, config_server_label, config_server_color, config_main_ExternalServer, config_main_ExternalServer_label, config_main_ExternalServer_color, config_cmdhost, config_cmdport, config_webport, config_cmdpass, config_cmdhost2,
                             config_cmdport2, config_webport2, config_cmdpass2, number_of_servers, colorrow1, colorrow2, colorlobby, colorlobbyuser, colorlobbyhead, colorrowserver1, colorrowserver2, colortitleserver1, colortitleserver2, displayinternal)
VALUES (1, "/usr/local/ventrilo/ventrilo_status", "pyrosoft.cable.nu", "Axis", "red", "pyrosoft.cable.nu", "Allies", "blue", "127.0.0.1", "3784", "3784", "", "192.168.6.180", "3784", "3785", "", "2", "LightBlue", "LightCyan", "purple", "Crimson", "aqua", "LightBlue", "LightCyan", "black", "black",
        "yes");


