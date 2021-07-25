import { autocomplete } from '@algolia/autocomplete-js';
import '@algolia/autocomplete-theme-classic';
import { MeiliSearch } from 'meilisearch'
import { html } from 'htm/preact';
const client = new MeiliSearch({
    host: 'http://127.0.0.1:7700'
})
autocomplete({
    container: '#autocomplete',
    placeholder: 'Search the Abyss Tracker',
    async getSources({query}) {
        return [
            {
                sourceId: 'chars',
                async getItems({ query }) {
                    const a =  await client.index('chars').search(query);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Characters</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return SimpleItem({hit: item});
                    },
                    noResults() {
                        return 'No characters found';
                    },
                },
            },
            {
                sourceId: 'items',
                async getItems({ query }) {
                    const a =  await client.index('items').search(query);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Items</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return SimpleItem({hit: item});
                    },
                    noResults() {
                        return 'No characters found';
                    },
                },
            },
            {
                sourceId: 'fits',
                async getItems({ query }) {
                    const a =  await client.index('fits').search(query);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Fits</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return FitItem({hit: item});
                    },
                    noResults() {
                        return 'No fits found';
                    },
                },
            },
            {
                sourceId: 'events',
                async getItems({ query }) {
                    const a =  await client.index('pvp_events').search(query);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Proving Ground events</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return SimpleItem({hit: item});
                    },
                    noResults() {
                        return 'No events found';
                    },
                },
            },
            {
                sourceId: 'tutorials',
                async getItems({ query }) {
                    const a =  await client.index('tutorials').search(query);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.poster;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Tutorials</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return SimpleItem({hit: item});
                    },
                    noResults() {
                        return 'No events found';
                    },
                },
            },
        ];
    },
    debug: true
});

function FitItem({hit}) {
    return html`<a href=${hit.url} className="aa-ItemLink">
        <div className="aa-ItemContent" style="overflow: visible">
            <div className="aa-ItemIcon aa-ItemIcon--picture aa-ItemIcon--alignTop shadow rounded-circle" style="width: 40px; height: 40px; border: 1px solid #fff;" >
                <img src=${hit.img} alt=${hit.name}  class="p-0 w-100" />
            </div>
            <div className="aa-ItemContentBody">
                <div className="aa-ItemContentTitle">
                    ${hit.name}
                </div>
                <div className="aa-ItemContentDescription">
                    <strong>${hit.hull}</strong><span class="mx-2">·</span>${hit.tags}
                </div>
            </div>
        </div>
    </a>`;
}

function SimpleItem({hit}) {
    return html`<a href=${hit.url} className="aa-ItemLink">
        <div className="aa-ItemContent" style="overflow: visible">
            <div className="aa-ItemIcon aa-ItemIcon--picture aa-ItemIcon--alignTop shadow rounded-circle" style="width: 40px; height: 40px; border: 1px solid #fff;" >
                <img src=${hit.img} alt=${hit.name}  class="p-0 w-100" />
            </div>
            <div className="aa-ItemContentBody">
                <div className="aa-ItemContentTitle">
                    ${hit.name}
                </div>
            </div>
        </div>
    </a>`;
}
