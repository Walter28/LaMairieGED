import { diffNodeType, elementDiffNodeType, elementNodeType, subsetType, textNodeType } from "../types";
import { Diff } from "../helpers";
export declare const uniqueInBoth: (l1: diffNodeType[], l2: diffNodeType[]) => {};
export declare const removeDone: (tree: elementDiffNodeType) => any;
export declare const cleanNode: (diffNode: diffNodeType) => elementNodeType | textNodeType;
export declare const isEqual: (e1: diffNodeType, e2: diffNodeType) => boolean;
export declare const roughlyEqual: (e1: diffNodeType, e2: diffNodeType, uniqueDescriptors: {
    [key: string]: boolean;
}, sameSiblings: boolean, preventRecursion?: boolean) => any;
/**
 * Generate arrays that indicate which node belongs to which subset,
 * or whether it's actually an orphan node, existing in only one
 * of the two trees, rather than somewhere in both.
 *
 * So if t1 = <img><canvas><br>, t2 = <canvas><br><img>.
 * The longest subset is "<canvas><br>" (length 2), so it will group 0.
 * The second longest is "<img>" (length 1), so it will be group 1.
 * gaps1 will therefore be [1,0,0] and gaps2 [0,0,1].
 *
 * If an element is not part of any group, it will stay being 'true', which
 * is the initial value. For example:
 * t1 = <img><p></p><br><canvas>, t2 = <b></b><br><canvas><img>
 *
 * The "<p></p>" and "<b></b>" do only show up in one of the two and will
 * therefore be marked by "true". The remaining parts are parts of the
 * groups 0 and 1:
 * gaps1 = [1, true, 0, 0], gaps2 = [true, 0, 0, 1]
 *
 */
export declare const getGapInformation: (t1: elementDiffNodeType, t2: elementDiffNodeType, stable: subsetType[]) => {
    gaps1: (number | true)[];
    gaps2: (number | true)[];
};
export declare const markSubTrees: (oldTree: elementDiffNodeType, newTree: elementDiffNodeType) => any[];
export declare class DiffTracker {
    list: Diff[];
    constructor();
    add(diffs: Diff[]): void;
    forEach(fn: (Diff: any) => void): void;
}
