import { autocomplete } from '@algolia/autocomplete-js';
import '@algolia/autocomplete-theme-classic';
import { MeiliSearch } from 'meilisearch'
import { html } from 'htm/preact';
const client = new MeiliSearch({
    host: 'http://127.0.0.1:7700'
})
const searchIndex = client.index('movies')
autocomplete({
    container: '#autocomplete',
    placeholder: 'Search for products',
    async getSources({query}) {
        return [
            {
                sourceId: 'links',
                async getItems({ query }) {
                    const a =  await searchIndex.search(query);
                    console.log(a);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Movies</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return AutocompleteProductItem({hit: item}); //item.title;
                    },
                    noResults() {
                        return 'No products for this query.';
                    },
                },
            },
        ];
    },
});

function AutocompleteProductItem({hit}) {
    console.log(hit);
    return html`<div className="aa-ItemWrapper">${hit.title}</div>`
   // return html`<!--<div className="aa-ItemWrapper"><div className="aa-ItemContent"><div className="aa-ItemIcon aa-ItemIcon&#45;&#45;alignTop"><img src=${hit.poster} alt=${hit.title} width="40" height="40" /></div><div className="aa-ItemContentBody"><div className="aa-ItemContentTitle">${hit.title}</div></div></div><div className="aa-ItemActions"><buttonclassName="aa-ItemActionButton aa-DesktopOnly aa-ActiveOnly"type="button"title="Select"style={{ pointerEvents: 'none' }}><svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M18.984 6.984h2.016v6h-15.188l3.609 3.609-1.406 1.406-6-6 6-6 1.406 1.406-3.609 3.609h13.172v-4.031z" /></svg></button></div></div>-->`
}
