# API Versioning Guide

## Strategy

- Semantic versioning applied to public HTTP contract.
- Current stable namespace: `v1` via `/api/v1`.
- Breaking changes shipped only in new prefix (`/api/v2`), while `v1` remains in maintenance mode.

## Deprecation Policy

1. Announce deprecation in release notes and `CHANGELOG.md`.
2. Include `Deprecation` header with target removal version.
3. Provide parallel response payload fields until removal date.

## Testing Matrix

- Feature tests live under `tests/Feature/Api/V1`.
- Snapshot assertions guarantee response shape.
- Contract tests executed in CI for every endpoint before release cut.

## Documentation

- OpenAPI spec stored at `docs/openapi/v1.yaml`.
- Publish docs via Stoplight or Redoc on `/docs`.
- Each new version clones previous spec as baseline.

## Upgrade Checklist

1. Duplicate controllers/requests/resources into new namespace.
2. Update `routes/api.php` to expose `/api/v2`.
3. Maintain integration tests for old versions until EOL.
4. Communicate timeline to frontend team for migration.

