DROP TABLE IF EXISTS "Tech";
DROP TABLE IF EXISTS "Links";
DROP TABLE IF EXISTS "Tech_then";
CREATE TABLE Tech (
    tech_id      INTEGER PRIMARY KEY,    
    name         VARCHAR(50),
    description  VARCHAR(500),
    home         VARCHAR(200)
);

CREATE TABLE Links (
    link_id     INTEGER PRIMARY KEY,    
    tech_id     BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(30),
    url         VARCHAR(500), 
    FOREIGN KEY (tech_id) REFERENCES Tech(tech_id)
);

CREATE TABLE Tech_then (
    tech_id      BIGINT UNSIGNED NOT NULL,
    then_id      BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (tech_id) REFERENCES Tech(tech_id),
    FOREIGN KEY (then_id) REFERENCES Tech(tech_id)
);
