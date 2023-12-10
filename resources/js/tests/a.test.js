import { describe, it } from 'vitest';

describe('suite', () => {
  it('serial test', async () => { /* ... */ });
  it.concurrent('concurrent test 1', async () => { /* ... */ });
  it.concurrent('concurrent test 2', async () => { /* ... */ });
});
