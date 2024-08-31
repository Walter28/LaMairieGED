import { DiffDOMOptions, diffType } from "../types";
import { Diff } from "../helpers";
export declare function applyDiff(tree: Element, diff: diffType, options: DiffDOMOptions): boolean;
export declare function applyDOM(tree: Element, diffs: (Diff | diffType)[], options: DiffDOMOptions): boolean;
