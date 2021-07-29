import { autocomplete } from '@algolia/autocomplete-js';
import '@algolia/autocomplete-theme-classic';
import { MeiliSearch } from 'meilisearch'
import { html } from 'htm/preact';
import { createLocalStorageRecentSearchesPlugin } from '@algolia/autocomplete-plugin-recent-searches';

console.log('Abyss Tracker instant search is using ',process.env.MIX_MEILI_ENDPOINT,' as search server with token: ', window.search_token);
const client = new MeiliSearch({
    host: process.env.MIX_MEILI_ENDPOINT,
    apiKey: window.search_token,
})



window.isk_formatter = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'ISK',

    // These options are needed to round to whole numbers if that's what you want.
    minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    maximumFractionDigits: 2, // (causes 2500.99 to be printed as $2,501)
});


window.isk_formatter_mil = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'ISK',

    // These options are needed to round to whole numbers if that's what you want.
    minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    maximumFractionDigits: 2, // (causes 2500.99 to be printed as $2,501)
});

function formatIsk(isk) {
    return (isk > 1_000_000) ? window.isk_formatter_mil.format(isk/1_000_000).replace("ISK", "M ISK") : window.isk_formatter.format(isk);
}

const meiliQueryOptions = {limit: 5, attributesToHighlight: ['*']};
const recentSearchesPlugin = createLocalStorageRecentSearchesPlugin({
    key: 'navbar',
    limit: 3,
    transformSource({ source }) {
        return {
            ...source,
            templates: {
                ...source.templates,
                header({ state }) {
                    if (state.query) {
                        return null;
                    }

                    return html`<span className="aa-SourceHeaderTitle">Recent searches</span><div className="aa-SourceHeaderLine" />`
                },
            },
        };
    },
});
autocomplete({
    container: '#autocomplete',
    placeholder: 'Search the Abyss Tracker',
    // plugins: [recentSearchesPlugin],
    detachedMediaQuery: '(max-width: 5000px)',
    async getSources({query}) {
        return [
            {
                sourceId: 'chars',
                async getItems({ query }) {
                    const a =  await client.index('chars').search(query, meiliQueryOptions);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.url;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Characters</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return CharItem({hit: item});
                    },
                    noResults() {
                        return 'No characters found';
                    },
                }
            },
            {
                sourceId: 'items',
                async getItems({ query }) {
                    const a =  await client.index('items').search(query, meiliQueryOptions);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.url;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Items</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return ItemItem({hit: item});
                    },
                    noResults() {
                        return 'No characters found';
                    },
                },
            },
            {
                sourceId: 'fits',
                async getItems({ query }) {
                    const a =  await client.index('fits').search(query, meiliQueryOptions);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.url;
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
                    const a =  await client.index('pvp_events').search(query, meiliQueryOptions);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.url;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Proving Ground events</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return EventItem({hit: item});
                    },
                    noResults() {
                        return 'No events found';
                    },
                },
            },
            {
                sourceId: 'tutorials',
                async getItems({ query }) {
                    const a =  await client.index('tutorials').search(query, meiliQueryOptions);
                    return a.hits;
                },
                getItemUrl({ item }) {
                    return item.url;
                },
                templates: {
                    header() {return html`<span className="aa-SourceHeaderTitle">Tutorials</span><div className="aa-SourceHeaderLine" />`},
                    item({ item }) {
                        return TutorialItem({hit: item});
                    },
                    noResults() {
                        return 'No events found';
                    },
                },
            },
        ];
    },
    openOnFocus: false,
    navigator: {
        navigate({ itemUrl }) {
            console.log('navigator.navigate', itemUrl);
            window.location.assign(itemUrl);
        },
        navigateNewTab({ itemUrl }) {
            console.log('navigator.navigateNewTab', itemUrl);
            const windowReference = window.open(itemUrl, '_blank', 'noopener');

            if (windowReference) {
                windowReference.focus();
            }
        },
        navigateNewWindow({ itemUrl }) {
            console.log('navigator.navigateNewWindow', itemUrl);
            window.open(itemUrl, '_blank', 'noopener');
        },
    },
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

function CharItem({hit}) {
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
                    <strong>${hit.runs}</strong> public runs
                </div>
            </div>
        </div>
    </a>`;
}

function ItemItem({hit}) {
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
                    <strong>${formatIsk(hit.buyPrice)}</strong> - <strong>${formatIsk(hit.sellPrice)}</strong>
                </div>
            </div>
        </div>
    </a>`;
}

function EventItem({hit}) {
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
                    <strong>${hit.from}</strong> to <strong>${hit.to}</strong>
                </div>
            </div>
        </div>
    </a>`;
}


function TutorialItem({hit}) {
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
                    Created by <strong>${hit.creator}</strong>
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
