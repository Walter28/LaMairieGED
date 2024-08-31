import { DiffDOMOptions, diffNodeType, elementDiffNodeType, elementNodeType, subsetType } from "../types";
import { DiffTracker } from "./helpers";
import { Diff } from "../helpers";
export declare class DiffFinder {
    debug: boolean;
    diffcount: number;
    foundAll: boolean;
    options: DiffDOMOptions;
    t1: elementDiffNodeType;
    t1Orig: elementNodeType;
    t2: elementDiffNodeType;
    t2Orig: elementNodeType;
    tracker: DiffTracker;
    constructor(t1Node: string | elementNodeType | Element, t2Node: string | elementNodeType | Element, options: DiffDOMOptions);
    init(): Diff[];
    findDiffs(t1: elementDiffNodeType, t2: elementDiffNodeType): Diff[];
    findNextDiff(t1: diffNodeType, t2: diffNodeType, route: number[]): any;
    findOuterDiff(t1: diffNodeType, t2: diffNodeType, route: number[]): any[];
    findInnerDiff(t1: elementDiffNodeType, t2: elementDiffNodeType, route: number[]): Diff[];
    attemptGroupRelocation(t1: elementDiffNodeType, t2: elementDiffNodeType, subtrees: subsetType[], route: number[], cachedSubtrees: boolean): any[];
    findValueDiff(t1: elementDiffNodeType, t2: elementDiffNodeType, route: number[]): any[];
}
