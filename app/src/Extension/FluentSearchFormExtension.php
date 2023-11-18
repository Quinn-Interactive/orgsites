<?php

namespace Hamaka\Extensions;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\SS_List;
use TractorCow\Fluent\State\FluentState;

/**
 * Fixes FluentSearchForm
 *
 * Also, remember to add this to your config:
 *
 * ---
 * Name: fluentsearchfix
 * ---
 * SilverStripe\Core\Injector\Injector:
 *   SilverStripe\CMS\Search\SearchForm:
 *     class: Hamaka\Extensions\FluentSearchFormExtension
 */
class FluentSearchFormExtension extends SearchForm
{

    /**
     * Return dataObjectSet of the results using current request to get info from form.
     * Wraps around {@link searchEngine()}.
     *
     * @return SS_List
     */
    public function getResults()
    {

        // Get request data from request handler
        $request = $this->getRequestHandler()->getRequest();

        $keywords = $request->requestVar('Search');

        $andProcessor = function ($matches) {
            return ' +' . $matches[2] . ' +' . $matches[4] . ' ';
        };
        $notProcessor = function ($matches) {
            return ' -' . $matches[3];
        };

        $keywords = preg_replace_callback('/()("[^()"]+")( and )("[^"()]+")()/i', $andProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )([^() ]+)( and )([^ ()]+)( |$)/i', $andProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )(not )("[^"()]+")/i', $notProcessor, $keywords);
        $keywords = preg_replace_callback('/(^| )(not )([^() ]+)( |$)/i', $notProcessor, $keywords);

        $keywords = $this->addStarsToKeywords($keywords);

        $keywords = DB::get_conn()->escapeString($keywords);
        $htmlEntityKeywords = htmlentities($keywords, ENT_NOQUOTES, 'UTF-8');

        $current_locale = FluentState::singleton()->getLocale();
        $sitetree_table_localised = 'SiteTree_Localised_Live' ;
        $sitetreetables = 'SiteTree_Localised_Live.Title, SiteTree_Localised_Live.MenuTitle, SiteTree_Localised_Live.Content, SiteTree_Localised_Live.MetaDescription';

        $customResults = DB::query('SELECT DISTINCT SiteTree_Localised_Live.RecordID, SiteTree_Localised_Live.Title,SiteTree_Localised_Live.Content,SiteTree_Localised_Live.Locale,
                MATCH (' . $sitetreetables . ') AGAINST (\'' . str_replace(['*', '+', '-'], '', $keywords) . '\') AS Relevance
                FROM SiteTree_Localised_Live
                LEFT JOIN SiteTree_Live 
                ON SiteTree_Live.ID = ' . $sitetree_table_localised . '.RecordID AND ((' . $sitetree_table_localised . '.RecordID IS NOT NULL))
                WHERE (
                    MATCH (' . $sitetreetables . ') AGAINST (\'' . $keywords . '\' IN BOOLEAN MODE)
                    + MATCH (' . $sitetreetables . ') AGAINST (\'' . $htmlEntityKeywords . '\' IN BOOLEAN MODE)
                  )
                 ORDER BY Relevance DESC
                LIMIT 20;');

        $results = new ArrayList();

        foreach ($customResults as $record) {
            if($record['Locale'] == $current_locale) {
                $st = SiteTree::get_by_id($record['RecordID']);
                if (!empty($st) && $st->canView() && $st->ShowInSearch <> 0) {
                    $results->push($st);
                }
            }
        }

        return $results;
    }
}
