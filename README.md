# Nusa Travel Agent Website

Rest API URL: [https://documenter.getpostman.com/view/1829038/2s93RL2cVV](https://documenter.getpostman.com/view/1829038/2s93RL2cVV).

## Etc

### Knowladge

- departure dan arrival secara database terbalik di form yang tampil

### nusatravel.ajikamaludin.id deployment

```bash
rsync -arP -e 'ssh -p 222' --exclude=node_modules --exclude=.git --exclude=.env --exclude=database/database.sqlite --exclude=public/uploads --exclude=storage --exclude=public/hot . pi@ajikamaludin.id:/home/pi/projects/nusatravel
```
