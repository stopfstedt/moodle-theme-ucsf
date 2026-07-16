<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme UCSF - custom Behat rules for banner alerts.
 *
 * @package theme_ucsf
 * @copyright The Regents of the University of California
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ExpectationException;
use Behat\Step\Then;
use Behat\Transformation\Transform;

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

/**
 * Steps definitions for testing banner alerts.
 * @package theme_ucsf
 * @copyright The Regents of the University of California
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_theme_ucsf_behat_banneralerts extends behat_base {
    /**
     * Asserts that a banner alert of a given type with a given text is present on the page.
     *
     * @param bool $isdismissible Whether the given alert is dismissible or not.
     * @param string $text The alert text.
     * @param string $typeclass The alert type.
     */
    #[Then('/^I should see the (dismissible|non-dismissible) "([^"]+)" (info|warning|announcement)$/')]
    public function i_should_see_the_banner_alert(bool $isdismissible, string $text, string $typeclass): void {
        $xpath = $this->get_xpath_to_alert($isdismissible, $text, $typeclass);
        $this->execute("behat_general::should_exist", [$xpath, "xpath_element"]);
    }

    /**
     * Asserts that a banner alert of a given type with the given text is not present on the page.
     *
     * @param bool $isdismissible Whether the given alert is dismissible or not.
     * @param string $text The alert text.
     * @param string $typeclass The alert type.
     */
    #[Then("/^I shouldn't see the (dismissible|non-dismissible) \"([^\"]+)\" (info|warning|announcement)$/")]
    public function i_shouldnt_see_the_banner_alert(bool $isdismissible, string $text, string $typeclass): void {
        $xpath = $this->get_xpath_to_alert($isdismissible, $text, $typeclass);
        $this->execute("behat_general::should_not_exist", [$xpath, "xpath_element"]);
    }

    /**
     * Transforms the 'dismissible' keyword into TRUE and 'non-dismissible' into FALSE.
     *
     * @param string $str The keyword
     * @return bool TRUE if the given word was 'dismissible', otherwise FALSE.
     */
    #[Transform('/^(dismissible|non-dismissible)$/')]
    public function transform_dismissible_keywords_to_boolean(string $str): bool {
        return 'dismissible' === $str;
    }

    /**
     * Maps the given alert type to a CSS class.
     * TODO: Stop repeating yourself by reusing the mapping already available in `theme_ucsf\output\banneralerts` [ST 2026/07/16].
     *
     * @param string $str The alert type.
     * @return string The mapped CSS class.
     */
    #[Transform('^(info|warning|announcement)$/')]
    public function transform_alert_types_to_css_class_names(string $str): string {
        return match ($str) {
            'info' => 'alert-info',
            'success' => 'alert-warning',
            'error' => 'alert-error',
        };
    }

    /**
     * Dismisses an alert with the given text.
     *
     * @param string $text The alert text.
     * @param string $type The alert type.
     */
    #[Then('/^I dismiss the "([^"]+)" (info|warning|announcement) banner$/')]
    public function i_dismiss_the_alert(string $text, string $type): void {
        // To be done.
    }

    /**
     * Finds and returns a banner alert on the page based on the given criteria.
     *
     * @param bool $isdismissible Whether the given alert is dismissible or not.
     * @param string $text The alert text.
     * @param string $typeclass The alert type CSS class.
     * @return NodeElement The alert's DOM element.
     * @throws ExpectationException
     */
    protected function find_alert(bool $isdismissible, string $text, string $typeclass): NodeElement {
        // We must escape single quotes, otherwise the xpath query might break.
        $escapedtext = str_replace("'", "\\'", $text);
        $xpath = "//div[contains(@class, 'ucsf-banneralerts-alert') and text()='{$escapedtext}']";
        $node = $this->find("behat_general::should_be_visible", [$xpath, "xpath_element"]);
        if (!$node) {
            throw new ExpectationException(
                "Banner alert with text `$text` not found.",
                $this->getSession()->getDriver()
            );
        }

        $nodeisdismissible = $node->hasClass('alert-dismissible');
        if ($isdismissible !== $nodeisdismissible) {
            throw new ExpectationException(
                $isdismissible
                    ? "Banner alert with text `$text` is expected to not be dismissible but is."
                    : "Banner alert with text `$text` is expected to be dismissible but isn't.",
                $this->getSession()->getDriver()
            );
        }

        if (!$node->hasClass($typeclass)) {
            throw new ExpectationException(
                "Banner alert with text `$text` is expected to have CSS class `$typeclass` but doesn't.",
                $this->getSession()->getDriver()
            );
        }

        return $node;
    }

    /**
     * Builds a xpath expression for finding a banner alert on the page by the given parameters.
     * @param bool $isdismissible Whether the alert is dismissible or not.
     * @param string $text The alert text.
     * @param string $typeclass The alert type CSS class.
     * @return string The generated xpath expression.
     */
    protected function get_xpath_to_alert(bool $isdismissible, string $text, string $typeclass): string
    {
        $escapedtext = str_replace("'", "\\'", $text);
        $rhett = "//div[contains(@class, 'ucsf-banneralerts-alert'";
        $rhett .= " and contains(@class, '{$typeclass}')";
        if ($isdismissible) {
            $rhett .= " and contains(@class, 'alert-dismissible')";
        } else {
            $rhett .= " and not(contains(@class, 'alert-dismissible'))";
        }
        $rhett .= " and text()='{$escapedtext}'";
        $rhett .= ']';
        return $rhett;
    }
}
