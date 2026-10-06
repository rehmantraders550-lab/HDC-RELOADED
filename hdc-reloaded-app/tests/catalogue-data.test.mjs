import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
const items=JSON.parse(readFileSync(new URL('../app/products.json',import.meta.url),'utf8'));
test('ORVIA source catalogue contains 19 detailed draft records',()=>{
 assert.equal(items.length,19);
 assert.ok(items.every(p=>p.status==='draft'&&p.published===false&&p.short&&p.description));
 assert.ok(items.some(p=>p.name==='UV DTF Decals'));
 assert.ok(items.some(p=>p.name==='Catalogues')===false,'owner-confirmed catalogue entry is added by the PHP seed step');
});
test('surface-sensitive and unconfirmed DTF offers retain production review copy',()=>{
 const uv=items.find(p=>p.name==='UV DTF Decals');
 assert.match(uv.description,/Compatibility depends on the actual surface/);
 for(const name of ['Custom DTF Transfers','T-Shirts']) assert.equal(items.find(p=>p.name===name).published,false);
});
test('price-sensitive print services do not embed invented unit totals',()=>{
 for(const p of items) assert.doesNotMatch(p.short,/PKR\s*[0-9,]+/);
});
