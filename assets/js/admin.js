/**
 * Add a new row in the results table.
 *
 * We will allow the user to add a new results
 * to the frontend.
 *
 * @since 0.1.0
 */
function RMR_addResult( metaboxId ) {
    let resultsBodyEl = document.getElementById( `rmr-results-for-${metaboxId}` );

    let rowEl = '<tr>';
    rowEl    += `<td> <input type="text" name="${metaboxId}[title][]" class="large-text widefat" /> </td>`;
    rowEl    += `<td> <textarea name="${metaboxId}[content][]" class="large-text widefat"></textarea> </td>`;
    rowEl    += '</tr>';

    resultsBodyEl.innerHTML += rowEl;
}
