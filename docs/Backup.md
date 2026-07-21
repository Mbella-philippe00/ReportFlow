# Backup and Recovery

## Backup Scope

Back up these assets together:

- Production database.
- `storage/app/public` report attachments and generated files.
- `.env.production` and secrets stored in the deployment secret manager.
- Docker image tags or release artifacts for the deployed version.

## Database Backup

MySQL example:

```bash
mysqldump --single-transaction --routines --triggers reportflow > reportflow-$(date +%F).sql
```

Compress and encrypt backups before external storage:

```bash
gzip reportflow-$(date +%F).sql
```

## File Backup

```bash
tar -czf reportflow-storage-$(date +%F).tar.gz storage/app/public
```

For object storage, enable bucket versioning and lifecycle retention.

## Retention

- Daily backups for 14 days.
- Weekly backups for 8 weeks.
- Monthly backups for 12 months.

Adjust retention for compliance requirements.

## Recovery

1. Stop write traffic or enter maintenance mode.
2. Restore database to a clean schema.
3. Restore `storage/app/public`.
4. Deploy the matching application version.
5. Run `php artisan migrate --force` if the restored release requires migrations.
6. Run `scripts/production-cache.sh`.
7. Confirm `/ready` returns HTTP 200.
8. Perform a report workflow smoke test.

## Recovery Test Cadence

Perform a full restore drill at least once per quarter and after major release changes.
