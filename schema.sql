CREATE TABLE Tech (
    tech_id      SERIAL PRIMARY KEY,    
    description  VARCHAR(500),
    then_id      BIGINT UNSIGNED NOT NULL,
    home         VARCHAR(200),
    FOEIGN KEY (then_id) REFERENCES Tech(tech_id)
);

CREATE TABLE Links (
    link_id     SERIAL PRIMARY KEY,    
    tech_id     BIGINT UNSIGNED NOT NULL,
    name        VARCHAR(30),
    url         VARCHAR(500), 
    FOEIGN KEY (tech_id) REFERENCES Tech(tech_id)
);
