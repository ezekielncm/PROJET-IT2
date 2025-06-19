
# Déploiement UrbanHome avec Docker

## 🚀 Lancer en local

1. Cloner le projet et placer le fichier `.env` à la racine (voir README principal pour l’exemple).
2. Lancer :
   ```bash
   docker compose up --build
   ```
3. Accéder à l’application sur [http://localhost:8000](http://localhost:8000)

## 📦 Extensions PHP
Les extensions nécessaires (pdo_mysql, gd, mbstring, zip, etc.) sont déjà installées dans le Dockerfile. Pour en ajouter, modifiez la section correspondante dans le Dockerfile.

## ☁️ Déployer sur un serveur Docker (VPS, cloud)

### 1. Build et push sur Docker Hub
```bash
docker build -t votreuser/urbanhome:latest .
docker push votreuser/urbanhome:latest
```

### 2. Sur le serveur (VPS, cloud, dédié)
1. Installer Docker et Docker Compose.
2. Récupérer le fichier `compose.yaml` adapté (voir README principal ou exemple ci-dessous).
3. Placer le fichier `.env` et (optionnel) `urbanhome.sql` pour l’import automatique de la base.
4. Lancer :
   ```bash
   docker compose up -d
   ```

### Exemple de docker-compose.yml pour Docker Hub
```yaml
services:
  web:
    image: votreuser/urbanhome:latest
    ports:
      - "8000:80"
    environment:
      - DB_HOST=db
      - DB_NAME=urbanhome
      - DB_USER=root
      - DB_PASS=urbanhomepass
    depends_on:
      - db
    volumes:
      - ./.env:/var/www/html/.env
      - ./urbanhome.sql:/docker-entrypoint-initdb.d/urbanhome.sql
  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: urbanhome
      MYSQL_ROOT_PASSWORD: urbanhomepass
      MYSQL_USER: urbanuser
      MYSQL_PASSWORD: urbanhomepass
    ports:
      - "3307:3306"
    volumes:
      - db-data:/var/lib/mysql
      - ./urbanhome.sql:/docker-entrypoint-initdb.d/urbanhome.sql
volumes:
  db-data:
```

## 🔒 Conseils sécurité
- Changez les mots de passe par défaut pour la production.
- Utilisez un proxy (Nginx, Traefik) pour HTTPS.
- Ouvrez uniquement les ports nécessaires.

Pour plus de détails, consultez le README principal du projet.