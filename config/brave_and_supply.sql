PRAGMA foreign_keys = ON;

-- ==========================
-- USERS
-- ==========================

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user'
        CHECK(role IN ('user', 'admin')),
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    address TEXT,
    updated_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- ==========================
-- CATEGORIES
-- ==========================

CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ==========================
-- PRODUCTS
-- ==========================

CREATE TABLE products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER,
    name TEXT NOT NULL,
    description TEXT,
    price REAL NOT NULL CHECK(price >= 0),
    stock INTEGER NOT NULL DEFAULT 0 CHECK(stock >= 0),
    image TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE SET NULL
);

-- ==========================
-- COUPONS
-- ==========================

CREATE TABLE coupons (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    reduce INTEGER NOT NULL
);

-- ==========================
-- CARTS
-- ==========================

CREATE TABLE carts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- ==========================
-- CART ITEMS
-- ==========================

CREATE TABLE cart_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cart_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 1 CHECK(quantity > 0),

    FOREIGN KEY (cart_id)
        REFERENCES carts(id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,

    UNIQUE(cart_id, product_id)
);

-- ==========================
-- FAVORITES
-- ==========================

CREATE TABLE favorites (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,

    UNIQUE(user_id, product_id)
);

-- ==========================
-- ORDERS
-- ==========================

CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    total_price REAL NOT NULL,

    status TEXT NOT NULL DEFAULT 'pending'
        CHECK(status IN ('pending','paid','shipped','delivered','cancelled')),

    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT
);

-- ==========================
-- ORDER ITEMS
-- ==========================

CREATE TABLE order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL CHECK(quantity > 0),
    price REAL NOT NULL,

    FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE RESTRICT,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE RESTRICT
);

-- ==========================
-- PRODUCT LISTS
-- ==========================

CREATE TABLE product_lists (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    name TEXT NOT NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- ==========================
-- PRODUCT LIST ITEMS
-- ==========================

CREATE TABLE product_list_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,

    FOREIGN KEY (list_id)
        REFERENCES product_lists(id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,

    UNIQUE(list_id, product_id)
);

-- ==========================
-- REVIEWS
-- ==========================

CREATE TABLE reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    comment TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- ----------
-- Ajout des datas par défaut
-- ----------


-- ===========================================
-- CATEGORIES
-- ===========================================

INSERT INTO categories (id, name, created_at) VALUES
(1, 'Homme', '2026-05-28 12:24:53'),
(2, 'Femme', '2026-05-28 12:24:53'),
(3, 'Enfant', '2026-05-28 12:24:53'),
(4, 'Accessoires', '2026-05-28 12:24:53'),
(5, 'Test', '2026-05-28 12:24:53');

-- ===========================================
-- PRODUCTS
-- ===========================================

INSERT INTO products (id, category_id, name, description, price, stock, image, created_at) VALUES
(1, 1, 'Costume bleu rayé croisé', 'Costume homme élégant bleu marine à rayures fines, coupe croisée moderne. Idéal pour événements professionnels et cérémonies.', 149.99, 12, 'costume-bleu-raye-croise.jpg', '2026-05-28 12:25:52'),

(2, 3, 'Costume enfant cérémonie beige', 'Costume beige pour enfant, parfait pour mariages et grandes occasions. Tissu confortable et coupe adaptée aux mouvements.', 59.99, 20, 'costume-enfant-ceremonie-beige-2.jpg', '2026-05-28 12:25:52'),

(3, 2, 'Crop top en coton piqué fleuri', 'Crop top femme en coton piqué avec motif floral. Léger, respirant, idéal pour l’été ou un look décontracté chic.', 24.99, 35, 'crop-top-en-coton-pique-fleuri.jpg', '2026-05-28 12:25:52'),

(4, 1, 'Blazer icon bleu nuit','Blazer homme bleu nuit élégant et polyvalent. Sa coupe moderne convient aussi bien à une tenue professionnelle qu’à une occasion chic.',89.99, 18, 'blazer-icon-bleu-nuit.jpg', '2026-05-28 12:25:52'),

(5, 2, 'Combinaison ambitieuse en soie ivoire','Combinaison femme raffinée en soie ivoire, avec une coupe élégante et fluide. Une pièce idéale pour les cérémonies et soirées habillées.',119.99, 10, 'combinaison-ambitieuse-soie-ivoire.jpg', '2026-05-28 12:25:52'),

(6, 1, 'Veste en lin blanc','Veste homme en lin blanc, légère et respirante. Une pièce chic et polyvalente parfaite pour les beaux jours et les cérémonies.',84.99, 14, 'veste-en-lin-blanc.jpg', '2026-05-28 12:25:52'),

(7, 2, 'Look femme intemporel','Pièce féminine élégante et facile à associer, idéale pour créer une tenue moderne, sobre et raffinée.',69.99, 16, 'femmes-index.jpg', '2026-05-28 12:25:52'),

(8, 4, 'Pochette en lin blanc','Pochette élégante en lin blanc, légère et raffinée. L’accessoire parfait pour compléter une tenue estivale ou une cérémonie.',29.99, 25, 'Pochette-en-lin-blanc.jpg', '2026-05-28 12:25:52'),

(9, 1, 'Polo bleu','Polo homme bleu en matière confortable, avec une coupe élégante et décontractée. Idéal pour un style quotidien soigné.',39.99, 30, 'polo-bleu.jpg', '2026-05-28 12:25:52'),

(10, 2, 'Robe de mariage élégante en soie ivoire','Robe de mariage élégante en soie ivoire, avec une silhouette raffinée et un tombé fluide. Une pièce pensée pour les grandes occasions.',179.99, 8, 'robe-mariage-elegante-soie-ivoire.jpg', '2026-05-28 12:25:52'),

(11, 2, 'Robe de mariage timide en soie ivoire','Robe de cérémonie en soie ivoire au style délicat et romantique. Sa coupe élégante apporte une allure raffinée et naturelle.',159.99, 9, 'robe-mariage-timide-soie-ivoire.jpg', '2026-05-28 12:25:52'),

(12, 4, 'Lunettes de soleil - FOR SURE','Monture élégante aux lignes raffinées, conçue dans des matériaux haut de gamme. Ses verres teintés offrent une protection optimale contre les rayons UV tout en apportant une touche sophistiquée à chaque tenue. Un accessoire intemporel, idéal pour compléter un style chic et moderne.  ',159.99, 9, 'lunettes-de-soleil.jpg', '2026-05-28 12:25:52');

-- ===========================================
-- USERS
-- ===========================================

INSERT INTO users (id, name, email, password, role, created_at, address, updated_at) VALUES
(1, 'Toto Grimal', 'toto.grimal@iut.fr', '$2y$12$ZMhzN8fmrMhQ69RY8pX79.JZplYSj/233byzpFwXouoSP6NM.W21S', 'admin', '2026-05-21 18:52:33', '1600 Pennsylvania Avenue NW, Washington, D.C., États-Unis', '2026-06-22 20:21:35'),

(2, 'Michel Polnareff', 'michel.polnareff@la-defense.com', '$2y$12$X3iA/YpJZyq82OQR5SJlUeGPUp38B.0dY1iy97GK9DzfzhNd27RN6', 'admin', '2026-05-21 18:52:33', 'Puteaux La Défense 92800 Paris', '2026-06-22 20:41:17'),

(3, 'Alice Liddell', 'alice.liddell@test.com', '$2y$12$KoR4eCoSIDuu0PsdwmpQaenjlGoqbUeSfSWeAmoRyol1kr7hLTKf6', 'admin', '2026-05-21 18:52:33', 'Piazza del Colosseo, 1, Rome, Italie', '2026-06-22 20:40:22'),

(4, 'Bob Marley', 'bob.marley@gmail.com', '$2y$12$J/ydKJgldkbjzTR6pmflfugAYkZAlCLBQ1fJeuaQwmSwQgjGJlre2', 'admin', '2026-05-21 18:52:33', '221B Baker Street, Londres, Royaume-Uni', '2026-06-22 20:40:51'),

(5, 'michael.olise@gmail.com', 'michael.olise@gmail.com', '$2y$12$qPIqkyDYR0O1tegQ556xP.Mmo1SrsrriZSNOrcJy5yLyu.Ts/4wJC', 'user', '2026-05-21 18:52:33', '62 kergroas, Plounévézel', '2026-06-22 19:33:19'),

(6, 'Emmanuel Macron', 'emmanuel.macron@gmail.com', '$2y$12$2FR6YOo9FlGCwx4S6EtJ4edK82B5slfgDIOvMV41i0U.TlYXg3Quq', 'user', '2026-05-21 18:52:33', '9 Rue des Lilas, Bordeaux', '2026-06-22 19:33:27'),

(7, 'Brad Pitt', 'brad.pittd@gmail.com', '$2y$12$flJ//SYNqJUWZZR4NIvmvO3JuUF9Lrb3stGWMeU5iwjT0X74fOfQ.', 'user', '2026-05-21 18:52:33', '21 Avenue Jean Jaurès, Toulouse', '2026-06-22 19:33:35'),

(8, 'Marine Le Pen', 'marine.lepen@gmail.com', '$2y$12$2ICjMhf8ibd5hFEnkj4Np.K8jKKit7Bvnl7OOIdMBICYEWm1ur8mW', 'user', '2026-05-21 18:52:33', '7 Rue de Strasbourg, Nantes', '2026-06-22 19:33:43'),

(9, 'Emma Watson', 'emma.watson@gmail.com', '$2y$12$2R28Fp4A.52JYveWfiK0iO1dbx9NbUg98rKKUJ0HvEd0EJK5gUEUq', 'user', '2026-05-21 18:52:33', '30 Rue Saint-Michel, Rennes', '2026-06-22 19:33:51'),

(10, 'Elon Musk', 'elon.musk@gmail.com', '$2y$12$V8rJuIwzksfJ5AC12G4/WuLBYbLFiedC.bOcWFfjHVNWrPKFgYKTm', 'user', '2026-05-21 18:52:33', '15 Rue du Commerce, Nice', '2026-06-22 19:34:03');

-- ===========================================
-- COUPONS
-- ===========================================

INSERT INTO coupons (id, code, reduce) VALUES
(1, 'WELCOME10', 10),
(2, 'SUMMER20', 20),
(3, 'VIP50', 50);


-- ===========================================
-- CARTS
-- ===========================================

INSERT INTO carts (id, user_id, created_at) VALUES
(1, 5, '2026-07-01 10:15:00'),
(2, 6, '2026-07-02 14:30:00'),
(3, 7, '2026-07-03 18:45:00');

-- ===========================================
-- CART ITEMS
-- ===========================================

INSERT INTO cart_items (id, cart_id, product_id, quantity) VALUES
(1, 1, 1, 1),
(2, 1, 3, 2),
(3, 2, 2, 1),
(4, 3, 1, 1),
(5, 3, 2, 1);

-- ===========================================
-- FAVORITES
-- ===========================================

INSERT INTO favorites (id, user_id, product_id) VALUES
(1, 5, 1),
(2, 5, 3),
(3, 6, 2),
(4, 7, 1),
(5, 8, 3),
(6, 9, 2);

-- ===========================================
-- PRODUCT LISTS
-- ===========================================
INSERT INTO product_lists (id, user_id, name) VALUES
(1, 5, 'Ma wishlist'),
(2, 6, 'Tenues été'),
(3, 7, 'Costumes préférés'),
(4, 9, 'Pour mon anniv');

-- ===========================================
-- PRODUCT LIST ITEMS
-- ===========================================

INSERT INTO product_list_items (id, list_id, product_id) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 3),
(4, 3, 1),
(5, 3, 2);

-- ===========================================
-- ORDERS
-- ===========================================

INSERT INTO orders (id, user_id, total_price, status, created_at) VALUES
(1, 5, 149.99, 'paid', '2026-06-15 11:22:00'),
(2, 6, 84.98, 'shipped', '2026-06-18 16:40:00'),
(3, 7, 59.99, 'delivered', '2026-06-21 09:10:00'),
(4, 8, 174.98, 'pending', '2026-07-05 15:30:00'),
(5, 9, 24.99, 'cancelled', '2026-07-06 18:45:00');

-- ===========================================
-- ORDER ITEMS
-- ===========================================

INSERT INTO order_items (id, order_id, product_id, quantity, price) VALUES
(1, 1, 1, 1, 149.99),

(2, 2, 2, 1, 59.99),
(3, 2, 3, 1, 24.99),

(4, 3, 2, 1, 59.99),

(5, 4, 1, 1, 149.99),
(6, 4, 3, 1, 24.99),

(7, 5, 3, 1, 24.99);

-- ===========================================
-- REVIEWS
-- ===========================================

INSERT INTO reviews (id, user_id, comment, created_at) VALUES
(1, 5, 'Très bonne qualité, je recommande !', '2026-06-16 09:00:00'),
(2, 6, 'Livraison rapide et produit conforme.', '2026-06-19 18:30:00'),
(3, 7, 'Très satisfait de mon achat.', '2026-06-22 11:45:00'),
(4, 8, 'Le costume est magnifique.', '2026-07-03 14:20:00'),
(5, 9, 'Excellent rapport qualité/prix.', '2026-07-04 17:10:00'),
(6, 10, 'Je recommanderai sans hésiter.', '2026-07-05 20:05:00');




