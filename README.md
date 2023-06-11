# Nusa Travel Agent Website

Rest API URL: [https://documenter.getpostman.com/view/1829038/2s93RL2cVV](https://documenter.getpostman.com/view/1829038/2s93RL2cVV).

## Etc

### Knowladge

-   departure dan arrival secara database terbalik di form yang tampil

### nusatravel.ajikamaludin.id deployment

```bash
rsync -arP -e 'ssh -p 224' --exclude=node_modules --exclude=.git --exclude=.env --exclude=database/database.sqlite --exclude=public/uploads --exclude=storage --exclude=public/hot . arm@ajikamaludin.id:/home/arm/projects/nusatravel
```

### Update Step

-   Export Latest Database for backup, and for migrate/upgrade on local
-   Backup any image in public/uploads

### Build

#### Swiftbooking

-   changes .env
    VITE_BUILD_OPT="partner"
-   npm run build
-   zip the folder

#### Nusa

-   changes .env
    VITE_BUILD_OPT="nusa"
-   npm run build
-   zip the folder

#### Singgahsiniaja

-   changes .env
    VITE_BUILD_OPT="partner"
    VITE_BUILD_GLOBALTIX=false
-   npm run build
-   zip the folder
